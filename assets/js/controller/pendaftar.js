/**
 * JS Pendaftaran
 * 
 * Untuk mengelola (CRUD) data pendaftaran
 * 
 * @package		CodeIgniter
 * @subpackage	Controller
 * @category	JavaScript
 * @author Wahyu Kamaludin
 */

// Datatables
document.addEventListener("DOMContentLoaded", function () {
    $("#dt-pendaftar").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        order: [],
        ajax: {
            url: site_url + "pendaftar/get_data",
            type: "POST",
        },
        columnDefs: [{
            targets: [0],
            orderable: false,
        },
        {
            targets: [0, 5],
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
        const response = await fetch(site_url + 'pendaftar/status_diterima', options);
        const json = await response.json();
        console.log(json);
        if (json.status) {
            // reload tabel
            $('#dt-pendaftar').DataTable().ajax.reload();
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

// simpan pendaftaran
const f_tambah_pendaftar = document.getElementById('f_tambah_pendaftar');
// cek apakah form ada?
if (f_tambah_pendaftar) {
    // lakukan proses simpan saat submit
    f_tambah_pendaftar.addEventListener('submit', function (event) {
        event.preventDefault();
        const value = new FormData(f_tambah_pendaftar);
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
            const response = await fetch(site_url + 'pendaftar/simpan_pendaftaran', options);
            const json = await response.json();
            console.log(json);
            // jika status true
            if (json.status) {
                // reset form
                f_tambah_pendaftar.reset();
                // tampil notif
                notif(json.message, json.type);
                // aktifkan tombol
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = "SIMPAN";
                // reload
                setTimeout(function () {
                    location.href = site_url + 'pendaftar';
                }, 2000);
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
}

// fungsi untuk melihat data peserta dari baris tabel
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
        const response = await fetch(site_url + 'pendaftar/lihat', options);
        const json = await response.json();
        // console.log(json);
        // tampilkan card
        document.getElementById('card').style.display = 'inline';
        // tampilkan atribut peserta
        document.getElementById('nm_pd').textContent = json.nm_pd;
        document.getElementById('sekolah_asal').textContent = json.sekolah;
        document.getElementById('no_hp').textContent = json.no_hp;
        document.getElementById('no_hp_ortu').textContent = json.no_hp_ortu;
        // status diterima
        if (json.status_diterima == '1') {
            document.getElementById('status_diterima').innerHTML = '<span class="badge badge-success">Diterima</span>';
        } else {
            document.getElementById('status_diterima').innerHTML = '<span class="badge badge-secondary">Pending</span>';
        }
        // link untuk detail
        document.getElementById('btn_detail').href = site_url + 'pendaftar/detail/' + json.id_pd;

    } catch (error) {
        console.log(error);
    }
}

// aksi form edit pendaftar
const f_edit = document.getElementById('f_edit');
// cek apakah form ada?
if (f_edit) {
    // lakukan proses simpan saat submit
    f_edit.addEventListener('submit', function (event) {
        event.preventDefault();
        const value = new FormData(f_edit);
        sendData(value);
    });

    async function sendData(value) {
        const id_akun = document.getElementById('id_akun').value;
        const method = document.getElementById('method').value;
        const btnSubmit = document.getElementById('submit');
        const options = {
            method: 'POST',
            body: value
        };
        try {
            btnSubmit.disabled = true;
            btnSubmit.textContent = "menyimpan...";
            const response = await fetch(site_url + 'pendaftar/' + method + '/' + id_akun, options);
            const json = await response.json();
            // console.log(json);
            // jika status true
            if (json.status) {
                // tampil notif
                notif(json.message, json.type);
                // text button
                btnSubmit.textContent = "sedang mengalihkan...";
                // reload
                setTimeout(function () {
                    location.href = site_url + 'pendaftar/detail/' + id_akun;
                }, 1000);
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
        const response = await fetch(site_url + "pendaftar/hapus_pendaftaran/", options);
        const json = await response.json();
        console.log(json);
        // jika status true
        if (json.status) {
            // tampil notif
            notif(json.message, json.type);
            const dt = document.getElementById('dt-pendaftar');
            if (dt) {
                // reload tabel
                $('#dt-pendaftar').DataTable().ajax.reload();
            } else {
                // reload
                setTimeout(function () {
                    location.href = site_url + 'pendaftar';
                }, 1000);
            }
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


/**
 * ===================================================================================
 * FUNGSI UNTUK MENCARI DAN MENAMPILKAN PROPINSI
 * ===================================================================================
 */
const list_prov = document.getElementById('list_provinsi');
const id_prov = document.getElementById('id_prov');
const nm_prov = document.getElementById('nm_prov');
// cek apakah ada inputan provinsi
if (list_prov) {
    // disable input kab/kota
    document.getElementById('nm_kab').disabled = true;
    document.getElementById('nm_wil').disabled = true;
    // proses mencari data provinsi pada saat mulai mengetik
    nm_prov.onkeyup = function () {
        // data yang akan dikirim dalam bentuk json
        const keyword = {
            'keyword': nm_prov.value,
            'wilayah': 'provinsi',
            'induk': '000000'
        }
        // proses mengirim data dengan POST
        fetch(site_url + 'pendaftar/cek_wilayah', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify(keyword)
        })
            // ambil respon dalam bentuk json
            .then(res => res.text())
            // simpan data dalam variabel teks
            .then(teks => {
                // jika tidak ada huruf dalam kolom
                if (nm_prov.value == "") {
                    // atur label keterangan
                    list_prov.style.display = "inline";
                    list_prov.innerHTML = '';
                    document.getElementById('nm_kab').disabled = true;
                }
                // jika masih ada huruf
                else {
                    // tampilkan data
                    list_prov.style.display = "inline";
                    list_prov.innerHTML = teks;
                }
            })
            // tampilkan error yang terjadi
            .catch(err => list_data.innerHTML = err);
    }

    // fungsi untuk menampilkan data provinsi ke dalam kolom input saat mengklik provinsi
    function select_prov(id, prov) {
        // hilangkan list kecamatan
        list_prov.style.display = "none";
        list_prov.innerHTML = "";
        // simpan id provinsi dalam value input id_prov untuk disimpan
        id_prov.value = id;
        // tampilkan nama provinsi dalam value input nm_prov agar tetap terlihat nama provinsi yang dipilih
        nm_prov.value = prov.trim();
        // aktifkan input kab/kota
        document.getElementById('nm_kab').disabled = false;
        document.getElementById('nm_kab').focus();
    }
}

/**
 * ===================================================================================
 * FUNGSI UNTUK MENCARI DAN MENAMPILKAN KABUPATEN ATAU KOTA
 * ===================================================================================
 */
const list_kab_kota = document.getElementById('list_kabupaten');
const id_kab_kota = document.getElementById('id_kab');
const nm_kab_kota = document.getElementById('nm_kab');
// cek apakah ada inputan kabupaten
if (list_kab_kota) {
    // proses mencari data kabupaten/kota pada saat mulai mengetik
    nm_kab_kota.onkeyup = function () {
        // data yang akan dikirim dalam bentuk json
        const keyword = {
            'keyword': nm_kab_kota.value,
            'wilayah': 'kabupaten/kota',
            'induk': id_prov.value
        }
        // proses mengirim data dengan POST
        fetch(site_url + 'pendaftar/cek_wilayah', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify(keyword)
        })
            // ambil respon dalam bentuk json
            .then(res => res.text())
            // simpan data dalam variabel teks
            .then(teks => {
                // jika tidak ada huruf dalam kolom
                if (nm_kab_kota.value == "") {
                    // atur label keterangan
                    list_kab_kota.style.display = "inline";
                    list_kab_kota.innerHTML = '';
                    document.getElementById('nm_wil').disabled = true;
                }
                // jika masih ada huruf
                else {
                    // tampilkan data
                    list_kab_kota.style.display = "inline";
                    list_kab_kota.innerHTML = teks;
                }
            })
            // tampilkan error yang terjadi
            .catch(err => list_data.innerHTML = err);
    }

    // fungsi untuk menampilkan data kabupaten/kota ke dalam kolom input saat mengklik kabupaten/kota
    function select_kab_kota(id, kab_kota) {
        // hilangkan list kecamatan
        list_kab_kota.style.display = "none";
        list_kab_kota.innerHTML = "";
        // simpan id kabupaten/kota dalam value input id_prov untuk disimpan
        id_kab_kota.value = id;
        // tampilkan nama kabupaten/kota dalam value input nm_prov agar tetap terlihat nama kabupaten/kota yang dipilih
        nm_kab_kota.value = kab_kota.trim();
        // aktifkan input kecamatan
        document.getElementById('nm_wil').disabled = false;
        document.getElementById('nm_wil').focus();
    }
}

/**
 * ===================================================================================
 * FUNGSI UNTUK MENCARI DAN MENAMPILKAN KECAMATAN
 * ===================================================================================
 */
const list_kec = document.getElementById('list_kecamatan');
const id_kec = document.getElementById('id_wil');
const nm_kec = document.getElementById('nm_wil');
// cek apakah ada inputan kecamatan
if (list_kec) {
    // proses mencari data kecamatan pada saat mulai mengetik
    nm_kec.onkeyup = function () {
        // data yang akan dikirim dalam bentuk json
        const keyword = {
            'keyword': nm_kec.value,
            'wilayah': 'kecamatan',
            'induk': id_kab_kota.value
        }
        // proses mengirim data dengan POST
        fetch(site_url + 'pendaftar/cek_wilayah', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify(keyword)
        })
            // ambil respon dalam bentuk json
            .then(res => res.text())
            // simpan data dalam variabel teks
            .then(teks => {
                // jika tidak ada huruf dalam kolom
                if (nm_kec.value == "") {
                    // atur label keterangan
                    list_kec.style.display = "inline";
                    list_kec.innerHTML = '';
                }
                // jika masih ada huruf
                else {
                    // tampilkan data
                    list_kec.style.display = "inline";
                    list_kec.innerHTML = teks;
                }
            })
            // tampilkan error yang terjadi
            .catch(err => list_data.innerHTML = err);
    }

    // fungsi untuk menampilkan data kecamatan ke dalam kolom input saat mengklik kecamatan
    function select_kec(id, kec) {
        // hilangkan list kecamatan
        list_kec.style.display = "none";
        list_kec.innerHTML = "";
        // simpan id kecamatan dalam value input id_prov untuk disimpan
        id_kec.value = id;
        // tampilkan nama kecamatan dalam value input nm_prov agar tetap terlihat nama kecamatan yang dipilih
        nm_kec.value = kec.trim();
    }
}

// fungsi untuk notifikasi
function notif(pesan, tipe) {
    const message = pesan;
    const type = tipe;
    const duration = 3000;
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