<?php if ($biodata) : ?>
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="f_edit" autocomplete="off">
                        <input type="hidden" id="id_akun" name="id_akun" value="<?= $biodata->id_akun ?>">
                        <input type="hidden" id="method" name="method" value="edit_biodata">

                        <!-- Biodata -->
                        <div class="mb-2 border-bottom">
                            <h5 class="card-title mb-1">Form Biodata</h5>
                            <label>Data peserta yang dimasukkan harus sesuai dengan KTP/KK atau Ijazah</label>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nm_pd">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nm_pd" name="nm_pd" value="<?= $biodata->nm_pd ?>" required autofocus>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nik">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                                <input type="text" pattern="\d*" minlength="16" maxlength="16" class="form-control" id="nik" name="nik" value="<?= $biodata->nik ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tmpt_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tmpt_lahir" name="tmpt_lahir" value="<?= $biodata->tmpt_lahir ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="text" onfocus="(this.type='date')" min="<?= date('Y-m-d', strtotime('-50 years', strtotime(date('Y-m-d')))) ?>" max="<?= date('Y-m-d', strtotime('-16 years', strtotime(date('Y-m-d')))) ?>" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= $biodata->tgl_lahir ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="id_agama">Agama <span class="text-danger">*</span></label>
                                <select class="form-control" name="id_agama" id="id_agama" required>
                                    <option selected disabled>Silahkan pilih</option>
                                    <?php if ($agama) :
                                        foreach ($agama as $list) :
                                            $selected = ($list->id_agama == $biodata->id_agama) ? 'selected' : '';
                                    ?>
                                            <option value="<?= $list->id_agama ?>" <?= $selected ?>><?= $list->nm_agama ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jk">Jenis Kelamin <span class="text-danger">*</span></label>
                                <div class="form-group border p-1 pl-2 m-0 rounded">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <?php $l = ($biodata->jk == 'L') ? 'checked' : ''; ?>
                                        <input type="radio" id="l" name="jk" value="L" class="custom-control-input" <?= $l ?> required>
                                        <label class="custom-control-label" for="l">Laki-laki </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <?php $p = ($biodata->jk == 'P') ? 'checked' : ''; ?>
                                        <input type="radio" id="p" name="jk" value="P" class="custom-control-input" <?= $p ?> required>
                                        <label class="custom-control-label" for="p">Perempuan </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
                        <button type="reset" class="btn btn-outline-secondary">RESET</button>
                        <a role="button" href="<?= site_url('pendaftar/detail/' . $biodata->id_akun) ?>" class="btn btn-secondary float-right">KEMBALI</a>
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