<style>
    @page {
        sheet-size: 210mm 297mm;
        margin: 3rem;
    }
</style>
<table>
    <tr>
        <td style="padding: .7rem;"><img src="<?= base_url('assets/img/mucis.png') ?>" alt="<?= $detail_pd->nm_pd ?>" width="64" height="64" /></td>
        <td style="padding: .7rem;">
            <h3>Kartu Pendaftaran Mahasiswa Baru</h3>
            <?= aplikasi()->kampus ?><br>
            Tahun Akademik <?= tahun_akademik() ?>
        </td>
    </tr>
</table>

<hr>

<table style="width:100%">
    <tr>
        <th style="width:25%;padding:.7rem;text-align: left;">
            Nomor Pendaftaran
        </th>
        <td style="width: 3%;text-align:center"> : </td>
        <td>
            <?= $detail_pd->no_daftar ?>
        </td>
        <td rowspan="6" style="text-align: center;width:25%;border: 1px solid #000;object-fit: cover;">
            <?php
            // ambil foto
            $pas_foto = $this->db->get_where('pmb_persyaratan', ['id_akun' => $detail_pd->id_akun, 'id_jns_persyaratan' => '3'])->row();
            // jika foto ada
            if ($pas_foto) :
            ?>
                <img src="data:<?= $pas_foto->type_doc ?>;base64,<?= $pas_foto->blob_doc ?>" alt="<?= $detail_pd->nm_pd ?>l" style="object-fit: contain;" max-width="150" max-height="150" />
            <?php else : ?>
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="<?= $detail_pd->nm_pd ?>" width="150" height="150" />
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th style="padding:.7rem;text-align: left;">
            Tanggal Daftar
        </th>
        <td style="width: 3%;text-align:center"> : </td>
        <td>
            <?= $this->date->tanggal($detail_pd->tgl_daftar, 'p') ?>
        </td>
    </tr>
    <tr>
        <th style="padding:.7rem;text-align: left;">
            NIK
        </th>
        <td style="width: 3%;text-align:center"> : </td>
        <td>
            <?= $detail_pd->nik ?>
        </td>
    </tr>
    <tr>
        <th style="padding:.7rem;text-align: left;">
            Nama Lengkap
        </th>
        <td style="width: 3%;text-align:center"> : </td>
        <td>
            <?= $detail_pd->nm_pd ?>
        </td>
    </tr>
    <tr>
        <th style="padding:.7rem;text-align: left;">
            Tempat, Tanggal Lahir
        </th>
        <td style="width: 3%;text-align:center"> : </td>
        <td>
            <?= $detail_pd->tmpt_lahir . ', ' . $this->date->tanggal($detail_pd->tgl_lahir, 'p') ?>
        </td>
    </tr>
    <tr>
        <th style="padding:.7rem;text-align: left;">
            Nomor HP Peserta
        </th>
        <td style="width: 3%;text-align:center"> : </td>
        <td>
            <?= $detail_pd->hp_akun ?>
        </td>
    </tr>
    <tr>
        <th style="padding:.7rem;text-align: left;">
            Asal Sekolah
        </th>
        <td style="width: 3%;text-align:center"> : </td>
        <td>
            <?= $detail_pd->sekolah ?>
        </td>
        <td rowspan="3" style="text-align:center;border: 1px solid #000;color:#aaa"> Tanda tangan peserta</td>
    </tr>
    <tr>
        <th style="padding:.7rem;text-align: left;">
            Program Studi Pilihan
        </th>
        <td style="width: 3%;text-align:center"> : </td>
        <td>
            <?= $detail_pd->nama_prodi ?>
        </td>
    </tr>
    <tr>
        <th style="padding:.7rem;text-align: left;">
            Jalur Pendaftaran
        </th>
        <td style="width: 3%;text-align:center"> : </td>
        <td>
            <?= $detail_pd->jalur . ' - ' . $detail_pd->nama_gelombang ?>
        </td>
    </tr>
</table>

<hr>

<table style="width:100%">
    <?php
    // periksa jalur pendaftaran
    if ($detail_pd->jalur == 'PMDK') : ?>
        <tr>
            <th style="width:25%;padding:.7rem;text-align: left;"><?= $detail_pd->nama_tes1 ?></th>
            <td style="width: 3%;text-align:center"> : </td>
            <td><?= $this->date->tanggal($detail_pd->tanggal_tes1, 'l') ?></td>
        </tr>
    <?php else :
        // jika umum, tampilkan jadwal tes
    ?>
        <tr>
            <th style="width:25%;padding:.7rem;text-align: left;"><?= $detail_pd->nama_tes1 ?></th>
            <td style="width: 3%;text-align:center"> : </td>
            <td><?= ($cek_tes) ? 'Sudah Mengerjakan' : $this->date->tanggal($detail_pd->tanggal_tes1, 'l') ?></td>
        </tr>
    <?php endif; ?>
    <tr>
        <th style="width:25%;padding:.7rem;text-align: left;"><?= $detail_pd->nama_tes2 ?></th>
        <td style="width: 3%;text-align:center"> : </td>
        <td><?= $this->date->tanggal($detail_pd->tanggal_tes2, 'l') ?></td>
    </tr>
</table>

<hr>
<p style="text-align: center;"><strong>Penting!</strong> Kartu ini <strong>wajib</strong> dibawa saat mengikuti tes.</p>

<hr>
<div style="text-align: center;font-size:small;position:fixed;bottom: 0;left:0;width: 100%;color:lightsteelblue">
    Dicetak pada <?= $this->date->tanggal(date('Y-m-d'), 'l') ?>
</div>