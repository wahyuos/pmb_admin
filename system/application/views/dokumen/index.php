<div class="row">

    <?php if ($this->session->level == 'super' || $this->session->level == 'admin') : ?>
        <div class="col-12 col-sm-6 col-xxl">
            <div class="card">
                <div class="card-header mb-0">
                    <h5 class="card-title">Upload Dokumen</h5>
                    <h6 class="card-subtitle text-muted">Upload dokumen yang berkaitan dengan PMB, seperti brosur, biaya, dan lain-lain.</h6>
                </div>
                <div class="card-body">
                    <div class="list-group mb-3 rounded-lg">
                        <div class="list-group-item p-3">
                            <form id="f_dokumen" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" name="id_dokumen" value="0">
                                <div class="form-group">
                                    <label class="form-label" for="nama_dokumen">Nama Dokumen <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_dokumen" id="nama_dokumen" class="form-control" required autofocus>
                                </div>
                                <div class="form-group mb-5">
                                    <label class="form-label" for="file">Pilih dokumen PDF maksimal 5MB <span class="text-danger">*</span></label>
                                    <div class="overflow-hidden mr-5">
                                        <input type="file" onchange="loadFile(event)" name="file" accept="application/pdf" id="file" required>
                                    </div>
                                </div>
                                <button type="submit" id="simpan" class="btn btn-primary">UPLOAD</button>
                            </form>
                            <div id="alert" class="text-danger mt-3"></div>
                        </div>
                        <div class="list-group-item text-center p-3">
                            <h6 id="title" class="mb-2">Preview</h6>
                            Pastikan tulisan atau gambar terlihat jelas dan mudah dibaca
                        </div>
                        <div id="col_preview" style="display: none;">
                            <div class="list-group-item text-center p-3">
                                <iframe id="preview" class="rounded-md" width="100%" height="600px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xxl">
            <div class="card">
                <div class="card-header mb-0">
                    <h5 class="card-title">Dokumen</h5>
                </div>
                <div class="card-body">
                    <?php if ($list) : ?>
                        <div class="table-responsive">
                            <table class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama Dokumen</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($list as $field) :
                                    ?>
                                        <tr>
                                            <td><?= $field->nama_dokumen ?></td>
                                            <td class="text-center">
                                                <a role="button" data-toggle="modal" data-target="#modal_<?= $field->id_dokumen ?>" class="btn btn-sm btn-danger">Hapus</a>
                                                <a href="<?= base_url($field->file_path . $field->file_name) ?>" target="_d" class="btn btn-sm btn-success">Lihat</a>
                                                <?= modal_danger($field->id_dokumen, $field->nama_dokumen) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        Belum ada dokumen yang diupload.
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php else : ?>

        <div class="col-12 col-sm-6 col-xxl">
            <div class="card">
                <div class="card-header mb-0">
                    <h5 class="card-title">Dokumen</h5>
                </div>
                <div class="card-body">
                    <?php if ($list) : ?>
                        <div class="table-responsive">
                            <table class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama Dokumen</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($list as $field) :
                                    ?>
                                        <tr>
                                            <td><?= $field->nama_dokumen ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url($field->file_path . $field->file_name) ?>" target="_d" class="btn btn-sm btn-success">Lihat</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        Belum ada dokumen yang diupload.
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>

<script type="text/javascript">
    const alert = document.getElementById('alert');
    const myForm = document.getElementById('f_dokumen');
    const btnSimpan = document.getElementById('simpan');
    btnSimpan.disabled = true;
    const loadFile = function(event) {
        const doc = event.target.files[0];
        const col_preview = document.getElementById('col_preview');
        const preview = document.getElementById('preview');
        // cek type doc
        if (doc.type.match('application/pdf')) {
            // cek ukuran doc
            if (doc.size < 5120000) { // 5MB
                // tampilkan doc
                col_preview.style.display = 'block';
                preview.src = URL.createObjectURL(event.target.files[0]);
                document.getElementById('title').textContent = 'Preview';
                btnSimpan.disabled = false;
                alert.innerHTML = "";
            } else {
                alert.innerHTML = "Ukuran file terlalu besar. Maksimal 5MB";
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
            const response = await fetch(site_url + 'dokumen/simpan', options);
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

    // tombol hapus
    async function hapus(id, name) {
        // data dalam bentuk json
        const data = {
            'id_dokumen': id,
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
            const response = await fetch(site_url + "dokumen/hapus/", options);
            const json = await response.json();
            // console.log(json);
            // jika status true
            if (json.status) {
                // tampil notif
                notif(json.message, json.type);
                //reload
                location.reload();
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
</script>