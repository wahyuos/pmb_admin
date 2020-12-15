<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_ref extends CI_Model
{

    public function cek_data($table, $id)
    {
        // periksa data peserta pada tabel yang dimaksud berdasarkan id_akun
        $cek_data = $this->db->get_where($table, ['id_akun' => $id])->num_rows();
        return ($cek_data == 0) ? true : false;
    }

    public function ganti_tahun_akademik($tahun)
    {
        // ubah status 1 jadi 0
        $ubah_status = $this->db->update('pmb_tahun_aktif', ['status' => '0']);
        if ($ubah_status) {
            // periksa apakah tahun sudah ada
            $cek = $this->db->get_where('pmb_tahun_aktif', ['tahun' => $tahun])->num_rows();
            if ($cek > 0) {
                // jika sudah ada
                // aktifkan status jadi 1 berdasarkan tahun yang diterima
                $aktifkan = $this->db->update('pmb_tahun_aktif', ['status' => '1'], ['tahun' => $tahun]);
                if ($aktifkan) {
                    $response = [
                        'status'  => true,
                        'message' => "Tahun akademik berhasil diganti",
                        'title'   => 'Berhasil!',
                        'type'    => 'success'
                    ];
                } else {
                    $response = [
                        'status'  => false,
                        'message' => "Tahun akademik gagal diganti",
                        'title'   => 'Berhasil!',
                        'type'    => 'success'
                    ];
                }
            } else {
                // jika belum ada data, tambahkan
                $value = [
                    'tahun' => $tahun,
                    'tahun_akademik' => $tahun . '/' . ($tahun + 1),
                    'status' => '1'
                ];
                $simpan = $this->db->insert('pmb_tahun_aktif', $value);
                if ($simpan) {
                    $response = [
                        'status'  => true,
                        'message' => "Tahun akademik berhasil disimpan",
                        'title'   => 'Berhasil!',
                        'type'    => 'success'
                    ];
                } else {
                    $response = [
                        'status'  => false,
                        'message' => "Tahun akademik gagal disimpan",
                        'title'   => 'Berhasil!',
                        'type'    => 'success'
                    ];
                }
            }
        } else {
            $response = [
                'status'  => false,
                'message' => "Gagal dinonaktifkan",
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        }

        return $response;
    }

    public function tahun_akademik_aktif()
    {
        return $this->db->get_where('pmb_tahun_aktif', "status = '1'")->row();
    }

    public function jnsPersyaratan()
    {
        return $this->db->order_by('id_jns_persyaratan', 'asc')->get('pmb_jns_persyaratan')->result();
    }

    public function get_prodi($jns_prodi)
    {
        $this->db->select('a.id_prodi, b.jenjang, b.nm_prodi, a.kode_prodi, a.jenis_prodi')
            ->from('ref_jns_prodi a')
            ->join('ref_prodi b', 'a.kode_prodi = b.kode_prodi', 'LEFT')
            ->order_by('a.id_prodi', 'asc')
            ->where(['jenis_prodi' => $jns_prodi]);
        return $this->db->get()->result();
    }

    public function get_agama()
    {
        return $this->db->get('ref_agama')->result();
    }

    public function get_negara()
    {
        return $this->db->get('ref_negara')->result();
    }

    public function get_penghasilan()
    {
        return $this->db->order_by('id_penghasilan', 'ASC')->get_where('ref_penghasilan', "id_penghasilan <> 0")->result();
    }

    public function get_pekerjaan()
    {
        return $this->db->order_by('id_pekerjaan', 'ASC')->get_where('ref_pekerjaan', "id_pekerjaan <> 0")->result();
    }

    public function get_jenjang_pendidikan()
    {
        return $this->db->order_by('id_jenj_didik', 'ASC')->get('ref_jenjang_pendidikan')->result();
    }

    public function get_ref_masuk()
    {
        return $this->db->order_by('id_ref_masuk', 'ASC')->get('pmb_ref_masuk')->result();
    }

    /**
     * Mengambil data provinsi sesuai kata yang diketik serta induk wilayah
     */
    public function get_provinsi($keyword, $id_induk)
    {
        // ambil data provinsi sesuai id_induk yang diterima
        // jumlah data dibatasi maksimal hanya 3 data yang tampil
        $data_prov = $this->db->limit(3)->like('nm_wil', $keyword)->get_where('ref_wilayah', ['id_level_wil' => '1', 'id_induk_wilayah' => $id_induk])->result();
        // jika data ditemukan,
        if ($data_prov) {
            // simpan dalam array
            foreach ($data_prov as $ret) {
                $data = [
                    'id_wil' => $ret->id_wil,
                    'nm_wil' => $ret->nm_wil,
                ];
                $response[] = $data;
            }
        }
        // jika data tidak ada
        else {
            // berikan nilai kosong
            $response = null;
        }
        // kembalikan nilai yang ada
        return $response;
    }

    /**
     * Mengambil data kabupaten/kota sesuai kata yang diketik serta induk wilayah
     */
    public function get_kab_kota($keyword, $id_provinsi)
    {
        // ambil data kabupaten/kota sesuai id_induk yang diterima
        // jumlah data dibatasi maksimal hanya 3 data yang tampil
        $data_kab = $this->db->limit(3)->like('nm_wil', $keyword)->get_where('ref_wilayah', ['id_level_wil' => '2', 'id_induk_wilayah' => $id_provinsi])->result();
        // jika data ditemukan,
        if ($data_kab) {
            // simpan dalam array
            foreach ($data_kab as $ret) {
                $data = [
                    'id_wil' => $ret->id_wil,
                    'nm_wil' => $ret->nm_wil,
                ];
                $response[] = $data;
            }
        }
        // jika data tidak ada
        else {
            // berikan nilai kosong
            $response = null;
        }
        // kembalikan nilai yang ada
        return $response;
    }

    /**
     * Mengambil data kecamatan sesuai kata yang diketik serta induk wilayah
     */
    public function get_kecamatan($keyword, $id_kab_kota)
    {
        // ambil data kecamatan sesuai id_induk yang diterima
        // jumlah data dibatasi maksimal hanya 3 data yang tampil
        $data_kecamatan = $this->db->limit(3)->like('nm_wil', $keyword)->get_where('ref_wilayah', ['id_level_wil' => '3', 'id_induk_wilayah' => $id_kab_kota])->result();
        // jika data ditemukan,
        if ($data_kecamatan) {
            // simpan dalam array
            foreach ($data_kecamatan as $ret) {
                $data = [
                    'id_wil' => $ret->id_wil,
                    'nm_wil' => $ret->nm_wil,
                ];
                $response[] = $data;
            }
        }
        // jika data tidak ada
        else {
            // berikan nilai kosong
            $response = null;
        }
        // kembalikan nilai yang ada
        return $response;
    }
}
