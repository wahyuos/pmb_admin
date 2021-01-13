<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Siswa yang didaftarkan oleh </h5>
                <h3><?= strtoupper($mitra->nama_user . ' - ' . $mitra->instansi) ?></h3>
            </div>
            <div class="card-body">
                <?php if ($pendaftar) : ?>
                    <table class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pendaftar</th>
                                <th>Nomor Pendaftaran</th>
                                <th>Asal Sekolah</th>
                                <th>Nomor HP</th>
                                <th>Program Studi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($pendaftar as $field) :
                            ?>
                                <tr>
                                    <td><?= ++$no ?></td>
                                    <td><?= $field->nm_pd ?></td>
                                    <td><?= $field->no_daftar ?></td>
                                    <td><?= $field->sekolah ?></td>
                                    <td><?= $field->hp_akun ?></td>
                                    <td><?= $field->nama_prodi ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>