/**
 * JS Bukti Bayar
 * 
 * Untuk memverifikasi data bukti_bayar
 * 
 * @package		CodeIgniter
 * @subpackage	Controller
 * @category	JavaScript
 * @author Wahyu Kamaludin
 */

// Datatables
document.addEventListener("DOMContentLoaded", function () {
    $("#dt-bukti_bayar").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        order: [],
        ajax: {
            url: site_url + "bukti_bayar/get_data",
            type: "POST",
        },
        columnDefs: [{
            targets: [0],
            orderable: false,
        },
        {
            targets: [0, 3],
            className: "text-center",
        },
        ],
        // scrollY: 280,
        scrollCollapse: true,
        pagingType: "full_numbers",
        language: {
            search: "Cari:",
            lengthMenu: "_MENU_ data",
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
});

// Status diterima
async function status_diterima(id) {
    let data = {
        'id_akun': id
    };
    const options = {
        method: 'POST',
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
    };
    try {
        const response = await fetch(site_url + 'bukti_bayar/status_diterima', options);
        const json = await response.json();
        // console.log(json);
        if (json.status) {
            // reload tabel
            $('#dt-bukti_bayar').DataTable().ajax.reload();
            // tampil notif
            notif(json.message, json.type);
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

// fungsi untuk melihat bukti bayar
async function lihat(id) {
    let data = {
        'id_akun': id
    };
    const options = {
        method: 'POST',
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
    };
    try {
        const response = await fetch(site_url + 'bukti_bayar/lihat', options);
        const json = await response.json();
        // console.log(json);
        // tampilkan card
        document.getElementById('card').style.display = 'inline';
        // tampilkan atribut peserta
        document.getElementById('nama_akun').textContent = json.nama_akun;
        document.getElementById('bukti_bayar').innerHTML = '<img class="rounded-md" src="data:' + json.file_type + ';base64,' + json.file_blob + '" width="100%" height="auto">';
        // status diterima
        if (json.verifikasi == 'Y') {
            document.getElementById('verifikasi').innerHTML = '<span class="badge badge-success">Diterima</span>';
        } else {
            document.getElementById('verifikasi').innerHTML = '<span class="badge badge-secondary">Pending</span>';
        }

    } catch (error) {
        console.log(error);
    }
}