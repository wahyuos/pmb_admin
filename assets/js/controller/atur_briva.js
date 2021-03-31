/**
 * JS BRIVA
 * 
 * Untuk mengelola info BRIVA
 * 
 * @package		CodeIgniter
 * @subpackage	Controller
 * @category	JavaScript
 * @author Wahyu Kamaludin
 */

// simpan
const f_briva = document.getElementById('f_briva');
f_briva.addEventListener('submit', function (event) {
    event.preventDefault();
    const value = new FormData(f_briva);
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
        const response = await fetch(site_url + 'atur_briva/simpan', options);
        const json = await response.json();
        // console.log(json);
        // jika status true
        if (json.status) {
            // reload
            btnSubmit.textContent = "sedang mengalihkan...";
            notif(json.message, json.type);
            setTimeout(function () {
                location.href = site_url + 'atur_briva';
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

// tombol edit
function edit(id) {
    document.getElementById('card_form').style.display = 'block';
    const url = site_url + "atur_briva/getData/" + id;
    return fetch(url)
        .then((result) => result.json())
        .then((response) => {
            const data = response;
            document.getElementById("urlApi").value = data.urlApi;
            document.getElementById("kodeInstitusi").value = data.kodeInstitusi;
            document.getElementById("kodebriva").value = data.kodebriva;
            document.getElementById("biayaDaftar").value = data.biayaDaftar;
            document.getElementById("ketBayar").value = data.ketBayar;
            document.getElementById("client_id").value = data.client_id;
            document.getElementById("secret_id").value = data.secret_id;
            document.getElementById("urlApi").focus();
            document.getElementById("batal").style.display = 'inline';
        });
}
