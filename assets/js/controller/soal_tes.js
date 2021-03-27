/**
 * JS Data Soal (hanya admin)
 * 
 * Untuk mengelola (CRUD) data soal
 * 
 * @package		CodeIgniter
 * @subpackage	Controller
 * @category	JavaScript
 * @author Wahyu Kamaludin
 */

// load datatable
$('#dt-soal').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
        url: site_url + "soal_tes/get_data",
        type: "POST",
    },
    columnDefs: [{
        targets: [0],
        orderable: false,
    },
    {
        targets: [0, 2],
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
const f_soal = document.getElementById('f_soal');
f_soal.addEventListener('submit', function (event) {
    event.preventDefault();
    const value = new FormData(f_soal);
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
        const response = await fetch(site_url + 'soal_tes/simpan', options);
        const json = await response.json();
        // console.log(json);
        // jika status true
        if (json.status) {
            // reset form
            f_soal.reset();
            document.getElementById('id_soal').value = null;
            document.getElementById("pertanyaan").focus();
            document.getElementById("batal").style.display = 'none';
            // reload tabel
            $('#dt-soal').DataTable().ajax.reload();
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
    const url = site_url + "soal_tes/getDataById/" + id;
    return fetch(url)
        .then((result) => result.json())
        .then((response) => {
            const data = response;
            document.getElementById("id_soal").value = data.id_soal;
            // document.getElementById("pertanyaan").value = data.pertanyaan;
            document.getElementById("text_pertanyaan").value = data.pertanyaan;
            $('.ql-editor').html(data.pertanyaan);
            document.getElementById("opsi_a").value = data.opsi_a;
            document.getElementById("opsi_b").value = data.opsi_b;
            document.getElementById("opsi_c").value = data.opsi_c;
            document.getElementById("opsi_d").value = data.opsi_d;
            document.getElementById("opsi_e").value = data.opsi_e;
            document.getElementById("jawaban").value = data.jawaban;
            document.getElementById("pertanyaan").focus();
            document.getElementById("batal").style.display = 'inline';
        });
}

// tombol hapus
async function hapus(id, name) {
    // data dalam bentuk json
    const data = {
        'id_soal': id,
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
        const response = await fetch(site_url + "soal_tes/hapus/", options);
        const json = await response.json();
        // console.log(json);
        // jika status true
        if (json.status) {
            // tampil notif
            notif(json.message, json.type);
            //reload table
            $('#dt-soal').DataTable().ajax.reload();
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