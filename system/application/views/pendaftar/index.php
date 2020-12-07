<div class="row">
    <div class="col-12">
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
                <table id="dt-pendaftar" class="table table-hover table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pendaftar</th>
                            <th>Nomor Daftar</th>
                            <th>L/P</th>
                            <th>Prodi Pilihan</th>
                            <th>Sekolah Asal</th>
                            <th>Tgl Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>