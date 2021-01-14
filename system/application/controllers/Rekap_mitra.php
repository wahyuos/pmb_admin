<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Rekap_mitra extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        $this->load->model('M_rekap_mitra', 'rekap_mitra');
        $this->load->model('M_mitra', 'mitra');
    }

    public function index()
    {
        // total pendaftar oleh mitra
        $total = $this->rekap_mitra->totalByMitra(tahun_akademik());
        $data = [
            'title' => 'Rekapitulasi Mitra',
            'm_rekap_mitra' => 'active',
            'total' => $total->total
        ];
        template('rekap_mitra/index', $data);
    }

    public function detail($id_user)
    {
        $data_siswa = $this->rekap_mitra->getDataPendaftar($id_user);
        $mitra = $this->mitra->getMitra($id_user);
        $data = [
            'title' => 'Rekapitulasi Mitra',
            'm_rekap_mitra' => 'active',
            'pendaftar' => $data_siswa,
            'mitra' => $mitra
        ];
        template('rekap_mitra/detail', $data);
    }

    public function get_data()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            $list = $this->rekap_mitra->get_datatables();
            $data = array();
            $no = 1;
            foreach ($list as $field) {
                $row = array();
                $row[] = $no++;
                $row[] = strtoupper($field->nama_user);
                $row[] = $field->instansi;
                $row[] = $field->jml . ' orang';
                $row[] = '<a href="' . site_url('rekap_mitra/detail/' . $field->id_user) . '" class="btn btn-sm btn-primary">Detail</a>';

                $data[] = $row;
            }

            $output = array(
                "draw" => $post['draw'],
                "recordsTotal" => $this->rekap_mitra->count_all(),
                "recordsFiltered" => $this->rekap_mitra->count_filtered(),
                "data" => $data,
            );

            echo json_encode($output);
        } else {
            $this->index();
        }
    }
}
