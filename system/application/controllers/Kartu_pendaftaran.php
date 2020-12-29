<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

use Mpdf\Mpdf;

class Kartu_pendaftaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        $this->load->model('M_pendaftar', 'daftar');
        $this->load->model('M_ref', 'ref');
        $this->load->library('urutan');
    }

    public function index()
    {
    }

    // halaman detail lengkap pendaftar
    public function detail($id = null)
    {
        // cek id
        if ($id) {
            // get data pendaftar
            $detail = $this->daftar->read($id);
            // cek apakah data pendaftar ditemukan
            if ($detail) {
                // get jalur dan gelombang pendaftaran
                $gelombang = $this->daftar->getGelombang($detail->tgl_daftar);
                // get jadwal tes sesuai gelombang
                $jadwaltes = $this->daftar->getJadwalTes($gelombang->id_jadwal);
            } else {
                $gelombang = null;
            }
            // persyaratan
            $persyaratan = $this->ref->jnsPersyaratan();
            $data = [
                'title'       => 'Kartu Pendaftaran',
                'detail_pd'   => $detail,
                'gelombang'   => $gelombang,
                'jadwaltes'   => $jadwaltes,
                'persyaratan'    => $persyaratan,
                'm_pendaftaran'  => 'active',
                'dt_pendaftaran' => 'active',
            ];
            $mpdf = new Mpdf(['default_font_size' => 9, 'default_font' => 'dejavusans']);
            $kartu = $this->load->view('cetak/kartu_pendaftaran', $data, TRUE);
            $mpdf->SetTitle($data['title']);
            $mpdf->SetAuthor(aplikasi()->singkatan);
            $mpdf->SetCreator(aplikasi()->kampus);
            $mpdf->WriteHTML($kartu);
            $mpdf->Output($data['title'] . ' ' . aplikasi()->singkatan . '.pdf', 'I');
        } else {
            $this->index();
        }
    }
}