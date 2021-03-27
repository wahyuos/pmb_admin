<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Hasil_tes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        if ($this->session->level == 'mitra') redirect(base_url('home'));
        $this->load->model('M_hasil_tes', 'hasil');
    }

    public function index()
    {
        $data = [
            'title' => 'Hasil Tes Tulis',
            'm_hasil' => 'active',
        ];
        template('tes_tulis/hasil_tes', $data);
    }

    // method untuk menampilkan semua data bukti bayar ke dalam datatable
    public function get_data()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            // ambil data dari model
            $list = $this->hasil->get_datatables();
            $data = array();
            $no   = $post['start'];
            foreach ($list as $field) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->nama_akun;
                $row[] = $this->date->tanggal($field->tgl, 's');
                $row[] = $field->nilai;
                $data[] = $row;
            }

            $output = array(
                "draw" => $post['draw'],
                "recordsTotal" => $this->hasil->count_all(),
                "recordsFiltered" => $this->hasil->count_filtered(),
                "data" => $data,
            );
            // tampilkan data
            echo json_encode($output);
        } else {
            $this->index();
        }
    }
}
