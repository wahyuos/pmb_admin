<?php if ($ortu) : ?>
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="f_edit" autocomplete="off">
                        <input type="hidden" id="id_akun" name="id_akun" value="<?= $ortu->id_akun ?>">
                        <input type="hidden" id="method" name="method" value="edit_ortu">

                        <!-- Orang tua -->
                        <div class="mb-2 border-bottom">
                            <h5 class="card-title mb-1">Form Data Orang Tua</h5>
                            <label>Nama orang tua (terutama ibu) adalah orang tua asli/kandung.</label>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nm_ibu">Nama Ibu Kandung <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nm_ibu" name="nm_ibu" placeholder="Nama lengkap tanpa gelar" value="<?= $ortu->nm_ibu ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_pekerjaan_ibu">Pekerjaan Ibu <span class="text-danger">*</span></label>
                                <select class="form-control" name="id_pekerjaan_ibu" id="id_pekerjaan_ibu" required>
                                    <option selected disabled>Silahkan pilih</option>
                                    <?php if ($pekerjaan) :
                                        foreach ($pekerjaan as $list) :
                                            $selected = ($list->id_pekerjaan == $ortu->id_pekerjaan_ibu) ? 'selected' : '';
                                    ?>
                                            <option value="<?= $list->id_pekerjaan ?>" <?= $selected ?>><?= $list->nm_pekerjaan ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nm_ayah">Nama Ayah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nm_ayah" name="nm_ayah" placeholder="Nama lengkap tanpa gelar" value="<?= $ortu->nm_ayah ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_pekerjaan_ayah">Pekerjaan Ayah <span class="text-danger">*</span></label>
                                <select class="form-control" name="id_pekerjaan_ayah" id="id_pekerjaan_ayah" required>
                                    <option selected disabled>Silahkan pilih</option>
                                    <?php if ($pekerjaan) :
                                        foreach ($pekerjaan as $list) :
                                            $selected = ($list->id_pekerjaan == $ortu->id_pekerjaan_ayah) ? 'selected' : '';
                                    ?>
                                            <option value="<?= $list->id_pekerjaan ?>" <?= $selected ?>><?= $list->nm_pekerjaan ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
                        <button type="reset" class="btn btn-outline-secondary">RESET</button>
                        <a role="button" href="<?= site_url('pendaftar/detail/' . $ortu->id_akun) ?>" class="btn btn-secondary float-right">KEMBALI</a>
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