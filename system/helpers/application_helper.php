<?php
defined('BASEPATH') or exit('No direct script access allowed');

// ------------------------------------------------------------------------

if (!function_exists('template')) {
    /**
     * Template konten
     *
     * Memanggil template konten.
     * @param   string Lokasi direktori dari file views
     * @param	array Data array yang ditampung
     */
    function template($template, $data = null)
    {
        $data['_sidebar']  = get_instance()->load->view('template/sidebar.php', $data, true);
        $data['_content'] = get_instance()->load->view($template, $data, true);
        get_instance()->load->view('template/template.php', $data);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('aplikasi')) {
    /**
     * Aplikasi
     *
     * Tampilkan detail aplikasi.
     * @param   boolean Berikan nilai default
     * @return	mixed Return data dari database, jika data kosong maka return nilai default
     */
    function aplikasi($default = false)
    {
        $get_app = get_instance()->db->get('pmb_app')->row();
        return ($get_app) ? $get_app : $default;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('theme')) {
    /**
     * Theme aplikasi
     *
     * Warna tema yang ingin digunakan.
     * @return	mixed Return data dari database, jika data kosong maka return nilai default
     */
    function theme($default = false)
    {
        $theme = get_instance()->db->get('ref_theme')->row();
        return ($theme) ? $theme : $default;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('uuid_v4')) {
    /**
     * UUID versi 4
     *
     * Membuat nilai UUID otomatis.
     * @author Dan Storm
     * @link http://catalystcode.net/
     * @license GNU LPGL
     * @version 2.1
     * 
     * @param   boolean
     * @return  string  Nilai UUID
     */
    function uuid_v4($trim = false)
    {

        $format = ($trim == false) ? '%04x%04x-%04x-%04x-%04x-%04x%04x%04x' : '%04x%04x%04x%04x%04x%04x%04x%04x';

        return sprintf(
            $format,

            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}

// ------------------------------------------------------------------------

if (!function_exists('csrfName')) {
    /**
     * CSRF Token Name
     *
     * Nama dari token csrf .
     * @return	string  Return csrf token name
     */
    function csrfName()
    {
        return get_instance()->security->get_csrf_token_name();
    }
}

// ------------------------------------------------------------------------

if (!function_exists('csrfHash')) {
    /**
     * CSRF Hash
     *
     * Hash dari csrf .
     * @return	string  Return csrf hash
     */
    function csrfHash()
    {
        return get_instance()->security->get_csrf_hash();
    }
}

// ------------------------------------------------------------------------

if (!function_exists('set_password')) {
    /**
     * Set Password
     *
     * Ubah pasword dengan password_hash default.
     * @param   string Text password
     * @return	string  Return password_hash
     */
    function set_password($pass = null)
    {
        // hash dengan password_default
        return password_hash($pass, PASSWORD_DEFAULT);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('tahun_akademik')) {
    /**
     * Tahun Akademik
     *
     * Mengambil tahun akademik yang sedang aktif.
     * @return	string  Return tahun akademik
     */
    function tahun_akademik()
    {
        // ambil data tahun yang aktif
        $ta = get_instance()->db->get_where('pmb_tahun_aktif', ['status' => '1'])->row();
        return $ta->tahun_akademik;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('modal_danger')) {
    /**
     * Modal
     *
     * Menampilkan modal
     * @param id ID data
     * @param name Nama data
     * @return	string  tampilkan modal
     */
    function modal_danger($id = null, $name = null)
    {
        $modal = '<!-- BEGIN modal -->
        <div class="modal fade" data-backdrop="static" id="modal_' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body m-3 text-center">
                        <h4>Anda yakin data <span class="text-danger">' . $name . '</span> akan dihapus?</h4>
                        <p class="mb-5">Data yang dihapus tidak dapat dikembalikan lagi.</p>
                        <button type="button" onclick="hapus(`' . $id . '`)" class="btn btn-danger" data-dismiss="modal">Ya, hapus</button>
                        <a href="#" class="btn text-dark" data-dismiss="modal">Batal</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END modal -->';

        return $modal;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('modal_reset')) {
    /**
     * Modal
     *
     * Menampilkan modal
     * @param id ID data
     * @param name Nama data
     * @return	string  tampilkan modal
     */
    function modal_reset($id = null, $name = null)
    {
        $modal = '<!-- BEGIN modal -->
        <div class="modal fade" data-backdrop="static" id="reset_' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body m-3 text-center">
                        <h4 class="mb-5">Anda yakin akun <span class="text-danger">' . $name . '</span> akan direset?</h4>
                        <button type="button" onclick="reset(`' . $id . '`)" class="btn btn-danger" data-dismiss="modal">Ya, reset</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END modal -->';

        return $modal;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('arr_briva')) {
    function arr_briva($default = false)
    {
        $get_briva = get_instance()->db->get('ref_pmbva')->row();
        return ($get_briva) ? $get_briva : $default;
    }
}

// ------------------------------------------------------------------------
