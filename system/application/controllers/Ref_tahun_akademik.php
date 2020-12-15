<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Ref_tahun_akademik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        $this->load->model('M_ref', 'ref');
    }

    public function index()
    {
        $thn_akademik = $this->ref->tahun_akademik_aktif();
        $data = [
            'title' => 'Tahun Akademik',
            'ta' => $thn_akademik,
            'm_ta' => 'active',
        ];
        template('tahun_akademik/index', $data);
    }

    // merubah tahun akademik aktif saat memilih tahun akademik
    public function ganti_ta()
    {
        // raw data
        $data   = file_get_contents('php://input');
        // jika ada raw data
        if ($data) {
            $endata  = json_decode($data);
            // id yg akan dikirim
            $tahun = htmlspecialchars($endata->tahun);
            // kirim ke model 
            $response = $this->ref->ganti_tahun_akademik($tahun);
            // tampilkan hasil yang terima dari respon
            echo json_encode($response);
        } else {
            $this->index();
        }
    }
}
