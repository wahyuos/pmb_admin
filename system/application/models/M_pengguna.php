<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model pengguna
 * 
 * Superadmin, Admin, Guru BP
 * 
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_pengguna extends CI_Model
{
    // ambil data dari database
    public function getPengguna($id)
    {
        return $this->db->get_where('adm_user', ['id_user' => $id])->row();
    }

    // simpan data pengguna dari fitur import
    public function importPengguna($data)
    {
        // hitung banyak data
        $jumlah = count($data);
        // simpan semua data sekaligus
        $simpan = $this->db->insert_batch('adm_user', $data);
        if ($simpan) {
            $response = [
                'status'  => true,
                'message' => $jumlah . " pengguna berhasil disimpan",
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            $response = [
                'status'  => false,
                'message' => "Gagal menyimpan data",
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }

        return $response;
    }

    // simpan ke database
    public function simpanPengguna($data)
    {
        // set data untuk disimpan
        $value = [
            'id_user'   => uuid_v4(),
            'username'  => $data['username'],
            'password'  => set_password($data['password']),
            'nama_user' => $data['nama_user'],
            'level'     => $data['level'],
            'created_at' => date("Y-m-d H:i:s")
        ];
        // simpan ke tabel
        $simpan = $this->db->insert('adm_user', $value);
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
    public function updatePengguna($data)
    {
        // cek kolom password
        if (empty($data['password'])) {
            // jika password tidak diganti, jangan diupdate
            $value = [
                'username'  => $data['username'],
                'nama_user' => $data['nama_user'],
                'level'     => $data['level'],
                'updated_at' => date("Y-m-d H:i:s")
            ];
        }
        // jika password diganti
        else {
            // set data untuk diupdate
            $value = [
                'username'  => $data['username'],
                'password'  => set_password($data['password']),
                'nama_user' => $data['nama_user'],
                'level'     => $data['level'],
                'updated_at' => date("Y-m-d H:i:s")
            ];
        }
        // update tabel
        $update = $this->db->update('adm_user', $value, ['id_user' => $data['id_user']]);
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

    public function hapusPengguna($id)
    {
        // jika ada id nya
        if ($id) {
            // hapus data dengan cara soft delete ubah ke 1
            $hapus = $this->db->update('adm_user', ['soft_del' => '1'], ['id_user' => $id['id_user']]);
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
        $table = "( SELECT * FROM adm_user WHERE level <> 'super' AND soft_del = '0' ) as new_tb";
        $column_order = array(null, 'nama_user', 'username', 'level');
        $column_search = array('nama_user', 'username', 'level');
        $orders = array('level' => 'ASC', 'nama_user' => 'ASC');

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
