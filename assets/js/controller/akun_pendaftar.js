/**
 * JS Data Pengguna (hanya admin)
 * 
 * Untuk mengelola (CRUD) data pengguna
 * 
 * @package		CodeIgniter
 * @subpackage	Controller
 * @category	JavaScript
 * @author Wahyu Kamaludin
 */

// load datatable
$('#dt-akun_pendaftar').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
        url: site_url + "akun_pendaftar/get_data",
        type: "POST",
    },
    columnDefs: [{
        targets: [0],
        orderable: false,
    },
    {
        targets: [0, 4, 5],
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

// tombol reset password
async function reset(id) {
    // data dalam bentuk json
    const data = {
        'id_akun': id,
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
        const response = await fetch(site_url + "akun_pendaftar/reset/", options);
        const json = await response.json();
        // console.log(json);
        // jika status true
        if (json.status) {
            // tampil notif
            notif(json.message, json.type);
            //reload table
            $('#dt-akun_pendaftar').DataTable().ajax.reload();
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

// tombol hapus
async function hapus(id) {
    // data dalam bentuk json
    const data = {
        'id_akun': id,
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
        const response = await fetch(site_url + "akun_pendaftar/hapus/", options);
        const json = await response.json();
        // console.log(json);
        // jika status true
        if (json.status) {
            // tampil notif
            notif(json.message, json.type);
            //reload table
            $('#dt-akun_pendaftar').DataTable().ajax.reload();
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