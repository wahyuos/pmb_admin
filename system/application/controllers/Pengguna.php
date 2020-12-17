<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Pengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        if ($this->session->level == 'mitra') redirect(base_url('home'));

        $this->load->model('M_pengguna', 'pengguna');
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Pengguna',
            'm_user' => 'active',
        ];
        template('pengguna/index', $data);
    }

    public function simpan()
    {
        // post data
        $post    = $this->input->post(null, true);
        if ($post) {
            $value = [
                'id_user'   => htmlspecialchars($post['id_user']),
                'nama_user' => htmlspecialchars($post['nama_user']),
                'username'  => htmlspecialchars($post['username']),
                'password'  => htmlspecialchars($post['password']),
            ];
            // cek id
            if (empty($value['id_user'])) {
                // jika id kosong, kirim ke model simpan
                $response = $this->pengguna->simpanPengguna($value);
            } else {
                // jika id ada, kirim ke model update sesuai id
                $response = $this->pengguna->updatePengguna($value);
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
            $response = $this->pengguna->getPengguna($id);
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
                'id_user' => htmlspecialchars($post->id_user)
            ];
            // kirim ke model simpan
            $response = $this->pengguna->hapusPengguna($value);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    public function get_data()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            $list = $this->pengguna->get_datatables();
            $data = array();
            foreach ($list as $field) {
                $row = array();
                $row[] = '<div class="btn-group btn-group-sm m-0" role="group" aria-label="Small button group">
                        <a role="button" onclick="edit(`' . $field->id_user . '`)" class="text-primary mr-2" title="EDIT"><i class="fas fa-pen"></i></a>
                        <a role="button" data-toggle="modal" data-target="#modal_' . $field->id_user . '" class="text-danger" title="HAPUS"><i class="fas fa-times"></i></a>
                        </div>' . modal_danger($field->id_user, $field->nama_user);
                $row[] = $field->nama_user;
                $row[] = $field->username;

                $data[] = $row;
            }

            $output = array(
                "draw" => $post['draw'],
                "recordsTotal" => $this->pengguna->count_all(),
                "recordsFiltered" => $this->pengguna->count_filtered(),
                "data" => $data,
            );

            echo json_encode($output);
        } else {
            $this->index();
        }
    }
}
