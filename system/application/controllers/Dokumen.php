<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Dokumen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        if ($this->session->level == 'mitra') redirect(base_url('home'));
        $this->load->model('M_dokumen', 'dokumen');
    }

    public function index()
    {
        // ambil dokumen
        $list = $this->dokumen->get_dokumen(tahun_akademik());
        $data = [
            'title' => 'Dokumen',
            'm_dokumen' => 'active',
            'list' => $list,
        ];
        template('dokumen/index', $data);
    }

    /**
     * Proses menyimpan dokumen 
     */
    public function simpan()
    {
        // post data
        $post    = $this->input->post(null, true);
        if ($post) {
            $config['upload_path']   = './assets/docs';
            $config['allowed_types'] = 'pdf';
            $config['max_size']      = 5210;
            $config['overwrite']     = true;
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
                $file_data  = $this->upload->data();

                // set value untuk disimpan
                $value = [
                    'nama_dokumen'  => $post['nama_dokumen'],
                    'file_path' => 'assets/docs/',
                    'file_name' => $file_data['file_name'],
                    'file_type' => $file_data['file_type'],
                    'tahun_akademik' => tahun_akademik(),
                ];

                // kirim ke model simpan
                $response = $this->dokumen->simpan($value);
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

    public function hapus()
    {
        // raw data
        $data   = file_get_contents('php://input');
        // jika ada raw data
        // lakukan proses pengecekan
        if ($data) {
            // encode data
            $post  = json_decode($data);
            $value = [
                'id_dokumen' => htmlspecialchars($post->id_dokumen)
            ];
            // kirim ke model simpan
            $response = $this->dokumen->hapus($value);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }
}
