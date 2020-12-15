<?php if ($alamat) : ?>
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
                        <input type="hidden" id="id_akun" name="id_akun" value="<?= $alamat->id_akun ?>">
                        <input type="hidden" id="method" name="method" value="edit_alamat">

                        <!-- Alamat -->
                        <div class="mb-2 border-bottom">
                            <h5 class="card-title mb-1">Form Alamat</h5>
                            <label>Khusus untuk kolom propinsi, kabupaten/kota, dan kecamatan.<br>Ketik nama (propinsi, kabupaten/kota, kecamatan) pada kolom, kemudian pilih</label>
                        </div>
                        <?php
                        // ambil nama provinsi
                        $nm_prov = $this->db->get_where('ref_wilayah', ['id_wil' => $alamat->id_prov])->row();
                        // ambil nama kabupaten
                        $nm_kab  = $this->db->get_where('ref_wilayah', ['id_wil' => $alamat->id_kab])->row();
                        ?>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="nm_prov">Propinsi <span class="text-danger">*</span></label>
                                <input type="hidden" name="id_prov" id="id_prov" value="<?= $alamat->id_prov ?>">
                                <input type="text" name="nm_prov" id="nm_prov" class="form-control" value="<?= trim($nm_prov->nm_wil) ?>" placeholder="Cari nama provinsi" required>
                                <div id="list_provinsi" style="position: absolute;z-index:1000"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nm_kab">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <input type="hidden" name="id_kab" id="id_kab" value="<?= $alamat->id_kab ?>">
                                <input type="text" name="nm_kab" id="nm_kab" class="form-control" value="<?= trim($nm_kab->nm_wil) ?>" placeholder="Cari nama kabupaten/kota" required>
                                <div id="list_kabupaten" style="position: absolute;z-index:1000"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nm_wil">Kecamatan <span class="text-danger">*</span></label>
                                <input type="hidden" name="id_wil" id="id_wil" value="<?= $alamat->id_wil ?>">
                                <input type="text" name="nm_wil" id="nm_wil" class="form-control" value="<?= trim($alamat->nm_wil) ?>" placeholder="Cari nama kecamatan" required>
                                <div id="list_kecamatan" style="position: absolute;z-index:1000"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="desa">Desa/Kelurahan <span class="text-danger">*</span></label>
                                <input type="text" name="ds_kel" id="desa" class="form-control" value="<?= $alamat->ds_kel ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="dusun">Dusun/Kampung <span class="text-danger">*</span></label>
                                <input type="text" name="nm_dsn" id="dusun" class="form-control" value="<?= $alamat->nm_dsn ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="kode_pos">Kode POS <span class="text-danger">*</span></label>
                                <input type="text" pattern="\d*" minlength="5" maxlength="5" name="kode_pos" value="<?= $alamat->kode_pos ?>" id="kode_pos" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <div class="form-group">
                                    <label for="rt">RT <span class="text-danger">*</span></label>
                                    <input type="text" pattern="\d*" name="rt" id="rt" class="form-control" value="<?= $alamat->rt ?>" required>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="form-group">
                                    <label for="rw">RW <span class="text-danger">*</span></label>
                                    <input type="text" pattern="\d*" name="rw" id="rw" class="form-control" value="<?= $alamat->rw ?>" required>
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="jalan">Nama Jalan</label>
                                <input type="text" name="jln" id="jalan" class="form-control" value="<?= $alamat->jln ?>" placeholder="Jalan Ke Rumah No 45">
                                <small class="text-muted">Kosongkan jika tidak ada</small>
                            </div>
                        </div>
                        <input type="hidden" name="kewarganegaraan" value="ID">

                        <hr>
                        <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
                        <button type="reset" class="btn btn-outline-secondary">RESET</button>
                        <a role="button" href="<?= site_url('pendaftar/detail/' . $alamat->id_akun) ?>" class="btn btn-secondary float-right">KEMBALI</a>
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