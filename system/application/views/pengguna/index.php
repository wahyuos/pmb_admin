<div class="row">
    <div class="col-12 col-xl-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Admin</h5>
                <h6 class="card-subtitle text-muted">Kelola akun admin.</h6>
            </div>
            <div class="card-body">
                <form id="f_pengguna" autocomplete="off">
                    <input type="hidden" name="id_user" id="id_user" value="">
                    <div class="form-group">
                        <label class="form-label" for="nama_user">Nama Admin <span class="text-danger">*</span></label>
                        <input type="text" name="nama_user" id="nama_user" class="form-control" required autofocus>
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
                <h5 class="card-title">Data Admin</h5>
            </div>
            <div class="card-body">
                <table id="dt-pengguna" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Admin</th>
                            <th>Username</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>