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

    public function tes($id)
    {
        $bukti = $this->db->get_where('pmb_buktibayar', ['id_akun' => $id, 'soft_del' => '0'])->row();
        $data = [
            'title' => 'Halaman Utama',
            'm_home' => 'active',
            'bukti' => $bukti
        ];
        template('home/bukti', $data);
    }

    public function index()
    {
        // berdasarkan user
        $total_pendaftar_by_user = $this->grafik->total_pendaftar_by_user(tahun_akademik(), $this->session->id_user);
        // data kalkulasi pendaftar
        $total_pendaftar = $this->grafik->total_pendaftar(tahun_akademik());
        $total_daftar_hari_ini = $this->grafik->total_daftar_hari_ini();
        $total_pendaftar_pmdk = $this->grafik->total_pendaftar_pmdk(tahun_akademik());
        $total_pendaftar_umum = $this->grafik->total_pendaftar_umum(tahun_akademik());
        $list_gelombang_pmdk = $this->grafik->list_gelombang_pmdk(tahun_akademik());
        $total_pendaftar_pmdk_by_gelombang = $this->grafik->total_pendaftar_pmdk_by_gelombang(tahun_akademik());
        $list_gelombang_umum = $this->grafik->list_gelombang_umum(tahun_akademik());
        $total_pendaftar_umum_by_gelombang = $this->grafik->total_pendaftar_umum_by_gelombang(tahun_akademik());
        $list_peminat_prodi = $this->grafik->list_peminat_prodi(tahun_akademik());
        $list_program_studi = $this->grafik->list_program_studi(tahun_akademik());
        $total_peminat_program_studi = $this->grafik->total_peminat_program_studi(tahun_akademik());
        $warna_program_studi = $this->grafik->warna_program_studi(tahun_akademik());
        $list_referensi_masuk = $this->grafik->list_referensi_masuk(tahun_akademik());
        $rekap_pendaftar = $this->grafik->rekap_pendaftar(tahun_akademik());
        $rekap_jenjang_sekolah = $this->grafik->rekap_jenjang_sekolah(tahun_akademik());

        $data = [
            'title' => 'Halaman Utama',
            'm_home' => 'active',
            // berdasarkan user
            'total_pendaftar_by_user' => $total_pendaftar_by_user,
            // kalkulasi
            'total_pendaftar' => $total_pendaftar,
            'total_daftar_hari_ini' => $total_daftar_hari_ini,
            'total_pendaftar_pmdk' => $total_pendaftar_pmdk,
            'total_pendaftar_umum' => $total_pendaftar_umum,
            'list_gelombang_pmdk' => $list_gelombang_pmdk,
            'total_pendaftar_pmdk_by_gelombang' => $total_pendaftar_pmdk_by_gelombang,
            'list_gelombang_umum' => $list_gelombang_umum,
            'total_pendaftar_umum_by_gelombang' => $total_pendaftar_umum_by_gelombang,
            'list_peminat_prodi' => $list_peminat_prodi,
            'list_program_studi' => $list_program_studi,
            'total_peminat_program_studi' => $total_peminat_program_studi,
            'warna_program_studi' => $warna_program_studi,
            'list_referensi_masuk' => $list_referensi_masuk,
            'rekap_pendaftar' => $rekap_pendaftar,
            'rekap_jenjang_sekolah' => $rekap_jenjang_sekolah,
        ];
        template('home/index', $data);
    }
}
