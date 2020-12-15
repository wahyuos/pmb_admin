<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model informasi
 * 
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_informasi extends CI_Model
{
    // ambil data dari database
    public function getInformasi($id)
    {
        return $this->db->get_where('pmb_informasi', ['id_informasi' => $id])->row();
    }

    // simpan ke database
    public function simpanInformasi($data)
    {
        // set data untuk disimpan
        $value = [
            'id_informasi'    => uuid_v4(),
            'id_user'         => $this->session->id_user,
            'judul_informasi' => $data['judul_informasi'],
            'isi_informasi'   => $data['isi_informasi'],
            'created_at'      => date("Y-m-d H:i:s")
        ];
        // simpan ke tabel
        $simpan = $this->db->insert('pmb_informasi', $value);
        // cek status simpan
        if ($simpan) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Informasi berhasil disimpan',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal menyimpan informasi',
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }

        return $response;
    }

    // update ke database
    public function updateInformasi($data)
    {
        // set data untuk diupdate
        $value = [
            'id_user'         => $this->session->id_user,
            'judul_informasi' => $data['judul_informasi'],
            'isi_informasi'   => $data['isi_informasi'],
            'updated_at'      => date("Y-m-d H:i:s")
        ];
        // update tabel
        $update = $this->db->update('pmb_informasi', $value, ['id_informasi' => $data['id_informasi']]);
        // cek status update
        if ($update) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Informasi berhasil diubah',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal merubah informasi',
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }

        return $response;
    }

    public function hapusInformasi($id)
    {
        // jika ada id nya
        if ($id) {
            // hapus data dengan cara soft delete ubah ke 1
            $hapus = $this->db->update('pmb_informasi', ['soft_del' => '1'], ['id_informasi' => $id['id_informasi']]);
            if ($hapus) {
                // buat respon berhasil
                $response = [
                    'status'  => true,
                    'message' => 'Informasi berhasil dihapus',
                    'title'   => 'Berhasil',
                    'type'    => 'success'
                ];
            } else {
                // buat respon gagal
                $response = [
                    'status'  => false,
                    'message' => 'Informasi gagal dihapus',
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
        $table = "( SELECT id_informasi, judul_informasi, DATE(created_at) tgl_post FROM pmb_informasi WHERE soft_del = '0' ) as new_tb";
        $column_order = array(null, 'judul_informasi', 'tgl_post');
        $column_search = array('judul_informasi');
        $orders = array('tgl_post' => 'DESC');

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
