<?php if ($detail_pd) : ?>
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
                <hr class="my-0" />
                <div class="card-body">
                    <h5 class="h6 card-title">Persyaratan</h5>
                    <ul class="list-unstyled mb-0">
                        <?php if ($persyaratan) :
                            foreach ($persyaratan as $list) :
                                $cek_data = $this->db->get_where('pmb_persyaratan', ['id_akun' => $detail_pd->id_pd, 'id_jns_persyaratan' => $list->id_jns_persyaratan])->num_rows();
                                $check = ($cek_data > 0) ? '<span data-feather="check" class="feather-sm mr-1 text-success"></span> ' : '';
                        ?>
                                <li class="mb-1">
                                    <?= $check ?><?= $list->jns_persyaratan ?>
                                    <a class="small float-right">
                                        <span data-feather="edit-2" class="feather-sm"></span>
                                    </a>
                                </li>
                        <?php endforeach;
                        endif; ?>
                    </ul>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <a href="#" id="btn_hapus" class="text-danger" data-toggle="modal" data-target="#modal_hapus">Hapus Pendaftar</a>
                </div>
            </div>
            <!-- BEGIN modal -->
            <div class="modal fade" data-backdrop="static" id="modal_hapus" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center m-3">
                            <h5 class="mb-5">Anda yakin data <span class="text-danger"><?= $detail_pd->nm_pd ?></span> akan dihapus?</h5>
                            <button type="button" onclick="hapus(`<?= $detail_pd->id_pd ?>`)" class="btn btn-danger" data-dismiss="modal">Ya, hapus</button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END modal -->
        </div>

        <div class="col-md-7 col-xl-8">
            <div class="card">
                <div class="card-body h-100">
                    <!-- Biodata -->
                    <div class="mb-2 border-bottom d-flex justify-content-between">
                        <h5 class="card-title mb-3">Biodata</h5>
                        <div>
                            <a class="small float-right" href="<?= site_url('pendaftar/edit_biodata/' . $detail_pd->id_pd) ?>">
                                <span data-feather="edit-2" class="feather-sm"></span> Edit
                            </a>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Nama Lengkap</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->nm_pd ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">NIK</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->nik ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Tempat, Tanggal Lahir</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->tmpt_lahir . ', ' . $this->date->tanggal($detail_pd->tgl_lahir, 'p') ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Agama</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->nm_agama ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Jenis Kelamin</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= ($detail_pd->jk == 'L') ? 'Laki-laki' : 'Perempuan' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body h-100">
                    <!-- Kontak -->
                    <div class="mb-2 border-bottom d-flex justify-content-between">
                        <h5 class="card-title mb-3">Kontak</h5>
                        <div>
                            <a class="small float-right" href="<?= site_url('pendaftar/edit_kontak/' . $detail_pd->id_pd)  ?>">
                                <span data-feather="edit-2" class="feather-sm"></span> Edit
                            </a>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Nomor telepon orang tua</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->no_hp_ortu ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Nomor telepon pendaftar</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->no_hp ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Alamat email pendaftar</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= ($detail_pd->email) ? $detail_pd->email : 'Tidak diisi' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body h-100">
                    <!-- Alamat -->
                    <div class="mb-2 border-bottom d-flex justify-content-between">
                        <h5 class="card-title mb-3">Alamat</h5>
                        <div>
                            <a class="small float-right" href="<?= site_url('pendaftar/edit_alamat/' . $detail_pd->id_pd)  ?>">
                                <span data-feather="edit-2" class="feather-sm"></span> Edit
                            </a>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Jalan</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= ($detail_pd->jln) ? $detail_pd->jln : 'Tidak diisi' ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Alamat</label>
                        <div class="col-sm-8 col-form-label">
                            <?php
                            // ambil nama provinsi
                            $nm_prov = $this->db->get_where('ref_wilayah', ['id_wil' => $detail_pd->id_prov])->row();
                            // ambil nama kabupaten
                            $nm_kab  = $this->db->get_where('ref_wilayah', ['id_wil' => $detail_pd->id_kab])->row();
                            ?>

                            <p class="text-dark m-0"><?= $detail_pd->nm_dsn . ' RT ' . $detail_pd->rt . ' RW ' . $detail_pd->rw . ' Desa/Kel ' . $detail_pd->ds_kel . '<br>' . trim($detail_pd->nm_wil) . ' - ' . trim($nm_kab->nm_wil) . ' - ' . trim($nm_prov->nm_wil) ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Kode Pos</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->kode_pos ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body h-100">
                    <!-- Orang Tua -->
                    <div class="mb-2 border-bottom d-flex justify-content-between">
                        <h5 class="card-title mb-3">Orang Tua</h5>
                        <div>
                            <a class="small float-right" href="<?= site_url('pendaftar/edit_ortu/' . $detail_pd->id_pd)  ?>">
                                <span data-feather="edit-2" class="feather-sm"></span> Edit
                            </a>
                        </div>
                    </div>
                    <?php
                    // ambil pekerjaan ibu
                    $pekerjaan_ibu = $this->db->get_where('ref_pekerjaan', ['id_pekerjaan' => $detail_pd->id_pekerjaan_ibu])->row();
                    // ambil pekerjaan ayah
                    $pekerjaan_ayah = $this->db->get_where('ref_pekerjaan', ['id_pekerjaan' => $detail_pd->id_pekerjaan_ayah])->row();
                    ?>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Nama Ibu Kandung</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->nm_ibu ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Pekerjaan Ibu</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $pekerjaan_ibu->nm_pekerjaan ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Nama Ayah</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->nm_ayah ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Pekerjaan Ayah</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $pekerjaan_ayah->nm_pekerjaan ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body h-100">
                    <!-- Sekolah Asal -->
                    <div class="mb-2 border-bottom d-flex justify-content-between">
                        <h5 class="card-title mb-3">Sekolah / Kampus Asal</h5>
                        <div>
                            <a class="small float-right" href="<?= site_url('pendaftar/edit_sekolah_asal/' . $detail_pd->id_pd)  ?>">
                                <span data-feather="edit-2" class="feather-sm"></span> Edit
                            </a>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Nama Sekolah / Kampus</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->sekolah ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Alamat Sekolah</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->alamat_sekolah ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Mengetahui STIKes dari</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->jenis_masuk ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body h-100">
                    <!-- Prodi Pilihan -->
                    <div class="mb-2 border-bottom d-flex justify-content-between">
                        <h5 class="card-title mb-3">Program Studi Pilihan</h5>
                        <div>
                            <a class="small float-right" href="<?= site_url('pendaftar/edit_prodi/' . $detail_pd->id_pd)  ?>">
                                <span data-feather="edit-2" class="feather-sm"></span> Edit
                            </a>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Jenjang</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->jenjang_prodi ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Nama Program Studi</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->nm_prodi ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Jenis Kelas</label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $detail_pd->jenis_prodi ?></p>
                        </div>
                    </div>
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