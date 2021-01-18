<div class="row">
    <div class="col-12 col-xl-6">
        <div class="card">
            <div class="card-header mb-0">
                <h5 class="card-title mb-2">Upload Pas Foto</h5>
                <p class="mb-0">File gambar (.jpg / .jpeg / .png) maksimal 200KB</p>
            </div>
            <div class="card-body">
                <form id="f_doc_foto" enctype="multipart/form-data" autocomplete="off">
                    <input id="id_akun" name="id_akun" type="hidden" value="<?= $this->uri->segment(3) ?>">
                    <input id="id_jns_persyaratan" name="id_jns_persyaratan" type="hidden" value="<?= $this->uri->segment(4) ?>">
                    <div class="form-group overflow-hidden">
                        <h5>Ketentuan Foto yang diupload</h5>
                        <ul class="form-label w-100">
                            <li>Foto merupakan foto resmi, tidak boleh foto selfie.</li>
                            <li>Gunakan file foto asli, bukan foto dari lembar foto yang sudah dicetak. Jika file foto tidak ada, crop foto terlebih dahulu sebelum diupload.</li>
                        </ul>
                        <label for="file_foto" class="form-label w-100">Silahkan pilih file foto</label>
                        <input type="file" onchange="loadFile(event)" name="file_persyaratan" accept="image/x-png,image/jpg,image/jpeg" id="file_foto">
                        <div id="alert" class="text-danger mt-3"></div>
                    </div>
                    <hr>
                    <button type="submit" id="simpan" class="btn btn-primary">UPLOAD</button>
                    <a href="<?= site_url('pendaftar/detail/' . $this->uri->segment(3)) ?>" class="btn btn-secondary float-right">KEMBALI</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="list-group mb-3 mt-2 rounded-lg">
                    <?php if ($doc_foto) : ?>
                        <div class="list-group-item text-center p-3">
                            <h6 id="title" class="mb-2">Foto telah diupload</h6>
                            Pastikan foto terlihat jelas dan mudah dikenali
                        </div>
                        <div class="list-group-item text-center p-3">
                            <img id="preview" class="rounded-md" src="data:<?= $doc_foto->type_doc ?>;base64,<?= $doc_foto->blob_doc ?>" width="50%" height="auto">
                        </div>
                    <?php else : ?>
                        <div class="list-group-item text-center p-3">
                            <h6 id="title" class="mb-2">Preview</h6>
                            Pastikan foto terlihat jelas dan mudah dikenali
                        </div>
                        <div class="list-group-item text-center p-3">
                            <img id="preview" class="rounded-md" src="<?= base_url('assets/img/contoh-foto.jpg') ?>" width="50%" height="auto">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const id_akun = document.getElementById('id_akun');
    const alert = document.getElementById('alert');
    const myForm = document.getElementById('f_doc_foto');
    const btnSimpan = document.getElementById('simpan');
    btnSimpan.disabled = true;
    const loadFile = function(event) {
        const gmb = event.target.files[0];
        const preview = document.getElementById('preview');
        // cek type gambar
        if (gmb.type.match('image.png') || gmb.type.match('image.jpg') || gmb.type.match('image.jpeg')) {
            // cek ukuran gambar
            if (gmb.size < 204800) { // 200KB
                // tampilkan gambar
                preview.src = URL.createObjectURL(event.target.files[0]);
                document.getElementById('title').textContent = 'Preview';
                btnSimpan.disabled = false;
                alert.innerHTML = "";
            } else {
                alert.innerHTML = "Ukuran file terlalu besar. Maksimal 200KB";
                preview.src = "";
                myForm.reset();
            }
        } else {
            alert.innerHTML = "File tidak didukung. Gunakan gambar dengan type .png .jpg .jpeg";
            preview.src = "";
            myForm.reset();
        }
    };

    myForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const value = new FormData(myForm);
        sendData(value);
    });

    async function sendData(value) {
        const options = {
            method: 'POST',
            body: value
        };
        try {
            btnSimpan.disabled = true;
            btnSimpan.textContent = "menyimpan...";
            const response = await fetch(site_url + 'persyaratan/simpan', options);
            const json = await response.json();
            // console.log(json);
            if (json.status == true) {
                const id_akun = document.getElementById('id_akun').value;
                // tampil notif
                notif(json.message, json.type);
                // reload
                btnSimpan.textContent = "sedang mengalihkan...";
                setTimeout(function() {
                    location.href = site_url + 'pendaftar/detail/' + id_akun;
                }, 1000);
            } else {
                // tampil notif
                notif(json.message, json.type);
                btnSimpan.disabled = false;
                btnSimpan.textContent = "UPLOAD";
            }
        } catch (error) {
            // console.log(error);
            alert.innerHTML = error;
            // tampil notif
            notif(error, 'error');
            btnSimpan.disabled = false;
            btnSimpan.textContent = "UPLOAD";
        }
    }
</script>