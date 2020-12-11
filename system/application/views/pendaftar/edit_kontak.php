<?php if ($kontak) : ?>
    <div class="row">
        <div class="col-md-12 col-xl-12">
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