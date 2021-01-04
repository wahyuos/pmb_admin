<div class="row">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Bukti Bayar</h5>
                <h6 class="card-subtitle text-muted">Verifikasi bukti bayar pendaftaran untuk calon mahasiswa yang melakukan daftar secara mandiri.</h6>
            </div>
            <div class="card-body">
                <table id="dt-bukti_bayar" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pendaftar</th>
                            <th>Tgl Upload</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-5" id="card" style="display: none;">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><span id="nama_akun"></span></h5>
            </div>
            <div class="card-body">
                <table class="table table-sm my-2">
                    <tbody>
                        <tr>
                            <td>Status</td>
                            <td class="text-right"><span id="verifikasi"></span></td>
                        </tr>
                        <tr>
                            <td colspan="2"><span id="bukti_bayar"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>