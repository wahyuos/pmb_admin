<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=" . $title . ".xls");
?>
<table class="table dataTable w-full" id="datatabel" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>No Pendaftaran</th>
            <th>Jalur Daftar</th>
            <th>Nama Peserta</th>
            <th>L/P</th>
            <th>Tmp/Tgl Lahir</th>
            <th>Nomor HP</th>
            <th>Asal Sekolah</th>
            <th>Prodi Pilihan</th>
            <th>Tgl Daftar</th>
            <th>Oleh</th>
            <th>Persyaratan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($data as $val) {
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $val->no_daftar; ?></td>
                <td><?= $val->jalur . ' ' . $val->nama_gelombang; ?></td>
                <td><?= strtoupper($val->nm_pd); ?></td>
                <td><?= $val->jk; ?></td>
                <td><?= strtoupper($val->tmpt_lahir) . ', ' . $this->date->tanggal($val->tgl_lahir, 'p'); ?></td>
                <td><?= "'" . $val->hp_akun; ?></td>
                <td><?= strtoupper($val->sekolah); ?></td>
                <td><?= $val->nama_prodi; ?></td>
                <td><?= $this->date->tanggal($val->tgl_daftar, 'p'); ?></td>
                <td><?= ($val->level) ? strtoupper($val->level) : 'MANDIRI' ?></td>
                <?php
                // pemeriksaan kelengkapan persyaratan
                $kelengkapan_persyaratan = $this->persyaratan->cek_kelengkapan_persyaratan($val->id_akun);
                if (!$kelengkapan_persyaratan || $kelengkapan_persyaratan == 0) {
                    $persyaratan = 'Belum upload';
                } elseif ($kelengkapan_persyaratan == 3) {
                    $persyaratan = 'Lengkap';
                } else {
                    $persyaratan = $kelengkapan_persyaratan . ' dari 3';
                }
                ?>
                <td><?= $persyaratan ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>