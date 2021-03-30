<div class="row  d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?= $title ?></h5>
                <h6 class="card-subtitle text-muted">Masukkan Nomor Virtual Account pada kolom dibawah, kemudian tekan Enter atau tombol CARI</h6>
            </div>
            <div class="card-body">
                <form class="form-inline mb-3" id="cari_va" autocomplete="off">
                    <label class="sr-only" for="nomor_va">Nomor Virtual Account</label>
                    <input type="number" name="nomor_va" required autofocus class="form-control mb-2 mr-sm-2 col-lg-5" id="nomor_va" placeholder="Nomor Virtual Account">

                    <button type="submit" id="cari" class="btn btn-primary mb-2">CARI</button>
                </form>
                <hr>
                <div class="clearfix" id="status"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const myForm = document.getElementById('cari_va');
    myForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const value = new FormData(myForm);
        sendData(value);
    });

    async function sendData(value) {
        const btnSimpan = document.getElementById('cari');
        const options = {
            method: 'POST',
            body: value
        };
        try {
            btnSimpan.disabled = true;
            btnSimpan.textContent = "mencari...";
            const response = await fetch(site_url + 'cek_bayar/status_va', options);
            const json = await response.json();
            if (json.status) {
                // console.log(json);
                btnSimpan.disabled = false;
                btnSimpan.textContent = "CARI";
                // status bayar
                let status_bayar = (json.data.statusBayar == 'Y' ? '<span class="text-success font-weight-bold">Sudah Dibayar</span>' : '<span class="text-danger font-weight-bold">Belum Dibayar</span>');
                // tampilkan data
                let nomor_va = "Nomor VA : " + json.data.BrivaNo + json.data.CustCode + '<br>';
                let nama = "Nama Pendaftar : " + json.data.Nama + '<hr>';
                let status = "Status Pembayaran : " + status_bayar + '<br>';
                document.getElementById('status').innerHTML = nomor_va + nama + status;
            } else {
                // console.log(json);
                btnSimpan.disabled = false;
                btnSimpan.textContent = "CARI";
                // tampilkan data
                document.getElementById('status').innerHTML = json.errDesc;
            }
        } catch (error) {
            console.log(error);
            document.getElementById('status').innerHTML = error;
            btnSimpan.disabled = false;
            btnSimpan.textContent = "CARI";
        }
    }
</script>