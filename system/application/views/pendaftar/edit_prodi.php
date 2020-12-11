<?php if ($prodi) : ?>
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
                        <input type="hidden" id="id_akun" name="id_akun" value="<?= $prodi->id_akun ?>">
                        <input type="hidden" id="method" name="method" value="edit_prodi">

                        <!-- Prodi Pilihan -->
                        <div class="mb-2 border-bottom">
                            <h5 class="card-title mb-1">Program Studi Pilihan</h5>
                            <label>Pilih jenis kelas, kemudian pilih program studi</label>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="">Pilih Jenis Kelas <span class="text-danger">*</span></label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input name="custom-radio-3" type="radio" class="custom-control-input" onclick="prodiReg()" <?= ($prodi->jenis_prodi == 'Reguler') ? 'checked' : '' ?> required>
                                        <span class="custom-control-label">Kelas Reguler</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="custom-radio-3" type="radio" class="custom-control-input" onclick="prodiKar()" <?= ($prodi->jenis_prodi == 'Karyawan') ? 'checked' : '' ?> required>
                                        <span class="custom-control-label">Kelas Karyawan</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <?php $reg = ($prodi->jenis_prodi == 'Reguler') ? 'inline' : 'none' ?>
                                <div id="prodiReg" style="display: <?= $reg ?>;">
                                    <div class="form-group mb-5">
                                        <label for="id_prodi">Program Studi Kelas Reguler <span class="text-danger">*</span></label>
                                        <div class="custom-controls-stacked">
                                            <?php if ($prodi_reg) :
                                                foreach ($prodi_reg as $list) :
                                                    $checked = ($list->id_prodi == $prodi->id_prodi) ? 'checked' : '';
                                            ?>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" name="id_prodi" value="<?= $list->id_prodi ?>" class="custom-control-input" <?= $checked ?> required>
                                                        <span class="custom-control-label"><?= $list->jenjang . ' ' . $list->nm_prodi ?></span>
                                                    </label>
                                            <?php endforeach;
                                            endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php $kar = ($prodi->jenis_prodi == 'Karyawan') ? 'inline' : 'none' ?>
                                <div id="prodiKar" style="display: <?= $kar ?>;">
                                    <div class="form-group mb-5">
                                        <label for="id_prodi">Program Studi Kelas Karyawan <span class="text-danger">*</span></label>
                                        <div class="custom-controls-stacked">
                                            <?php if ($prodi_kar) :
                                                foreach ($prodi_kar as $list) : ?>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" name="id_prodi" value="<?= $list->id_prodi ?>" class="custom-control-input" required>
                                                        <span class="custom-control-label"><?= $list->jenjang . ' ' . $list->nm_prodi ?></span>
                                                    </label>
                                            <?php endforeach;
                                            endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
                        <button type="reset" class="btn btn-outline-secondary">RESET</button>
                        <a role="button" href="<?= site_url('pendaftar/detail/' . $prodi->id_akun) ?>" class="btn btn-secondary float-right">KEMBALI</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function prodiReg() {
            document.getElementById("prodiReg").style.display = "block";
            document.getElementById("prodiKar").style.display = "none";
        }

        function prodiKar() {
            document.getElementById("prodiKar").style.display = "block";
            document.getElementById("prodiReg").style.display = "none";
        }
    </script>
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