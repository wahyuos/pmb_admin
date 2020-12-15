<div class="row">
    <div class="col-12 col-xl-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Jadwal</h5>
                <h6 class="card-subtitle text-muted">Masukkan jadwal pendaftaran untuk tiap jalur.</h6>
            </div>
            <div class="card-body">
                <form id="f_pengguna" autocomplete="off">
                    <input type="hidden" name="id_user" id="id_user" value="">
                    <div class="form-group">
                        <label class="form-label" for="nama_user">Nama Pengguna <span class="text-danger">*</span></label>
                        <input type="text" name="nama_user" id="nama_user" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="jalur">Level Pengguna <span class="text-danger">*</span></label>
                        <div class="form-group border p-1 pl-2 m-0 rounded">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="level_admin" name="level" value="admin" class="custom-control-input" required>
                                <label class="custom-control-label" for="level_admin">Admin </label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="level_mitra" name="level" value="mitra" class="custom-control-input" required>
                                <label class="custom-control-label" for="level_mitra">Mitra </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <small id="info_pass" style="display: none;">Kosongkan jika password tidak akan diganti</small>
                    </div>

                    <hr>
                    <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
                    <button type="reset" class="btn btn-outline-secondary">RESET</button>
                    <a role="button" id="batal" onclick="location.reload()" class="btn btn-secondary waves-effect float-right" style="display: none;">BATAL</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-8">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <h5 class="card-title">Data Pengguna</h5>
                        <h6 class="card-subtitle text-muted">Pengguna dengan level admin dan mitra BP.</h6>
                    </div>
                    <div class="col-lg-4 col-sm-12 text-right">
                        <a role="button" data-toggle="modal" data-target="#modal_import" class="btn btn-primary"><i class="fa fa-file-excel mr-2"></i> Import Pengguna</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="dt-pengguna" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pengguna</th>
                            <th>Username</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" id="modal_import" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form id="f_file" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="id" value="0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label w-100">Pilih File (.xls atau .xlsx)</label>
                                <input type="file" name="file" onchange="showType(event)" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel" required>
                            </div>
                            <label id="alert" class="text-danger"></label>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" id="import" class="btn btn-primary">IMPORT</button>
                    <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">BATAL</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const f_file = document.getElementById('f_file');
    const alert = document.getElementById('alert');
    const btnImport = document.getElementById('import');
    btnImport.disabled = true;

    // fungsi validasi
    function showType(event) {
        const doc = event.target.files[0];
        // cek type gambar
        if (doc.type.match("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || doc.type.match("application/vnd.ms-excel")) {
            // cek ukuran gambar
            if (doc.size < 204800) { // 200KB
                btnImport.disabled = false;
                alert.innerHTML = "";
            } else {
                alert.innerHTML = "Ukuran file terlalu besar. Maksimal 200KB";
                f_file.reset();
            }
        } else {
            alert.innerHTML = "File tidak didukung. Gunakan file excel .xlsx atau .xls";
            f_file.reset();
        }
    };

    // proses import
    f_file.addEventListener('submit', function(event) {
        event.preventDefault();
        const value = new FormData(f_file);
        importData(value);
    });

    async function importData(value) {
        const options = {
            method: 'POST',
            body: value
        };
        try {
            btnImport.disabled = true;
            btnImport.textContent = "memproses...";
            const response = await fetch(site_url + 'pengguna/import_pengguna', options);
            const json = await response.json();
            // console.log(json);
            if (json.status == true) {
                $('#modal_import').modal('hide');
                // reload tabel
                $('#dt-pengguna').DataTable().ajax.reload();
                // tampil notif
                notif(json.message, json.type);
                // reset form
                f_file.reset();
                btnImport.disabled = false;
                btnImport.textContent = "IMPORT";
            } else {
                // tampil notif
                notif(json.message, json.type);
                alert.innerHTML = json.message;
                btnImport.disabled = false;
                btnImport.textContent = "IMPORT";
            }
        } catch (error) {
            // console.log(error);
            alert.innerHTML = error;
            // tampil notif
            notif(error, 'error');
            btnImport.disabled = false;
            btnImport.textContent = "IMPORT";
        }
    }
</script>