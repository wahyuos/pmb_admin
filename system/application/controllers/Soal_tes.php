<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Soal_tes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        if ($this->session->level == 'mitra') redirect(base_url('home'));

        $this->load->model('M_soal', 'soal');
    }

    public function index()
    {
        $data = [
            'title' => 'Soal Tes Tulis',
            'm_soal' => 'active'
        ];
        template('tes_tulis/soal_tes', $data);
    }

    public function simpan()
    {
        // post data
        $post    = $this->input->post(null, true);
        if ($post) {
            $value = [
                'id_soal'   => htmlspecialchars($post['id_soal']),
                'pertanyaan' => $post['pertanyaan'],
                'opsi_a'  => htmlspecialchars($post['opsi_a']),
                'opsi_b'  => htmlspecialchars($post['opsi_b']),
                'opsi_c'  => htmlspecialchars($post['opsi_c']),
                'opsi_d'  => htmlspecialchars($post['opsi_d']),
                'opsi_e'  => htmlspecialchars($post['opsi_e']),
                'jawaban'  => htmlspecialchars($post['jawaban']),
            ];
            // cek id
            if (empty($value['id_soal'])) {
                // jika id kosong, kirim ke model simpan
                $response = $this->soal->simpanSoal($value);
            } else {
                // jika id ada, kirim ke model update sesuai id
                $response = $this->soal->updateSoal($value);
            }
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    public function getDataById($id = null)
    {
        if ($id) {
            // ambil data berdasarkan id
            // digunakan untuk edit data
            $response = $this->soal->getSoal($id);
            echo json_encode($response);
        } else {
            $this->index();
        }
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
                'id_soal' => htmlspecialchars($post->id_soal)
            ];
            // kirim ke model simpan
            $response = $this->soal->hapusSoal($value);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    // ambil data untuk datatabel
    public function get_data()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            $list = $this->soal->get_datatables();
            $data = array();
            foreach ($list as $field) {
                $row = array();
                $row[] = '<div class="btn-group btn-group-sm m-0" role="group" aria-label="Small button group">
                        <a role="button" onclick="edit(`' . $field->id_soal . '`)" class="text-primary mr-2" title="EDIT"><i class="fas fa-pen"></i></a>
                        <a role="button" data-toggle="modal" data-target="#modal_' . $field->id_soal . '" class="text-danger" title="HAPUS"><i class="fas fa-times"></i></a>
                        </div>' . modal_danger($field->id_soal, $field->id_soal);
                $row[] = substr($field->pertanyaan, 0, 100) . " ...";
                $row[] = $field->jawaban;

                $data[] = $row;
            }

            $output = array(
                "draw" => $post['draw'],
                "recordsTotal" => $this->soal->count_all(),
                "recordsFiltered" => $this->soal->count_filtered(),
                "data" => $data,
            );

            echo json_encode($output);
        } else {
            $this->index();
        }
    }
}
