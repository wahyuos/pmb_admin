<?php if ($kontak) : ?>
    <div class="row">
        <div class="col-md-5 col-xl-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0 text-center">TA <?= $detail_pd->tahun_akademik ?></h5>
                </div>
                <div class="card-body text-center">
                    <?php
                    // ambil foto
                    $pas_foto = $this->db->get_where('pmb_persyaratan', ['id_akun' => $detail_pd->id_pd, 'id_jns_persyaratan' => '3'])->row();
                    // jika foto ada
                    if ($pas_foto) :
                    ?>
                        <img src="data:<?= $pas_foto->type_doc ?>;base64,<?= $pas_foto->blob_doc ?>" alt="<?= $detail_pd->nm_pd ?>l" class="mx-auto rounded-circle d-block mb-4" style="object-fit: cover;" width="128" height="128" />
                    <?php else : ?>
                        <img src="<?= site_url('assets/img/logo.png') ?>" alt="<?= $detail_pd->nm_pd ?>" class="img-fluid rounded-circle mb-5" width="128" height="128" />
                    <?php endif; ?>

                    <h5 class="card-title mb-0"><?= $detail_pd->nm_pd ?></h5>
                    <div class="text-muted mb-2"><?= $detail_pd->no_daftar ?></div>
                    <div class="text-muted mb-2"><?= $detail_pd->jenjang_prodi . ' ' . $detail_pd->nm_prodi ?></div>
                    <!-- <div>
                        <a class="btn btn-primary btn-sm" href="<?= site_url('pendaftar/edit/') . $detail_pd->id_pd ?>">Edit</a>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="col-md-7 col-xl-8">
            <div class="card">
                <div class="card-body">
                    <form id="f_edit" autocomplete="off">
                        <input type="hidden" id="id_akun" name="id_akun" value="<?= $kontak->id_akun ?>">
                        <input type="hidden" id="method" name="method" value="edit_kontak">

                        <!-- Kontak -->
                        <div class="mb-2 border-bottom">
                            <h5 class="card-title mb-1">Form Kontak</h5>
                            <label>Gunakan nomor HP atau email yang aktif dan bisa dihubungi.</label>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="no_hp_ortu">Nomor HP Orang Tua <span class="text-danger">*</span></label>
                                <input type="text" pattern="\d*" minlength="8" maxlength="13" class="form-control" id="no_hp_ortu" name="no_hp_ortu" placeholder="08xxxxxxxxxx" value="<?= $kontak->no_hp_ortu ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="no_hp">Nomor HP Peserta <span class="text-danger">*</span></label>
                                <input type="text" pattern="\d*" minlength="8" maxlength="13" class="form-control" id="no_hp" name="no_hp" placeholder="08xxxxxxxxxx" value="<?= $kontak->no_hp ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="email">Email Peserta</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $kontak->email ?>" placeholder="namaemail@mail.com">
                            </div>
                        </div>

                        <hr>
                        <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
                        <button type="reset" class="btn btn-outline-secondary">RESET</button>
                        <a role="button" href="<?= site_url('pendaftar/detail/' . $kontak->id_akun) ?>" class="btn btn-secondary float-right">KEMBALI</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="container d-flex flex-column">
        <div class="row h-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center">
                        <h1 class="display-1 font-weight-bold">404</h1>
                        <p class="h1">Page not found.</p>
                        <p class="h2 font-weight-normal mt-3 mb-4">Halaman yang kamu cari tidak ada disini.</p>
                        <a href="<?= site_url('pendaftar') ?>" class="btn btn-primary btn-lg">Kembali</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>