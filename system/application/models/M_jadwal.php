<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model jadwal pendaftaran
 * 
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_jadwal extends CI_Model
{
    // ambil data dari database
    public function getJadwal($id)
    {
        return $this->db->get_where('ref_jadwal', ['id_jadwal' => $id])->row();
    }

    // simpan ke database
    public function simpanJadwal($data)
    {
        // set data untuk disimpan
        $value = [
            'id_jadwal'      => uuid_v4(),
            'jalur'          => $data['jalur'],
            'periode_awal'   => $data['periode_awal'],
            'periode_akhir'  => $data['periode_akhir'],
            'nama_gelombang' => $data['nama_gelombang'],
            'tahun_akademik' => $data['tahun_akademik'],
        ];
        // simpan ke tabel
        $simpan = $this->db->insert('ref_jadwal', $value);
        // cek status simpan
        if ($simpan) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Data berhasil disimpan',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal menyimpan data',
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }

        return $response;
    }

    // update ke database
    public function updateJadwal($data)
    {
        // set data untuk diupdate
        $value = [
            'jalur'          => $data['jalur'],
            'periode_awal'   => $data['periode_awal'],
            'periode_akhir'  => $data['periode_akhir'],
            'nama_gelombang' => $data['nama_gelombang'],
            'tahun_akademik' => $data['tahun_akademik'],
        ];
        // update tabel
        $update = $this->db->update('ref_jadwal', $value, ['id_jadwal' => $data['id_jadwal']]);
        // cek status update
        if ($update) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Data berhasil diubah',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal merubah data',
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }

        return $response;
    }

    public function hapusJadwal($id)
    {
        // jika ada id nya
        if ($id) {
            // hapus data dengan cara soft delete ubah ke 1
            $hapus = $this->db->update('ref_jadwal', ['soft_del' => '1'], ['id_jadwal' => $id['id_jadwal']]);
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
        // filter by tahun akademik
        $ta = tahun_akademik();
        $table = "( SELECT * FROM ref_jadwal WHERE tahun_akademik = '$ta' AND soft_del = '0' ) as new_tb";
        $column_order = array(null, 'nama_gelombang', 'jalur', 'periode_awal', 'periode_akhir', null);
        $column_search = array('nama_gelombang', 'jalur', 'periode_awal', 'periode_akhir', 'tahun_akademik');
        $orders = array('periode_awal' => 'ASC');

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
