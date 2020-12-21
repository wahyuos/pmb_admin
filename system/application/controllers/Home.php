<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        $this->load->model('M_grafik', 'grafik');
    }

    public function index()
    {
        // data kalkulasi pendaftar
        $total_pendaftar = $this->grafik->total_pendaftar(tahun_akademik());
        $total_daftar_hari_ini = $this->grafik->total_daftar_hari_ini();
        $total_pendaftar_pmdk = $this->grafik->total_pendaftar_pmdk(tahun_akademik());
        $total_pendaftar_umum = $this->grafik->total_pendaftar_umum(tahun_akademik());
        $list_gelombang_pmdk = $this->grafik->list_gelombang_pmdk(tahun_akademik());
        $total_pendaftar_pmdk_by_gelombang = $this->grafik->total_pendaftar_pmdk_by_gelombang(tahun_akademik());
        $list_gelombang_umum = $this->grafik->list_gelombang_umum(tahun_akademik());
        $total_pendaftar_umum_by_gelombang = $this->grafik->total_pendaftar_umum_by_gelombang(tahun_akademik());

        $data = [
            'title' => 'Halaman Utama',
            'm_home' => 'active',
            // kalkulasi
            'total_pendaftar' => $total_pendaftar,
            'total_daftar_hari_ini' => $total_daftar_hari_ini,
            'total_pendaftar_pmdk' => $total_pendaftar_pmdk,
            'total_pendaftar_umum' => $total_pendaftar_umum,
            'list_gelombang_pmdk' => $list_gelombang_pmdk,
            'total_pendaftar_pmdk_by_gelombang' => $total_pendaftar_pmdk_by_gelombang,
            'list_gelombang_umum' => $list_gelombang_umum,
            'total_pendaftar_umum_by_gelombang' => $total_pendaftar_umum_by_gelombang,
        ];
        template('home/index', $data);
    }
}
