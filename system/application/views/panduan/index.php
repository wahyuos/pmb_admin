<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header mb-0">
                <h5 class="card-title mb-0">Upload Panduan</h5>
            </div>
            <div class="card-body">
                <div class="list-group mb-3 rounded-lg">
                    <div class="list-group-item p-3">
                        <label class="form-label" for="file">File dokumen PDF maksimal 1MB.</label>
                        <form id="f_panduan" class="form-inline" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="id" value="0">
                            <div class="overflow-hidden mr-5">
                                <input type="file" onchange="loadFile(event)" name="file" accept="application/pdf" id="file">
                            </div>
                            <button type="submit" id="simpan" class="btn btn-primary">UPLOAD</button>
                        </form>
                        <div id="alert" class="text-danger mt-3"></div>
                    </div>
                    <?php if ($doc_panduan) : ?>
                        <div id="col_preview">
                            <div class="list-group-item text-center p-3">
                                <h6 id="title" class="mb-2">Panduan telah diupload</h6>
                                Pastikan tulisan terlihat jelas dan mudah dibaca
                            </div>
                            <div class="list-group-item text-center p-3">
                                <iframe id="preview" src="<?= base_url($doc_panduan->file_path . $doc_panduan->file_name) ?>" class="rounded-md" width="100%" height="600px"></iframe>
                            </div>
                        </div>
                    <?php else : ?>
                        <div id="col_preview" style="display: none;">
                            <div class="list-group-item text-center p-3">
                                <h6 id="title" class="mb-2">Preview</h6>
                                Pastikan tulisan terlihat jelas dan mudah dibaca
                            </div>
                            <div class="list-group-item text-center p-3">
                                <iframe id="preview" class="rounded-md" width="100%" height="600px"></iframe>
                            </div>
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
    const myForm = document.getElementById('f_panduan');
    const btnSimpan = document.getElementById('simpan');
    btnSimpan.disabled = true;
    const loadFile = function(event) {
        const doc = event.target.files[0];
        const col_preview = document.getElementById('col_preview');
        const preview = document.getElementById('preview');
        // cek type doc
        if (doc.type.match('application/pdf')) {
            // cek ukuran doc
            if (doc.size < 1024000) { // 1MB
                // tampilkan doc
                col_preview.style.display = 'block';
                preview.src = URL.createObjectURL(event.target.files[0]);
                document.getElementById('title').textContent = 'Preview';
                btnSimpan.disabled = false;
                alert.innerHTML = "";
            } else {
                alert.innerHTML = "Ukuran file terlalu besar. Maksimal 1MB";
                preview.src = "";
                myForm.reset();
            }
        } else {
            alert.innerHTML = "File tidak didukung. Gunakan file PDF.";
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
            const response = await fetch(site_url + 'panduan/simpan', options);
            const json = await response.json();
            // console.log(json);
            if (json.status == true) {
                // tampil notif
                notif(json.message, json.type);
                // reload
                setTimeout(function() {
                    location.reload();
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