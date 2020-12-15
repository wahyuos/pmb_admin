<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Theme extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        $this->load->model('M_theme', 'theme');
    }

    public function ubah()
    {
        // raw data
        $data   = file_get_contents('php://input');
        // jika ada raw data
        if ($data) {
            $endata  = json_decode($data);
            // data yg akan dikirim
            $value = [
                'theme' => htmlspecialchars($endata->theme),
                'css' => htmlspecialchars($endata->css),
            ];
            // kirim ke model 
            $response = $this->theme->ubah_tema($value);
        } else {
            $response = [
                'status'  => false,
                'message' => 'Tidak ada yang diubah',
                'title'   => 'Gagal!',
                'type'    => 'danger'
            ];
        }
        // tampilkan hasil yang terima dari respon
        echo json_encode($response);
    }
}
