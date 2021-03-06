<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-8 col-sm-12 mb-3">
                        <h5 class="card-title">Data Pendaftar</h5>
                        <h6 class="card-subtitle text-muted">Mengelola data pendaftaran calon mahasiswa baru.<br>Klik pada nama untuk melihat detail.</h6>
                    </div>
                    <div class="col-lg-4 col-sm-12 text-right">
                        <a href="<?= site_url('pendaftar/tambah') ?>" class="btn btn-success"><i class="align-middle" data-feather="plus"></i> Daftar Baru</a>
                        <?php // cek level user
                        $level_user = $this->session->level;
                        if ($level_user != 'mitra') : ?>
                            <a href="<?= site_url('pendaftar/to_excel') ?>" class="btn btn-primary"><i class="align-middle" data-feather="file-text"></i> Export Data</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="dt-pendaftar" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pendaftar</th>
                            <th>Prodi Pilihan</th>
                            <th>Nomor HP</th>
                            <th>Sekolah Asal</th>
                            <?php // cek level user
                            $level_user = $this->session->level;
                            if ($level_user == 'mitra') : ?>
                                <th>Tgl Daftar</th>
                            <?php else : ?>
                                <th>Oleh</th>
                            <?php endif; ?>
                            <th>Berkas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>