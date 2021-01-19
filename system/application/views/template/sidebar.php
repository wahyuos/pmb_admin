<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="<?= site_url('home') ?>">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve">
                <path d="M19.4,4.1l-9-4C10.1,0,9.9,0,9.6,0.1l-9,4C0.2,4.2,0,4.6,0,5s0.2,0.8,0.6,0.9l9,4C9.7,10,9.9,10,10,10s0.3,0,0.4-0.1l9-4
              C19.8,5.8,20,5.4,20,5S19.8,4.2,19.4,4.1z" />
                <path d="M10,15c-0.1,0-0.3,0-0.4-0.1l-9-4c-0.5-0.2-0.7-0.8-0.5-1.3c0.2-0.5,0.8-0.7,1.3-0.5l8.6,3.8l8.6-3.8c0.5-0.2,1.1,0,1.3,0.5
              c0.2,0.5,0,1.1-0.5,1.3l-9,4C10.3,15,10.1,15,10,15z" />
                <path d="M10,20c-0.1,0-0.3,0-0.4-0.1l-9-4c-0.5-0.2-0.7-0.8-0.5-1.3c0.2-0.5,0.8-0.7,1.3-0.5l8.6,3.8l8.6-3.8c0.5-0.2,1.1,0,1.3,0.5
              c0.2,0.5,0,1.1-0.5,1.3l-9,4C10.3,20,10.1,20,10,20z" />
            </svg>

            <span class="align-middle mr-3"><?= aplikasi()->singkatan ?></span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Menu Utama
            </li>
            <li class="sidebar-item <?= (isset($m_home)) ? $m_home : '' ?>">
                <a class="sidebar-link" href="<?= base_url('home') ?>">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item <?= (isset($m_pendaftaran)) ? $m_pendaftaran : '' ?>">
                <a href="#pendaftar" data-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Pendaftaran</span>
                </a>
                <ul id="pendaftar" class="sidebar-dropdown list-unstyled collapse <?= (isset($m_pendaftaran)) ? 'show' : '' ?>" data-parent="#sidebar">
                    <?php
                    // pengecekan pendaftaran dibuka atau belum
                    // if ($this->cek_pendaftaran->status(date('Y-m-d'))['status']) : 
                    ?>
                    <li class="sidebar-item <?= (isset($dt_tambah)) ? $dt_tambah : '' ?>"><a class="sidebar-link" href="<?= base_url('pendaftar/tambah') ?>">Tambah Pendaftar</a></li>
                    <?php //endif; 
                    ?>
                    <li class="sidebar-item <?= (isset($dt_pendaftaran)) ? $dt_pendaftaran : '' ?>"><a class="sidebar-link" href="<?= base_url('pendaftar') ?>">Data Pendaftar</a></li>
                </ul>
            </li>

            <?php
            // untuk user dengan level super atau admin
            if ($this->session->level == 'super' || $this->session->level == 'admin') : ?>
                <li class="sidebar-item <?= (isset($m_rekap_mitra)) ? $m_rekap_mitra : '' ?>">
                    <a class="sidebar-link" href="<?= base_url('rekap_mitra') ?>">
                        <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">Rekapitulasi Mitra</span>
                    </a>
                </li>
                <li class="sidebar-item <?= (isset($m_bukti)) ? $m_bukti : '' ?>">
                    <a class="sidebar-link" href="<?= base_url('bukti_bayar') ?>">
                        <i class="align-middle" data-feather="pocket"></i> <span class="align-middle">Bukti Bayar</span>
                    </a>
                </li>
                <li class="sidebar-item <?= (isset($m_info)) ? $m_info : '' ?>">
                    <a class="sidebar-link" href="<?= base_url('informasi') ?>">
                        <i class="align-middle" data-feather="bell"></i> <span class="align-middle">Informasi</span>
                    </a>
                </li>
                <li class="sidebar-item <?= (isset($m_biaya)) ? $m_biaya : '' ?>">
                    <a class="sidebar-link" href="<?= base_url('biaya') ?>">
                        <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Rincian Biaya</span>
                    </a>
                </li>

                <li class="sidebar-header">
                    Konfigurasi
                </li>
                <li class="sidebar-item <?= (isset($m_jadwal)) ? $m_jadwal : '' ?>">
                    <a class="sidebar-link" href="<?= base_url('ref_jadwal') ?>">
                        <i class="align-middle" data-feather="calendar"></i> <span class="align-middle">Jadwal Pendaftaran</span>
                    </a>
                </li>
                <li class="sidebar-item <?= (isset($m_ta)) ? $m_ta : '' ?>">
                    <a class="sidebar-link" href="<?= base_url('ref_tahun_akademik') ?>">
                        <i class="align-middle" data-feather="feather"></i> <span class="align-middle">Tahun Akademik</span>
                    </a>
                </li>
            <?php
            endif;
            // hanya untuk user dengan level super
            if ($this->session->level == 'super' || $this->session->level == 'admin') : ?>
                <li class="sidebar-header">
                    Manajemen User
                </li>
                <?php if ($this->session->level == 'super') : ?>
                    <li class="sidebar-item <?= (isset($m_user)) ? $m_user : '' ?>">
                        <a class="sidebar-link" href="<?= base_url('pengguna') ?>">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Akun Admin</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="sidebar-item <?= (isset($m_akun_pendaftar)) ? $m_akun_pendaftar : '' ?>">
                    <a class="sidebar-link" href="<?= base_url('akun_pendaftar') ?>">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Akun Pendaftar</span>
                    </a>
                </li>
                <li class="sidebar-item <?= (isset($m_mitra)) ? $m_mitra : '' ?>">
                    <a class="sidebar-link" href="<?= base_url('mitra') ?>">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Akun Mitra</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="sidebar-header">
                Aksi
            </li>
            <li class="sidebar-item <?= (isset($m_panduan)) ? $m_panduan : '' ?>">
                <a class="sidebar-link" href="<?= base_url('panduan') ?>">
                    <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Panduan</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= base_url('logout') ?>">
                    <i class="align-middle" data-feather="power"></i> <span class="align-middle">Logout</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-cta">
            <div class="sidebar-cta-content">
                <strong class="d-inline-block mb-2">Warna Tema</strong>
                <div class="mb-3 text-sm">
                    Pilih salah satu warna
                </div>
                <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio" onclick="ubah_theme(`light`,`light`)">
                        <input name="custom-radio-3" type="radio" id="theme_light" name="theme" value="light" class="custom-control-input" <?= (theme()->theme == 'light') ? 'checked' : '' ?>>
                        <span class="custom-control-label" for="theme_light">Light</span>
                    </label>
                    <label class="custom-control custom-radio" onclick="ubah_theme(`colored`,`light`)">
                        <input name="custom-radio-3" type="radio" id="theme_colored" name="theme" value="light" class="custom-control-input" <?= (theme()->theme == 'colored') ? 'checked' : '' ?>>
                        <span class="custom-control-label" for="theme_colored">Blue</span>
                    </label>
                    <label class="custom-control custom-radio" onclick="ubah_theme(`default`,`light`)">
                        <input name="custom-radio-3" type="radio" id="theme_default" name="theme" value="light" class="custom-control-input" <?= (theme()->theme == 'default') ? 'checked' : '' ?>>
                        <span class="custom-control-label" for="theme_default">Semi Dark</span>
                    </label>
                    <label class="custom-control custom-radio" onclick="ubah_theme(`dark`,`dark`)">
                        <input name="custom-radio-3" type="radio" id="theme_dark" name="theme" value="dark" class="custom-control-input" <?= (theme()->theme == 'dark') ? 'checked' : '' ?>>
                        <span class="custom-control-label" for="theme_dark">Dark</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</nav>