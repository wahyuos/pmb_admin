<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_grafik extends CI_Model
{
    // total pendaftar sesuai user
    public function total_pendaftar_by_user($tahun_akademik, $id_user)
    {
        return $this->db->get_where('v_data_pendaftar', ['tahun_akademik' => $tahun_akademik, 'id_user' => $id_user])->num_rows();
    }

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
        return $this->db->get_where('v_data_pendaftar', ['tgl_daftar' => $hari_ini])->num_rows();
    }

    // total pendaftar jalur pmdk
    public function total_pendaftar_pmdk($tahun_akademik)
    {
        return  $this->db->get_where('v_data_pendaftar', ['jalur' => 'PMDK', 'tahun_akademik' => $tahun_akademik])->num_rows();
    }

    // total pendaftar jalur umum
    public function total_pendaftar_umum($tahun_akademik)
    {
        return  $this->db->get_where('v_data_pendaftar', ['jalur' => 'UMUM', 'tahun_akademik' => $tahun_akademik])->num_rows();
    }

    // daftar gelombang pendaftaran jalur pmdk berdasarkan tahun akademik aktif
    public function list_gelombang_pmdk($tahun_akademik)
    {
        $jalur_pmdk = $this->db->order_by('nama_gelombang', 'ASC')->group_by('nama_gelombang')->get_where('v_data_pendaftar', ['jalur' => 'PMDK', 'tahun_akademik' => $tahun_akademik])->result();

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
        $jalur_umum = $this->db->order_by('nama_gelombang', 'ASC')->group_by('nama_gelombang')->get_where('v_data_pendaftar', ['jalur' => 'UMUM', 'tahun_akademik' => $tahun_akademik])->result();

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
        $jumlah = $this->db->select('count(id_akun) as jml_akun')
            ->from('v_data_pendaftar')
            ->where(['jalur' => 'PMDK', 'tahun_akademik' => $tahun_akademik])
            ->group_by('nama_gelombang')
            ->order_by('nama_gelombang', 'ASC')
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
        $jumlah = $this->db->select('count(id_akun) as jml_akun')
            ->from('v_data_pendaftar')
            ->where(['jalur' => 'UMUM', 'tahun_akademik' => $tahun_akademik])
            ->group_by('nama_gelombang')
            ->order_by('nama_gelombang', 'ASC')
            ->get()->result();

        // ambil value nya, simpan dalam json
        $total = [];
        foreach ($jumlah as $field) {
            $total[] = (int) $field->jml_akun;
        }
        // hasil [20, 23, ....]
        return json_encode($total);
    }

    // daftar prodi serta jumlah peminat
    public function list_peminat_prodi()
    {
        $prodi = $this->db->select('nama_prodi, warna, count(id_prodi) as jml')
            ->from('v_data_pendaftar a')
            ->group_by('id_prodi')
            ->order_by('id_prodi', 'ASC')
            ->get()->result();

        return $prodi;
    }

    // list program studi
    public function list_program_studi()
    {
        $prodi = $this->db->select('nama_prodi')
            ->from('v_data_pendaftar a')
            ->group_by('id_prodi')
            ->order_by('id_prodi', 'ASC')
            ->get()->result();

        // ambil value nya, simpan dalam json
        $list = [];
        foreach ($prodi as $field) {
            $list[] = $field->nama_prodi;
        }
        // hasil ["D3 Analis (Reguler)", "S1 Keperawatan (Karyawan)", ....]
        return json_encode($list);
    }

    // total peminat setiap prodi
    public function total_peminat_program_studi()
    {
        $prodi = $this->list_peminat_prodi();

        // ambil value nya, simpan dalam json
        $list = [];
        foreach ($prodi as $field) {
            $list[] = (int) $field->jml;
        }
        // hasil ["D3 Analis (Reguler)", "S1 Keperawatan (Karyawan)", ....]
        return json_encode($list);
    }

    // warna setiap prodi
    public function warna_program_studi()
    {
        $prodi = $this->db->select('warna')
            ->from('v_data_pendaftar a')
            ->group_by('id_prodi')
            ->order_by('id_prodi', 'ASC')
            ->get()->result();

        // ambil value nya, simpan dalam json
        $list = [];
        foreach ($prodi as $field) {
            $list[] = $field->warna;
        }
        // hasil ["D3 Analis (Reguler)", "S1 Keperawatan (Karyawan)", ....]
        return json_encode($list);
    }

    // daftar referensi masuk 
    public function list_referensi_masuk()
    {
        $referensi = $this->db->select('c.jenis_masuk, count(b.id_ref_masuk) as jml')
            ->from('v_data_pendaftar a')
            ->join('pmb_sekolah_asal b', 'a.id_akun = b.id_akun', 'LEFT')
            ->join('pmb_ref_masuk c', 'b.id_ref_masuk = c.id_ref_masuk', 'LEFT')
            ->group_by('c.id_ref_masuk')
            ->get()->result();

        return $referensi;
    }
}
