<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Ref_jadwal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        $this->load->model('M_ref', 'ref');
        $this->load->model('M_jadwal', 'jadwal');
    }

    public function index()
    {
        $data = [
            'title' => 'Jadwal Pendaftaran',
            'tahun_akademik' => tahun_akademik(),
            'm_jadwal' => 'active',
        ];
        template('jadwal/index', $data);
    }

    public function simpan()
    {
        // post data
        $post    = $this->input->post(null, true);
        if ($post) {
            $value = [
                'id_jadwal'      => htmlspecialchars($post['id_jadwal']),
                'jalur'          => htmlspecialchars($post['jalur']),
                'periode_awal'   => htmlspecialchars($post['periode_awal']),
                'periode_akhir'  => htmlspecialchars($post['periode_akhir']),
                'nama_gelombang' => htmlspecialchars($post['nama_gelombang']),
                'tahun_akademik' => htmlspecialchars($post['tahun_akademik']),
            ];
            // cek id
            if (empty($value['id_jadwal'])) {
                // jika id kosong, kirim ke model simpan
                $response = $this->jadwal->simpanJadwal($value);
            } else {
                // jika id ada, kirim ke model update sesuai id
                $response = $this->jadwal->updateJadwal($value);
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
            $response = $this->jadwal->getJadwal($id);
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
                'id_jadwal' => htmlspecialchars($post->id_jadwal)
            ];
            // kirim ke model simpan
            $response = $this->jadwal->hapusJadwal($value);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    public function get_data()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            $list = $this->jadwal->get_datatables();
            $data = array();
            foreach ($list as $field) {
                $row = array();
                $row[] = '<div class="btn-group btn-group-sm m-0" role="group" aria-label="Small button group">
                        <a role="button" onclick="edit(`' . $field->id_jadwal . '`)" class="text-primary mr-2" title="EDIT"><i class="fas fa-pen"></i></a>
                        <a role="button" data-toggle="modal" data-target="#modal_' . $field->id_jadwal . '" class="text-danger" title="HAPUS"><i class="fas fa-times"></i></a>
                        </div>' . modal_danger($field->id_jadwal, $field->nama_gelombang);
                $row[] = $field->nama_gelombang;
                $row[] = $field->jalur;
                $row[] = $this->date->tanggal($field->periode_awal, 's');
                $row[] = $this->date->tanggal($field->periode_akhir, 's');
                $row[] = $field->tahun_akademik;

                $data[] = $row;
            }

            $output = array(
                "draw" => $post['draw'],
                "recordsTotal" => $this->jadwal->count_all(),
                "recordsFiltered" => $this->jadwal->count_filtered(),
                "data" => $data,
            );

            echo json_encode($output);
        } else {
            $this->index();
        }
    }
}
