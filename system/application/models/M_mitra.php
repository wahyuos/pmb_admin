<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model mitra
 * 
 * Manajemen akun mitra
 * 
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_mitra extends CI_Model
{
    // ambil data dari database
    public function getMitra($id)
    {
        $this->db->select('*')
            ->from('pmb_admin a')
            ->join('adm_user b', 'a.id_user = b.id_user', 'LEFT')
            ->where(['a.id_user' => $id]);
        return $this->db->get()->row();
    }

    // simpan data mitra dari fitur import
    public function importMitra($data, $data_admin)
    {
        // hitung banyak data
        $jumlah = count($data);
        // simpan semua data sekaligus
        $simpan = $this->db->insert_batch('adm_user', $data);
        if ($simpan) {
            $simpan_admin = $this->db->insert_batch('pmb_admin', $data_admin);
            if ($simpan_admin) {
                $response = [
                    'status'  => true,
                    'message' => $jumlah . " mitra berhasil disimpan",
                    'title'   => 'Berhasil!',
                    'type'    => 'success'
                ];
            } else {
                $response = [
                    'status'  => false,
                    'message' => "Gagal menyimpan data admin",
                    'title'   => 'Gagal!',
                    'type'    => 'error'
                ];
            }
        } else {
            $response = [
                'status'  => false,
                'message' => "Gagal menyimpan data akun",
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }

        return $response;
    }

    // simpan ke database
    public function simpanMitra($data)
    {
        // set data untuk disimpan ke akun
        $value = [
            'id_user'   => uuid_v4(),
            'username'  => $data['username'],
            'password'  => set_password($data['password']),
            'nama_user' => $data['nama_user'],
            'level'     => 'mitra',
            'created_at' => date("Y-m-d H:i:s")
        ];

        // set data untuk ke admin
        $val_admin = [
            'id_admin'   => uuid_v4(),
            'nama_admin' => $data['nama_user'],
            'id_user'    => $value['id_user'],
            'instansi'   => $data['instansi'],
        ];
        // simpan ke tabel user
        $simpan_user = $this->db->insert('adm_user', $value);
        // cek status simpan
        if ($simpan_user) {

            // simpan ke tabel admin
            $simpan_admin = $this->db->insert('pmb_admin', $val_admin);
            // cek status simpan
            if ($simpan_admin) {
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
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal menyimpan akun',
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }

        return $response;
    }

    // update ke database
    public function updateMitra($data)
    {
        // cek kolom password
        if (empty($data['password'])) {
            // jika password tidak diganti, jangan diupdate
            $value = [
                'username'  => $data['username'],
                'nama_user' => $data['nama_user'],
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
                'updated_at' => date("Y-m-d H:i:s")
            ];
        }

        // set data untuk ke admin
        $val_admin = [
            'nama_admin' => $data['nama_user'],
            'instansi'   => $data['instansi'],
        ];

        // update tabel akun
        $update_akun = $this->db->update('adm_user', $value, ['id_user' => $data['id_user']]);
        // cek status update
        if ($update_akun) {

            // update tabel admin
            $update_admin = $this->db->update('pmb_admin', $val_admin, ['id_user' => $data['id_user']]);
            // cek status update
            if ($update_admin) {
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
                    'message' => 'Gagal merubah akun',
                    'title'   => 'Gagal!',
                    'type'    => 'error'
                ];
            }
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal merubah akun',
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }

        return $response;
    }

    public function hapusMitra($id)
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
        $table = "( SELECT b.*, a.instansi FROM pmb_admin a LEFT JOIN adm_user b ON a.id_user = b.id_user WHERE b.level = 'mitra' AND b.soft_del = '0' ) as new_tb";
        $column_order = array(null, 'nama_user', 'username', 'instansi');
        $column_search = array('nama_user', 'username', 'instansi');
        $orders = array('nama_user' => 'ASC');

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
