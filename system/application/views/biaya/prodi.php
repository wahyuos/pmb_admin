<div class="row">


    <div class="col-12 col-sm-6 col-xxl">
        <div class="card">
            <div class="card-header mb-0">
                <h5 class="card-title mb-0">Upload Rincian Biaya</h5>
            </div>
            <div class="card-body">
                <div class="list-group mb-3 rounded-lg">
                    <div class="list-group-item p-3">
                        <form id="f_biaya" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="id" value="0">
                            <div class="form-group">
                                <label class="form-label" for="periode_awal">Pilih Prodi <span class="text-danger">*</span></label>
                                <select class="form-control" name="id_prodi" id="id_prodi" required>
                                    <option selected disabled value="">Silahkan pilih</option>
                                    <?php if ($prodi) :
                                        foreach ($prodi as $prod) : ?>
                                            <option value="<?= $prod->id_prodi ?>"><?= $prod->jenjang . ' ' . $prod->nm_prodi ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="file">File dokumen PDF maksimal 1MB <span class="text-danger">*</span></label>
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
                        Pastikan tulisan terlihat jelas dan mudah dibaca
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
                <h5 class="card-title mb-0">Rincian Biaya Prodi</h5>
            </div>
            <div class="card-body">
                <?php if ($list) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Prodi</th>
                                    <th>Tahun Akademik</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($list as $field) :
                                ?>
                                    <tr>
                                        <td><?= $field->jenjang . ' ' . $field->nm_prodi ?></td>
                                        <td><?= $field->tahun_akademik ?></td>
                                        <td class="text-center">
                                            <a role="button" data-toggle="modal" data-target="#modal_<?= $field->id_biaya_prodi ?>" class="btn btn-sm btn-danger">Hapus</a>
                                            <a href="<?= base_url($field->file_path . $field->file_name) ?>" target="_d" class="btn btn-sm btn-success">Lihat</a>
                                            <?= modal_danger($field->id_biaya_prodi, $field->jenjang . ' ' . $field->nm_prodi) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    Belum ada biaya yang diupload.
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const alert = document.getElementById('alert');
    const myForm = document.getElementById('f_biaya');
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
            const response = await fetch(site_url + 'biaya/simpan', options);
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
            'id_biaya_prodi': id,
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
            const response = await fetch(site_url + "biaya/hapus/", options);
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