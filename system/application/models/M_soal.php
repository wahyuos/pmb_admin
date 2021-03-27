<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model soal
 * 
 * Khusus admin
 * 
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_soal extends CI_Model
{
    // ambil data dari database
    public function getSoal($id)
    {
        return $this->db->get_where('pmb_soal_tes', ['id_soal' => $id])->row();
    }

    // simpan ke database
    public function simpanSoal($data)
    {
        // set data untuk disimpan ke akun
        $value = [
            'pertanyaan'  => $data['pertanyaan'],
            'opsi_a' => $data['opsi_a'],
            'opsi_b' => $data['opsi_b'],
            'opsi_c' => $data['opsi_c'],
            'opsi_d' => $data['opsi_d'],
            'opsi_e' => $data['opsi_e'],
            'jawaban' => $data['jawaban'],
        ];

        // simpan ke tabel
        $simpan = $this->db->insert('pmb_soal_tes', $value);
        // cek status simpan
        if ($simpan) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Soal berhasil disimpan',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal menyimpan soal',
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }

        return $response;
    }

    // update ke database
    public function updateSoal($data)
    {
        // set data untuk diupdate
        $value = [
            'pertanyaan'  => $data['pertanyaan'],
            'opsi_a' => $data['opsi_a'],
            'opsi_b' => $data['opsi_b'],
            'opsi_c' => $data['opsi_c'],
            'opsi_d' => $data['opsi_d'],
            'opsi_e' => $data['opsi_e'],
            'jawaban' => $data['jawaban'],
        ];
        // update tabel
        $update = $this->db->update('pmb_soal_tes', $value, ['id_soal' => $data['id_soal']]);
        // cek status update
        if ($update) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Soal berhasil diubah',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal merubah soal',
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }

        return $response;
    }

    public function hapusSoal($id)
    {
        // jika ada id nya
        if ($id) {
            // hapus data dengan cara soft delete ubah ke 1
            $hapus = $this->db->update('pmb_soal_tes', ['soft_del' => '1'], ['id_soal' => $id['id_soal']]);
            if ($hapus) {
                // buat respon berhasil
                $response = [
                    'status'  => true,
                    'message' => 'Soal berhasil dihapus',
                    'title'   => 'Berhasil',
                    'type'    => 'success'
                ];
            } else {
                // buat respon gagal
                $response = [
                    'status'  => false,
                    'message' => 'Soal gagal soal',
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
        $table = "( SELECT * FROM pmb_soal_tes WHERE soft_del = '0' ) as new_tb";
        $column_order = array(null, 'pertanyaan', 'jawaban');
        $column_search = array('pertanyaan');
        $orders = array('id_soal' => 'DESC');

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
