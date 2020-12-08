<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter urutan Class
 * 
 * Untuk membuat nomor urut otomatis
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Wahyu Kamaludin
 */

class CI_Urutan
{
    // urutan ke
    public function urutan($kode_prodi)
    {
        $urutan = get_instance()->db->select_max('urutan')->get_where('pmb_prodi_pilihan', ['id_prodi' => $kode_prodi])->row();
        // jika null
        if (empty($urutan)) {
            // default ke 1
            $start = 1;
        } else {
            // jika sudah ada, ditambah 1
            $start = $urutan->urutan + 1;
        }

        return $start;
    }

    // buat nomor pendaftaran
    public function nomordaftar($kode_prodi)
    {
        // kode PMB
        $kode_pmb = 'PMB';
        // tahun ambil 2 angka dibelakang
        $tahun_masuk = date('Y');
        // kode prodi
        $kode_prodi = $kode_prodi;
        // kode institusi
        $kode_institusi = '277';
        // panjang angka urutan
        $panjang = 3;

        $urutan = get_instance()->db->select_max('urutan')->get_where('pmb_prodi_pilihan', ['id_prodi' => $kode_prodi])->row();
        // jika null
        if (empty($urutan)) {
            // default ke 1
            $start = 1;
            $nomor_urut = str_pad($start, $panjang, 0, STR_PAD_LEFT);
        } else {
            // jika sudah ada, ditambah 1
            $start = $urutan->urutan + 1;
            $nomor_urut = str_pad($start, $panjang, 0, STR_PAD_LEFT);
        }

        // buat nomor daftar
        $nomor_daftar = $tahun_masuk . $kode_prodi . $kode_institusi . $nomor_urut;

        return $nomor_daftar;
    }
}
