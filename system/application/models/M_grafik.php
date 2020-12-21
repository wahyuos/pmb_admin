<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_grafik extends CI_Model
{
    // total pendaftar
    public function total_pendaftar($tahun_akademik)
    {
        return $this->db->get_where('v_data_pendaftar', ['tahun_akademik' => $tahun_akademik])->num_rows();
    }

    // total pendaftar yang belum diterima
    public function total_pendaftar_pending($tahun_akademik)
    {
        return $this->db->get_where('v_data_pendaftar', ['status_diterima' => '0', 'tahun_akademik' => $tahun_akademik])->num_rows();
    }

    // total pendaftar yang sudah diterima
    public function total_pendaftar_diterima($tahun_akademik)
    {
        return $this->db->get_where('v_data_pendaftar', ['status_diterima' => '1', 'tahun_akademik' => $tahun_akademik])->num_rows();
    }

    // total daftar hari ini
    public function total_daftar_hari_ini()
    {
        $hari_ini = date('Y-m-d');
        return $this->db->get_where('v_data_pendaftar', ['tgl_akun', $hari_ini])->num_rows();
    }

    // total pendaftar jalur pmdk
    public function total_pendaftar_pmdk($tahun_akademik)
    {
        return  $this->db->select('b.nama_gelombang')
            ->from('pmb_akunmaba a')
            ->join('ref_jadwal b', 'a.id_jadwal = b.id_jadwal', 'LEFT')
            ->where(['b.tahun_akademik' => $tahun_akademik, 'b.jalur' => 'PMDK', 'b.soft_del' => '0'])
            ->get()->num_rows();
    }

    // total pendaftar jalur umum
    public function total_pendaftar_umum($tahun_akademik)
    {
        return  $this->db->select('b.nama_gelombang')
            ->from('pmb_akunmaba a')
            ->join('ref_jadwal b', 'a.id_jadwal = b.id_jadwal', 'LEFT')
            ->where(['b.tahun_akademik' => $tahun_akademik, 'b.jalur' => 'Umum', 'b.soft_del' => '0'])
            ->get()->num_rows();
    }

    // daftar gelombang pendaftaran jalur pmdk berdasarkan tahun akademik aktif
    public function list_gelombang_pmdk($tahun_akademik)
    {
        $jalur_pmdk = $this->db->select('b.nama_gelombang')
            ->from('pmb_akunmaba a')
            ->join('ref_jadwal b', 'a.id_jadwal = b.id_jadwal', 'LEFT')
            ->where(['b.tahun_akademik' => $tahun_akademik, 'b.jalur' => 'PMDK', 'b.soft_del' => '0'])
            ->order_by('b.periode_awal', 'ASC')
            ->get()->result();

        // ambil value nya, simpan dalam json
        $list = [];
        foreach ($jalur_pmdk as $field) {
            $list[] = $field->nama_gelombang;
        }
        // hasil ["nilai1", "nilai2", ....]
        return json_encode($list);
    }

    // daftar gelombang pendaftaran jalur umum berdasarkan tahun akademik aktif
    public function list_gelombang_umum($tahun_akademik)
    {
        $jalur_umum = $this->db->select('b.nama_gelombang')
            ->from('pmb_akunmaba a')
            ->join('ref_jadwal b', 'a.id_jadwal = b.id_jadwal', 'LEFT')
            ->where(['b.tahun_akademik' => $tahun_akademik, 'b.jalur' => 'Umum', 'b.soft_del' => '0'])
            ->order_by('b.periode_awal', 'ASC')
            ->get()->result();

        // ambil value nya, simpan dalam json
        $list = [];
        foreach ($jalur_umum as $field) {
            $list[] = $field->nama_gelombang;
        }
        // hasil ["nilai1", "nilai2", ....]
        return json_encode($list);
    }

    // total pendaftar tiap gelombang di jalur pmdk
    public function total_pendaftar_pmdk_by_gelombang($tahun_akademik)
    {
        $jumlah = $this->db->select('count(a.id_akun) as jml_akun')
            ->from('pmb_akunmaba a')
            ->join('ref_jadwal b', 'a.id_jadwal = b.id_jadwal', 'LEFT')
            ->where(['b.jalur' => 'PMDK', 'b.tahun_akademik' => $tahun_akademik, 'b.soft_del' => '0'])
            ->group_by('b.nama_gelombang')
            ->order_by('b.periode_awal', 'ASC')
            ->get()->result();

        // ambil value nya, simpan dalam json
        $total = [];
        foreach ($jumlah as $field) {
            $total[] = (int) $field->jml_akun;
        }
        // hasil [20, 23, ....]
        return json_encode($total);
    }

    // total pendaftar tiap gelombang di jalur umum
    public function total_pendaftar_umum_by_gelombang($tahun_akademik)
    {
        $jumlah = $this->db->select('count(a.id_akun) as jml_akun')
            ->from('pmb_akunmaba a')
            ->join('ref_jadwal b', 'a.id_jadwal = b.id_jadwal', 'LEFT')
            ->where(['b.jalur' => 'Umum', 'b.tahun_akademik' => $tahun_akademik, 'b.soft_del' => '0'])
            ->group_by('b.nama_gelombang')
            ->order_by('b.periode_awal', 'ASC')
            ->get()->result();

        // ambil value nya, simpan dalam json
        $total = [];
        foreach ($jumlah as $field) {
            $total[] = (int) $field->jml_akun;
        }
        // hasil [20, 23, ....]
        return json_encode($total);
    }
}
