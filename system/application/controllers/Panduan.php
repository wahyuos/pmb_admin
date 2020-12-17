<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Panduan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        // if ($this->session->level != 'super') redirect(base_url('home'));
        $this->load->model('M_panduan', 'panduan');
    }

    private function lihat()
    {
        // ambil panduan untuk tahun akademik yang aktif
        $doc = $this->panduan->get_panduan(tahun_akademik());
        $data = [
            'title' => 'Panduan',
            'doc_panduan' => $doc,
            'm_panduan' => 'active',
        ];
        template('panduan/lihat', $data);
    }

    public function index()
    {
        // jika level bukan super, hanya bisa lihat
        if ($this->session->level != 'super') {
            $this->lihat();
        } else {
            // ambil panduan untuk tahun akademik yang aktif
            $doc = $this->panduan->get_panduan(tahun_akademik());
            $data = [
                'title' => 'Panduan',
                'doc_panduan' => $doc,
                'm_panduan' => 'active',
            ];
            template('panduan/index', $data);
        }
    }

    /**
     * Proses menyimpan dokumen panduan peserta
     */
    public function simpan()
    {
        // post data
        $post    = $this->input->post(null, true);
        if ($post) {
            $config['upload_path']   = './assets/docs';
            $config['allowed_types'] = 'pdf';
            $config['max_size']      = 1024;
            // $config['max_width']            = 512;
            // $config['max_height']           = 512;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
                // buat respon
                $response = [
                    'status'  => false,
                    'message' => $this->upload->display_errors(),
                    'title'   => 'Gagal!',
                    'type'    => 'danger'
                ];
            } else {
                $image_data  = $this->upload->data();

                // set value untuk disimpan
                $value = [
                    'file_path' => 'assets/docs/',
                    'file_name' => $image_data['file_name'],
                    'file_type' => $image_data['file_type'],
                ];

                // kirim ke model simpan
                $response = $this->panduan->simpan($value);
            }
        } else {
            // buat respon
            $response = [
                'status'  => false,
                'message' => 'Tidak ada data',
                'title'   => 'Gagal!',
                'type'    => 'danger'
            ];
        }

        echo json_encode($response);
    }
}
