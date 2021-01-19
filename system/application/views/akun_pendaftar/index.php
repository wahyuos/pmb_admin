<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Akun Pendaftar</h5>
                Total Akun : <strong><?= $total_akun ?> akun</strong> (<?= $total_yang_nonaktif ?> belum aktif)<br>
                Total akun yang sudah daftar : <strong><?= $total_yang_daftar ?> akun</strong><br>
            </div>
            <div class="card-body">
                <table id="dt-akun_pendaftar" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pendaftar</th>
                            <th>Nomor HP</th>
                            <th>Tanggal Akun</th>
                            <th>Status Akun</th>
                            <th>Pendaftaran</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>