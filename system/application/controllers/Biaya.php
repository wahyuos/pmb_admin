<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Biaya extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        if ($this->session->level == 'mitra') redirect(base_url('home'));
        $this->load->model('M_biaya', 'biaya');
        $this->load->model('M_ref', 'ref');
    }

    // public function index()
    // {
    //     // ambil biaya untuk tahun akademik yang aktif
    //     $doc = $this->biaya->get_biaya(tahun_akademik());
    //     $data = [
    //         'title' => 'Rincian Biaya',
    //         'doc_biaya' => $doc,
    //         'm_biaya' => 'active',
    //         'dt_semua' => 'active'
    //     ];
    //     template('biaya/index', $data);
    // }

    public function index()
    {
        // list prodi
        $prodi = $this->ref->get_prodi('Reguler');
        // ambil biaya prodi untuk tahun akademik yang aktif
        $list = $this->biaya->get_biaya_prodi(tahun_akademik());
        $data = [
            'title' => 'Rincian Biaya',
            'list' => $list,
            'prodi' => $prodi,
            'm_biaya' => 'active',
            // 'dt_prodi' => 'active'
        ];
        template('biaya/prodi', $data);
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
                'id_biaya_prodi' => htmlspecialchars($post->id_biaya_prodi)
            ];
            // kirim ke model simpan
            $response = $this->biaya->hapus($value);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    /**
     * Proses menyimpan dokumen biaya peserta
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
                    'id_prodi'  => $post['id_prodi'],
                    'file_path' => 'assets/docs/',
                    'file_name' => $image_data['file_name'],
                    'file_type' => $image_data['file_type'],
                    'tahun_akademik' => tahun_akademik(),
                ];

                // kirim ke model simpan
                $response = $this->biaya->simpan($value);
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
