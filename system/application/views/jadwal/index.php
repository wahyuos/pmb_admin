<div class="row">
    <div class="col-12 col-xl-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Jadwal</h5>
                <h6 class="card-subtitle text-muted">Masukkan jadwal pendaftaran untuk tiap jalur.</h6>
            </div>
            <div class="card-body">
                <form id="f_jadwal" autocomplete="off">
                    <input type="hidden" name="id_jadwal" id="id_jadwal" value="">
                    <h6>Periode Pendaftaran</h6>
                    <hr>
                    <div class="form-group">
                        <label class="form-label" for="nama_gelombang">Nama Gelombang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_gelombang" id="nama_gelombang" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="jalur">Jalur Pendaftaran <span class="text-danger">*</span></label>
                        <div class="form-group border p-1 pl-2 m-0 rounded">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="jalur_Umum" name="jalur" value="Umum" class="custom-control-input" required>
                                <label class="custom-control-label" for="jalur_Umum">Umum </label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="jalur_PMDK" name="jalur" value="PMDK" class="custom-control-input" required>
                                <label class="custom-control-label" for="jalur_PMDK">PMDK </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="periode_awal">Tanggal mulai <span class="text-danger">*</span></label>
                        <input type="date" name="periode_awal" id="periode_awal" class="form-control" required>
                    </div>
                    <div class="form-group mb-5">
                        <label class="form-label" for="periode_akhir">Tanggal akhir <span class="text-danger">*</span></label>
                        <input type="date" name="periode_akhir" id="periode_akhir" class="form-control" required>
                    </div>

                    <h6>Jadwal Tes</h6>
                    <hr>

                    <div class="form-group">
                        <label class="form-label" for="nama_tes1">Nama Tes Pertama <span class="text-danger">*</span></label>
                        <input type="text" name="nama_tes1" id="nama_tes1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tanggal_tes1">Tanggal Tes Pertama</label>
                        <input type="date" name="tanggal_tes1" id="tanggal_tes1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama_tes2">Nama Tes Kedua <span class="text-danger">*</span></label>
                        <input type="text" name="nama_tes2" id="nama_tes2" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tanggal_tes2">Tanggal Tes Kedua</label>
                        <input type="date" name="tanggal_tes2" id="tanggal_tes2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="batas_reg_ulang">Batas Registrasi Ulang</label>
                        <input type="date" name="batas_reg_ulang" id="batas_reg_ulang" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tahun_akademik">Tahun Akademik</label>
                        <input type="text" name="tahun_akademik" id="tahun_akademik" class="form-control" value="<?= $tahun_akademik ?>" readonly>
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
                <h5 class="card-title">Data Jadwal Pendaftaran</h5>
                <h6 class="card-subtitle text-muted">Pastikan semua jadwal sudah benar untuk setiap tahun akademik.</h6>
            </div>
            <div class="card-body">
                <div class="responsive">
                    <table id="dt-jadwal" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gelombang</th>
                                <th>Jalur</th>
                                <th>Mulai</th>
                                <th>Berakhir</th>
                                <th>Tes Pertama</th>
                                <th>Tes Kedua</th>
                                <th>Batas reg Ulang</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>