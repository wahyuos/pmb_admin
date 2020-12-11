<?php if ($sekolah_asal) : ?>
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="f_edit" autocomplete="off">
                        <input type="hidden" id="id_akun" name="id_akun" value="<?= $sekolah_asal->id_akun ?>">
                        <input type="hidden" id="method" name="method" value="edit_sekolah_asal">

                        <!-- Sekolah Asal -->
                        <div class="mb-2 border-bottom">
                            <h5 class="card-title mb-1">Asal Sekolah</h5>
                            <label>Asal sekolah atau asal perguruan tinggi (bagi yang melanjutkan)</label>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="jenjang">Nama Jenjang Pendidikan <span class="text-danger">*</span></label>
                                <select class="form-control" name="jenjang" id="jenjang" required>
                                    <option selected disabled value="">Silahkan pilih</option>
                                    <option value="SMA" <?= ($sekolah_asal->jenjang == 'SMA') ? 'selected' : '' ?>>SMA</option>
                                    <option value="SMK" <?= ($sekolah_asal->jenjang == 'SMK') ? 'selected' : '' ?>>SMK</option>
                                    <option value="MA" <?= ($sekolah_asal->jenjang == 'MA') ? 'selected' : '' ?>>MA</option>
                                    <option value="Perguruan Tinggi" <?= ($sekolah_asal->jenjang == 'Perguruan Tinggi') ? 'selected' : '' ?>>Perguruan Tinggi</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sekolah">Nama sekolah/kampus asal <span class="text-danger">*</span></label>
                                <input type="text" name="sekolah" id="sekolah" class="form-control" value="<?= $sekolah_asal->sekolah ?>" placeholder="Apa nama sekolah/kampus kamu" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat_sekolah">Alamat sekolah/kampus <span class="text-danger">*</span></label>
                            <textarea name="alamat_sekolah" class="form-control" style="resize: none;" id="alamat_sekolah" cols="3" rows="2" required><?= $sekolah_asal->alamat_sekolah ?></textarea>
                        </div>
                        <div class="form-group mb-5">
                            <label for="id_ref_masuk">Darimana / dari siapa kamu tahu STIKes Muhammadiyah Ciamis <span class="text-danger">*</span></label>
                            <select class="form-control" name="id_ref_masuk" id="id_ref_masuk" required>
                                <option selected disabled value="">Silahkan pilih</option>
                                <?php if ($ref_masuk) :
                                    foreach ($ref_masuk as $list) :
                                        $selected = ($list->id_ref_masuk == $sekolah_asal->id_ref_masuk) ? 'selected' : '';
                                ?>
                                        <option value="<?= $list->id_ref_masuk ?>" <?= $selected ?>><?= $list->jenis_masuk ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                        </div>

                        <hr>
                        <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
                        <button type="reset" class="btn btn-outline-secondary">RESET</button>
                        <a role="button" href="<?= site_url('pendaftar/detail/' . $sekolah_asal->id_akun) ?>" class="btn btn-secondary float-right">KEMBALI</a>
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