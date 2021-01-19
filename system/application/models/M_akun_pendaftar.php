<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model akun pendaftar
 * 
 * Khusus akun para pendaftar
 * 
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_akun_pendaftar extends CI_Model
{
    // menghitung akun
    public function jmlAkun($tahun_akademik)
    {
        $jml = $this->db->get_where('pmb_akunmaba', ['tahun_akademik' => $tahun_akademik, 'soft_del' => '0'])->num_rows();

        return $jml;
    }

    // menghitung akun yang belum aktif
    public function jmlAkunNonaktif($tahun_akademik)
    {
        $jml = $this->db->select('b.id_akun')
            ->from('pmb_akunmaba a')
            ->join('pmb_verifikasi_akun b', 'a.id_akun = b.id_akun', 'LEFT')
            ->where(['a.tahun_akademik' => $tahun_akademik, 'b.status' => '0', 'a.soft_del' => '0'])
            ->get()->num_rows();

        return $jml;
    }

    // menghitung akun yang sudah daftar
    public function jmlDaftar($tahun_akademik)
    {
        $jml = $this->db->select('c.id_akun')
            ->from('pmb_akunmaba a')
            ->join('pmb_verifikasi_akun b', 'a.id_akun = b.id_akun', 'LEFT')
            ->join('v_data_pendaftar c', 'a.id_akun = c.id_akun', 'INNER')
            ->where(['a.tahun_akademik' => $tahun_akademik, 'a.soft_del' => '0'])
            ->get()->num_rows();

        return $jml;
    }

    // reset akun
    public function resetAkun($id)
    {
        // jika ada id nya
        if ($id) {
            // ambil data nomor hp
            $getData = $this->db->get_where('pmb_akunmaba', ['id_akun' => $id['id_akun']])->row();
            $nomor_hp = $getData->hp_akun;
            // set data untuk diupdate
            // ubah password menggunakan nomor hp
            $value = [
                'password_akun' => password_hash($nomor_hp, PASSWORD_DEFAULT),
                'updated_at'    => date("Y-m-d H:i:s")
            ];
            // reset password
            $reset = $this->db->update('pmb_akunmaba', $value, ['id_akun' => $id['id_akun']]);
            if ($reset) {
                // buat respon berhasil
                $response = [
                    'status'  => true,
                    'message' => 'Data berhasil direset',
                    'title'   => 'Berhasil',
                    'type'    => 'success'
                ];
            } else {
                // buat respon gagal
                $response = [
                    'status'  => false,
                    'message' => 'Data gagal direset',
                    'title'   => 'Gagal',
                    'type'    => 'error'
                ];
            }
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Tidak ditemukan ID dari data yang akan direset',
                'title'   => 'Gagal',
                'type'    => 'error'
            ];
        }

        return $response;
    }

    // hapus akun
    public function hapusAkun($id)
    {
        // jika ada id nya
        if ($id) {
            // hapus data dengan cara soft delete ubah ke 1
            $hapus = $this->db->update('pmb_akunmaba', ['soft_del' => '1'], ['id_akun' => $id['id_akun']]);
            if ($hapus) {
                // buat respon berhasil
                $response = [
                    'status'  => true,
                    'message' => 'Data berhasil dihapus',
                    'title'   => 'Berhasil',
                    'type'    => 'success'
                ];
            } else {
                // buat respon gagal
                $response = [
                    'status'  => false,
                    'message' => 'Data gagal dihapus',
                    'title'   => 'Gagal',
                    'type'    => 'error'
                ];
            }
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Tidak ditemukan ID dari data yang akan dihapus',
                'title'   => 'Gagal',
                'type'    => 'error'
            ];
        }

        return $response;
    }


    /**
     * ============================================================
     * DATATABLE QUERY
     * ============================================================
     */
    private function _get_datatables_query()
    {
        $table = "( SELECT a.id_akun, a.nama_akun, a.hp_akun, a.tgl_akun, DATE(a.tgl_akun) as tgl, b.status, c.no_daftar FROM pmb_akunmaba a LEFT JOIN pmb_verifikasi_akun b ON a.id_akun = b.id_akun LEFT JOIN v_data_pendaftar c ON a.id_akun = c.id_akun WHERE a.soft_del = '0' ) as new_tb";
        $column_order = array(null, 'nama_akun', 'hp_akun', 'tgl', 'status', 'no_daftar');
        $column_search = array('nama_akun', 'hp_akun');
        $orders = array('tgl_akun' => 'DESC');

        $this->db->from($table);

        $i = 0;

        foreach ($column_search as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($orders)) {
            foreach ($orders as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        $this->db->get();
        return $this->db->count_all_results();
    }
}
