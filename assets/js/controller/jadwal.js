/**
 * JS Jadwal Pendaftaran
 * 
 * Untuk mengelola (CRUD) data jadwal pendaftaran
 * 
 * @package		CodeIgniter
 * @subpackage	Controller
 * @category	JavaScript
 * @author Wahyu Kamaludin
 */

// load datatable
$('#dt-jadwal').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
        url: site_url + "jadwal/get_data",
        type: "POST",
    },
    columnDefs: [{
        targets: [0, 7],
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
const f_jadwal = document.getElementById('f_jadwal');
f_jadwal.addEventListener('submit', function (event) {
    event.preventDefault();
    const value = new FormData(f_jadwal);
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
        const response = await fetch(site_url + 'jadwal/simpan', options);
        const json = await response.json();
        // console.log(json);
        // jika status true
        if (json.status) {
            // reset form
            f_jadwal.reset();
            document.getElementById('id_jadwal').value = null;
            document.getElementById("nama_gelombang").focus();
            document.getElementById("batal").style.display = 'none';
            // reload tabel
            $('#dt-jadwal').DataTable().ajax.reload();
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
    const url = site_url + "jadwal/getDataById/" + id;
    return fetch(url)
        .then((result) => result.json())
        .then((response) => {
            const data = response;
            document.getElementById("id_jadwal").value = data.id_jadwal;
            document.getElementById("nama_gelombang").value = data.nama_gelombang;
            document.getElementById("jalur_" + data.jalur).checked = true;
            document.getElementById("periode_awal").value = data.periode_awal;
            document.getElementById("periode_akhir").value = data.periode_akhir;
            document.getElementById("tahun_akademik").value = data.tahun_akademik;
            document.getElementById("nama_tes1").value = data.nama_tes1;
            document.getElementById("tanggal_tes1").value = data.tanggal_tes1;
            document.getElementById("nama_tes2").value = data.nama_tes2;
            document.getElementById("tanggal_tes2").value = data.tanggal_tes2;
            document.getElementById("batas_reg_ulang").value = data.batas_reg_ulang;
            document.getElementById("nama_gelombang").focus();
            document.getElementById("batal").style.display = 'inline';
        });
}

// tombol hapus
async function hapus(id, name) {
    // data dalam bentuk json
    const data = {
        'id_jadwal': id,
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
        const response = await fetch(site_url + "jadwal/hapus/", options);
        const json = await response.json();
        // console.log(json);
        // jika status true
        if (json.status) {
            // tampil notif
            notif(json.message, json.type);
            //reload table
            $('#dt-jadwal').DataTable().ajax.reload();
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