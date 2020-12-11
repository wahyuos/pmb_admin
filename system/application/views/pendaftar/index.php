<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <h5 class="card-title">Responsive DataTables</h5>
                        <h6 class="card-subtitle text-muted">Highly flexible tool that many advanced features to any HTML table. See official documentation <a href="https://datatables.net/extensions/responsive/" target="_blank" rel="noopener noreferrer nofollow">here</a>.</h6>
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
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4" id="card" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-actions float-right">
                    <div class="dropdown show">
                        <a href="#" data-toggle="dropdown" data-display="static">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                            </svg>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Buang</a>
                            <a class="dropdown-item text-danger" href="#">Hapus Permanen</a>
                        </div>
                    </div>
                </div>
                <h5 class="card-title mb-0">DATA PENDAFTAR</h5>
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
                    <a type="button" href="#" id="btn_hapus" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>