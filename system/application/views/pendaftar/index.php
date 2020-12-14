<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <h5 class="card-title">Data Pendaftar</h5>
                        <h6 class="card-subtitle text-muted">Mengelola data pendaftaran calon mahasiswa baru.<br>Klik pada nama untuk melihat detail.<br>Untuk status diterima, klik pada tombol switch yang ada di kolom status.</h6>
                    </div>
                    <div class="col-lg-4 col-sm-12 text-right">
                        <a href="<?= site_url('pendaftar/tambah') ?>" class="btn btn-success"><i class="align-middle" data-feather="plus"></i> Daftar Baru</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="dt-pendaftar" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pendaftar</th>
                            <th>Nomor Daftar</th>
                            <th>Prodi Pilihan</th>
                            <th>Tgl Daftar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4" id="card" style="display: none;">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Pendaftar</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm my-2">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td><span id="nm_pd"></span></td>
                        </tr>
                        <tr>
                            <th>Asal Sekolah</th>
                            <td><span id="sekolah_asal"></span></td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td><span id="no_hp"></span></td>
                        </tr>
                        <tr>
                            <th>Telp Ortu</th>
                            <td><span id="no_hp_ortu"></span></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span id="status_diterima"></span></td>
                        </tr>
                    </tbody>
                </table>

                <hr>
                <div class="btn-group mb-3 btn-block" role="group" aria-label="Default button group">
                    <a role="button" href="#" id="btn_detail" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>