<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Bukti_bayar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        $this->load->model('M_bukti_bayar', 'bukti_bayar');
    }

    public function index()
    {
        $data = [
            'title' => 'Bukti Bayar',
            'm_bukti' => 'active',
        ];
        template('bukti_bayar/index', $data);
    }

    // menampilkan file bukti bayar
    public function lihat()
    {
        // raw data
        $data   = file_get_contents('php://input');
        // jika ada raw data
        if ($data) {
            $endata  = json_decode($data);
            // id yg akan dikirim
            $id_akun = htmlspecialchars($endata->id_akun);
            // kirim ke model 
            $response = $this->bukti_bayar->read($id_akun);
            // tampilkan hasil yang terima dari respon
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    // tombol switch untuk merubah verifikasi bukti bayar (diterima)
    public function status_diterima()
    {
        // raw data
        $data   = file_get_contents('php://input');
        // jika ada raw data
        if ($data) {
            $endata  = json_decode($data);
            // id yg akan dikirim
            $id_akun = htmlspecialchars($endata->id_akun);
            // kirim ke model 
            $response = $this->bukti_bayar->status_diterima($id_akun);
            // tampilkan hasil yang terima dari respon
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    // method untuk menampilkan semua data bukti bayar ke dalam datatable
    public function get_data()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            // ambil data dari model
            $list = $this->bukti_bayar->get_datatables();
            $data = array();
            $no   = $post['start'];
            foreach ($list as $field) {
                $switch_checked = ($field->verifikasi == 'Y') ? 'checked' : '';
                $no++;
                $row = array();
                $row[] = '<a role="button" data-toggle="modal" data-target="#modal_' . $field->id_akun . '" class="text-danger" title="HAPUS"><i class="fas fa-times"></i></a>' . modal_danger($field->id_akun, $field->nama_akun);
                $row[] = '<a role="button" onclick="lihat(`' . $field->id_akun . '`)">' . $field->nama_akun . '</a>';
                $row[] = $this->date->tanggal($field->tgl, 'p');
                $row[] = '<div class="custom-control custom-switch" title="STATUS">
                            <input type="checkbox" onchange="status_diterima(`' . $field->id_akun . '`)" class="custom-control-input" id="customSwitch' . $field->id_akun . '" ' . $switch_checked . '>
                            <label class="custom-control-label" for="customSwitch' . $field->id_akun . '"></label>
                        </div>';
                $data[] = $row;
            }

            $output = array(
                "draw" => $post['draw'],
                "recordsTotal" => $this->bukti_bayar->count_all(),
                "recordsFiltered" => $this->bukti_bayar->count_filtered(),
                "data" => $data,
            );
            // tampilkan data
            echo json_encode($output);
        } else {
            $this->index();
        }
    }
}
