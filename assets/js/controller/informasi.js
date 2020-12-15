/**
 * JS Informasi
 * 
 * Untuk mengelola (CRUD) data informasi
 * 
 * @package		CodeIgniter
 * @subpackage	Controller
 * @category	JavaScript
 * @author Wahyu Kamaludin
 */

// load datatable
$('#dt-informasi').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
        url: site_url + "informasi/get_data",
        type: "POST",
    },
    columnDefs: [{
        targets: [0],
        orderable: false,
    },
    {
        targets: [0],
        className: "text-center",
    },
    ],
    // scrollY: 280,
    scrollCollapse: true,
    pagingType: "full_numbers",
    language: {
        search: "Cari:",
        lengthMenu: "_MENU_ baris",
        emptyTable: "Belum ada data",
        zeroRecords: "Data tidak ditemukan",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        infoEmpty: "",
        infoFiltered: "",
        paginate: {
            first: "&laquo;",
            last: "&raquo;",
            next: "&rsaquo;",
            previous: "&lsaquo;",
        },
    }
});

// simpan
const f_informasi = document.getElementById('f_informasi');
f_informasi.addEventListener('submit', function (event) {
    event.preventDefault();
    const value = new FormData(f_informasi);
    sendData(value);
});

async function sendData(value) {
    const btnSubmit = document.getElementById('submit');
    const options = {
        method: 'POST',
        body: value
    };
    try {
        btnSubmit.disabled = true;
        btnSubmit.textContent = "menyimpan...";
        const response = await fetch(site_url + 'informasi/simpan', options);
        const json = await response.json();
        // console.log(json);
        // jika status true
        if (json.status) {
            // reset form
            f_informasi.reset();
            document.getElementById('id_informasi').value = null;
            document.getElementById("judul_informasi").focus();
            document.getElementById("batal").style.display = 'none';
            // reload tabel
            $('#dt-informasi').DataTable().ajax.reload();
            // tampil notif
            notif(json.message, json.type);
            // aktifkan tombol
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = "SIMPAN";
        } else {
            // tampil notif
            notif(json.message, json.type);
            // aktifkan tombol
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = "SIMPAN";
        }
    } catch (error) {
        console.log(error);
        // tampil notif
        notif(error, 'error');
        // aktifkan tombol
        btnSubmit.disabled = false;
        btnSubmit.innerHTML = "SIMPAN";
    }
}

// tombol edit
function edit(id) {
    const url = site_url + "informasi/getDataById/" + id;
    return fetch(url)
        .then((result) => result.json())
        .then((response) => {
            const data = response;
            document.getElementById("id_informasi").value = data.id_informasi;
            document.getElementById("judul_informasi").value = data.judul_informasi;
            document.getElementById("isi_informasi").value = data.isi_informasi;
            document.getElementById("judul_informasi").focus();
            document.getElementById("batal").style.display = 'inline';
        });
}

// tombol hapus
async function hapus(id,) {
    // data dalam bentuk json
    const data = {
        'id_informasi': id,
    };

    // kirim data
    const options = {
        method: 'POST',
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    try {
        const response = await fetch(site_url + "informasi/hapus/", options);
        const json = await response.json();
        // console.log(json);
        // jika status true
        if (json.status) {
            // tampil notif
            notif(json.message, json.type);
            //reload table
            $('#dt-informasi').DataTable().ajax.reload();
        } else {
            // tampil notif
            notif(json.message, json.type);
        }
    } catch (error) {
        console.log(error);
        // tampil notif
        notif(error, 'error');
    }
}

// fungsi untuk notifikasi
function notif(pesan, tipe) {
    const message = pesan;
    const type = tipe;
    const duration = 5000;
    const ripple = true;
    const dismissible = true;
    const positionX = 'center';
    const positionY = 'top';
    window.notyf.open({
        type,
        message,
        duration,
        ripple,
        dismissible,
        position: {
            x: positionX,
            y: positionY
        }
    });
}