/**
 * JS Data Mitra
 * 
 * Untuk mengelola (CRUD) data mitra
 * 
 * @package		CodeIgniter
 * @subpackage	Controller
 * @category	JavaScript
 * @author Wahyu Kamaludin
 */

// load datatable
$('#dt-mitra').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
        url: site_url + "mitra/get_data",
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
const f_mitra = document.getElementById('f_mitra');
f_mitra.addEventListener('submit', function (event) {
    event.preventDefault();
    const value = new FormData(f_mitra);
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
        const response = await fetch(site_url + 'mitra/simpan', options);
        const json = await response.json();
        // console.log(json);
        // jika status true
        if (json.status) {
            // reset form
            f_mitra.reset();
            document.getElementById('id_user').value = null;
            document.getElementById("nama_user").focus();
            document.getElementById("batal").style.display = 'none';
            // reload tabel
            $('#dt-mitra').DataTable().ajax.reload();
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
    const url = site_url + "mitra/getDataById/" + id;
    return fetch(url)
        .then((result) => result.json())
        .then((response) => {
            const data = response;
            document.getElementById("id_user").value = data.id_user;
            document.getElementById("nama_user").value = data.nama_user;
            document.getElementById("instansi").value = data.instansi;
            document.getElementById("username").value = data.username;
            document.getElementById("nama_user").focus();
            document.getElementById("password").required = false;
            document.getElementById("batal").style.display = 'inline';
            document.getElementById("info_pass").style.display = 'inline';
        });
}

// tombol hapus
async function hapus(id, name) {
    // data dalam bentuk json
    const data = {
        'id_user': id,
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
        const response = await fetch(site_url + "mitra/hapus/", options);
        const json = await response.json();
        // console.log(json);
        // jika status true
        if (json.status) {
            // tampil notif
            notif(json.message, json.type);
            //reload table
            $('#dt-mitra').DataTable().ajax.reload();
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