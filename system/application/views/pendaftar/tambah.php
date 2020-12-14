<div class="row">

    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <form id="f_tambah_pendaftar" autocomplete="off">
                    <input type="hidden" id="id_akun" name="id_akun" value="<?= uuid_v4() ?>">

                    <!-- Biodata -->
                    <div class="mb-2 border-bottom">
                        <h5 class="card-title mb-1">Form Biodata</h5>
                        <label>Data peserta yang dimasukkan harus sesuai dengan KTP/KK atau Ijazah</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nm_pd">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nm_pd" name="nm_pd" required autofocus>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nik">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                            <input type="text" pattern="\d*" minlength="16" maxlength="16" class="form-control" id="nik" name="nik" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tmpt_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tmpt_lahir" name="tmpt_lahir" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="text" onfocus="(this.type='date')" min="<?= date('Y-m-d', strtotime('-50 years', strtotime(date('Y-m-d')))) ?>" max="<?= date('Y-m-d', strtotime('-16 years', strtotime(date('Y-m-d')))) ?>" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="id_agama">Agama <span class="text-danger">*</span></label>
                            <select class="form-control" name="id_agama" id="id_agama" required>
                                <option selected disabled>Silahkan pilih</option>
                                <?php if ($agama) :
                                    foreach ($agama as $list) : ?>
                                        <option value="<?= $list->id_agama ?>"><?= $list->nm_agama ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="jk">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div class="form-group border p-1 pl-2 m-0 rounded">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="l" name="jk" value="L" class="custom-control-input" required>
                                    <label class="custom-control-label" for="l">Laki-laki </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="p" name="jk" value="P" class="custom-control-input" required>
                                    <label class="custom-control-label" for="p">Perempuan </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="mb-2 mt-4 border-bottom">
                        <h5 class="card-title mb-1">Form Kontak</h5>
                        <label>Gunakan nomor HP atau email yang aktif dan bisa dihubungi.</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="no_hp_ortu">Nomor HP Orang Tua <span class="text-danger">*</span></label>
                            <input type="text" pattern="\d*" minlength="8" maxlength="13" class="form-control" id="no_hp_ortu" name="no_hp_ortu" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="no_hp">Nomor HP Peserta <span class="text-danger">*</span></label>
                            <input type="text" pattern="\d*" minlength="8" maxlength="13" class="form-control" id="no_hp" name="no_hp" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="email">Email Peserta</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="namaemail@mail.com">
                        </div>
                    </div>

                    <!-- Orang tua -->
                    <div class="mb-2 mt-4 border-bottom">
                        <h5 class="card-title mb-1">Form Data Orang Tua</h5>
                        <label>Nama orang tua (terutama ibu) adalah orang tua asli/kandung.</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nm_ibu">Nama Ibu Kandung <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nm_ibu" name="nm_ibu" placeholder="Nama lengkap tanpa gelar" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_pekerjaan_ibu">Pekerjaan Ibu <span class="text-danger">*</span></label>
                            <select class="form-control" name="id_pekerjaan_ibu" id="id_pekerjaan_ibu" required>
                                <option selected disabled>Silahkan pilih</option>
                                <?php if ($pekerjaan) :
                                    foreach ($pekerjaan as $list) : ?>
                                        <option value="<?= $list->id_pekerjaan ?>"><?= $list->nm_pekerjaan ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nm_ayah">Nama Ayah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nm_ayah" name="nm_ayah" placeholder="Nama lengkap tanpa gelar" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_pekerjaan_ayah">Pekerjaan Ayah <span class="text-danger">*</span></label>
                            <select class="form-control" name="id_pekerjaan_ayah" id="id_pekerjaan_ayah" required>
                                <option selected disabled>Silahkan pilih</option>
                                <?php if ($pekerjaan) :
                                    foreach ($pekerjaan as $list) : ?>
                                        <option value="<?= $list->id_pekerjaan ?>"><?= $list->nm_pekerjaan ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-2 mt-4 border-bottom">
                        <h5 class="card-title mb-1">Form Alamat</h5>
                        <label>Khusus untuk kolom propinsi, kabupaten/kota, dan kecamatan.<br>Ketik nama (propinsi, kabupaten/kota, kecamatan) pada kolom, kemudian pilih</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="nm_prov">Propinsi <span class="text-danger">*</span></label>
                            <input type="hidden" name="id_prov" id="id_prov">
                            <input type="text" name="nm_prov" id="nm_prov" class="form-control" placeholder="Cari nama provinsi" required>
                            <div id="list_provinsi" style="position: absolute;z-index:1000"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="nm_kab">Kabupaten/Kota <span class="text-danger">*</span></label>
                            <input type="hidden" name="id_kab" id="id_kab">
                            <input type="text" name="nm_kab" id="nm_kab" class="form-control" placeholder="Cari nama kabupaten/kota" required>
                            <div id="list_kabupaten" style="position: absolute;z-index:1000"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="nm_wil">Kecamatan <span class="text-danger">*</span></label>
                            <input type="hidden" name="id_wil" id="id_wil">
                            <input type="text" name="nm_wil" id="nm_wil" class="form-control" placeholder="Cari nama kecamatan" required>
                            <div id="list_kecamatan" style="position: absolute;z-index:1000"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="desa">Desa/Kelurahan <span class="text-danger">*</span></label>
                            <input type="text" name="ds_kel" id="desa" class="form-control" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dusun">Dusun/Kampung <span class="text-danger">*</span></label>
                            <input type="text" name="nm_dsn" id="dusun" class="form-control" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="kode_pos">Kode POS <span class="text-danger">*</span></label>
                            <input type="text" pattern="\d*" minlength="5" maxlength="5" name="kode_pos" id="kode_pos" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <div class="form-group">
                                <label for="rt">RT <span class="text-danger">*</span></label>
                                <input type="text" pattern="\d*" name="rt" id="rt" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="form-group">
                                <label for="rw">RW <span class="text-danger">*</span></label>
                                <input type="text" pattern="\d*" name="rw" id="rw" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="jalan">Nama Jalan</label>
                            <input type="text" name="jln" id="jalan" class="form-control" placeholder="Jalan Ke Rumah No 45">
                            <small class="text-muted">Kosongkan jika tidak ada</small>
                        </div>
                    </div>
                    <input type="hidden" name="kewarganegaraan" value="ID">

                    <!-- Sekolah Asal -->
                    <div class="mb-2 mt-4 border-bottom">
                        <h5 class="card-title mb-1">Asal Sekolah</h5>
                        <label>Asal sekolah atau asal perguruan tinggi (bagi yang melanjutkan)</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="jenjang">Nama Jenjang Pendidikan <span class="text-danger">*</span></label>
                            <select class="form-control" name="jenjang" id="jenjang" required>
                                <option selected disabled value="">Silahkan pilih</option>
                                <option value="SMA">SMA</option>
                                <option value="SMK">SMK</option>
                                <option value="MA">MA</option>
                                <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sekolah">Nama sekolah/kampus asal <span class="text-danger">*</span></label>
                            <input type="text" name="sekolah" id="sekolah" class="form-control" placeholder="Nama sekolah/kampus" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat_sekolah">Alamat sekolah/kampus <span class="text-danger">*</span></label>
                        <textarea name="alamat_sekolah" class="form-control" style="resize: none;" id="alamat_sekolah" cols="3" rows="2" required></textarea>
                    </div>
                    <div class="form-group mb-5">
                        <label for="id_ref_masuk">Darimana / dari siapa tahu STIKes Muhammadiyah Ciamis <span class="text-danger">*</span></label>
                        <select class="form-control" name="id_ref_masuk" id="id_ref_masuk" required>
                            <option selected disabled value="">Silahkan pilih</option>
                            <?php if ($ref_masuk) :
                                foreach ($ref_masuk as $list) : ?>
                                    <option value="<?= $list->id_ref_masuk ?>"><?= $list->jenis_masuk ?></option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <!-- Prodi Pilihan -->
                    <div class="mb-2 mt-4 border-bottom">
                        <h5 class="card-title mb-1">Program Studi Pilihan</h5>
                        <label>Pilih jenis kelas, kemudian pilih program studi</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="">Pilih Jenis Kelas <span class="text-danger">*</span></label>
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio">
                                    <input name="custom-radio-3" type="radio" class="custom-control-input" onclick="prodiReg()" required>
                                    <span class="custom-control-label">Kelas Regular</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input name="custom-radio-3" type="radio" class="custom-control-input" onclick="prodiKar()" required>
                                    <span class="custom-control-label">Kelas Karyawan</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div id="prodiReg" style="display: none;">
                                <div class="form-group mb-5">
                                    <label for="id_prodi">Program Studi Kelas Reguler <span class="text-danger">*</span></label>
                                    <div class="custom-controls-stacked">
                                        <?php if ($prodi_reg) :
                                            foreach ($prodi_reg as $list) : ?>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" name="id_prodi" value="<?= $list->id_prodi ?>" class="custom-control-input" required>
                                                    <span class="custom-control-label"><?= $list->jenjang . ' ' . $list->nm_prodi ?></span>
                                                </label>
                                        <?php endforeach;
                                        endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div id="prodiKar" style="display: none;">
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
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // peringatan reload atau close halaman
    // mencegah reload/close halaman saat mengisi form daftar
    // window.addEventListener("beforeunload", function(event) {
    //     event.returnValue = "Anda akan menutup halaman ini?";
    // });

    function prodiReg() {
        document.getElementById("prodiReg").style.display = "block";
        document.getElementById("prodiKar").style.display = "none";
    }

    function prodiKar() {
        document.getElementById("prodiKar").style.display = "block";
        document.getElementById("prodiReg").style.display = "none";
    }
</script>