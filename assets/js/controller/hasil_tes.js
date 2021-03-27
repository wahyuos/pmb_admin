/**
 * JS Hasil Tes Tulis
 * 
 * Untuk melihathasil tes tulis
 * 
 * @package		CodeIgniter
 * @subpackage	Controller
 * @category	JavaScript
 * @author Wahyu Kamaludin
 */

// Datatables
document.addEventListener("DOMContentLoaded", function () {
    $("#dt-hasil_tes").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        order: [],
        ajax: {
            url: site_url + "hasil_tes/get_data",
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