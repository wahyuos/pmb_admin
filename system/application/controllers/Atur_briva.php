<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Atur_briva extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        if ($this->session->level == 'mitra') redirect(base_url('home'));

        $this->load->model('M_atur_briva', 'atur_briva');
    }

    public function index()
    {
        // ambil data briva
        $briva = $this->atur_briva->get_briva();
        $data = [
            'title' => 'Atur BRIVA',
            'm_briva' => 'active',
            'info_briva' => $briva
        ];
        template('atur_briva/index', $data);
    }

    public function getData($id = null)
    {
        if ($id) {
            // ambil data berdasarkan kode briva
            // digunakan untuk edit data
            $response = $this->atur_briva->getDataByBriva($id);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    public function simpan()
    {
        // post data
        $post    = $this->input->post(null, true);
        if ($post) {
            $value = [
                'urlApi'    => $post['urlApi'],
                'kodeInstitusi' => $post['kodeInstitusi'],
                'kodebriva'   => $post['kodebriva'],
                'biayaDaftar'   => $post['biayaDaftar'],
                'ketBayar'   => $post['ketBayar'],
            ];
            $response = $this->atur_briva->updateInfoBriva($value);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }
}
