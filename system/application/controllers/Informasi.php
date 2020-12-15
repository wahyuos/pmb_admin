<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Informasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        $this->load->model('M_ref', 'ref');
        $this->load->model('M_informasi', 'informasi');
    }

    public function index()
    {
        $data = [
            'title' => 'Informasi Pendaftaran',
            'm_info' => 'active',
        ];
        template('informasi/index', $data);
    }

    public function simpan()
    {
        // post data
        $post    = $this->input->post(null, true);
        if ($post) {
            $value = [
                'id_informasi'    => htmlspecialchars($post['id_informasi']),
                'judul_informasi' => htmlspecialchars($post['judul_informasi']),
                'isi_informasi'   => htmlspecialchars($post['isi_informasi'])
            ];
            // cek id
            if (empty($value['id_informasi'])) {
                // jika id kosong, kirim ke model simpan
                $response = $this->informasi->simpanInformasi($value);
            } else {
                // jika id ada, kirim ke model update sesuai id
                $response = $this->informasi->updateInformasi($value);
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
            $response = $this->informasi->getInformasi($id);
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
                'id_informasi' => htmlspecialchars($post->id_informasi)
            ];
            // kirim ke model simpan
            $response = $this->informasi->hapusInformasi($value);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    public function get_data()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            $list = $this->informasi->get_datatables();
            $data = array();
            foreach ($list as $field) {
                $row = array();
                $row[] = '<div class="btn-group btn-group-sm m-0" role="group" aria-label="Small button group">
                        <a role="button" onclick="edit(`' . $field->id_informasi . '`)" class="text-primary mr-2" title="EDIT"><i class="fas fa-pen"></i></a>
                        <a role="button" data-toggle="modal" data-target="#modal_' . $field->id_informasi . '" class="text-danger" title="HAPUS"><i class="fas fa-times"></i></a>
                        </div>' . modal_danger($field->id_informasi);
                $row[] = $field->judul_informasi;
                $row[] = $this->date->tanggal($field->tgl_post, 's');

                $data[] = $row;
            }

            $output = array(
                "draw" => $post['draw'],
                "recordsTotal" => $this->informasi->count_all(),
                "recordsFiltered" => $this->informasi->count_filtered(),
                "data" => $data,
            );

            echo json_encode($output);
        } else {
            $this->index();
        }
    }
}
