<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_bukti_bayar extends CI_Model
{
    public function read($id)
    {
        return $this->db->select('a.*, b.nama_akun')
            ->from('pmb_buktibayar a')
            ->join('pmb_akunmaba b', 'a.id_akun = b.id_akun', 'LEFT')
            ->where(['a.id_akun' => $id, 'a.soft_del' => '0'])
            ->get()->row();
    }

    // proses verifikasi bukti bayar
    public function status_diterima($id)
    {
        if ($id) {
            // get data dulu
            $get_status = $this->db->get_where('pmb_buktibayar', ['id_akun' => $id])->row();
            // cek data
            if ($get_status) {
                // cek status
                if ($get_status->verifikasi == 'N') {
                    // jika N, berarti belum diverifikasi
                    // lakukan update ke Y
                    $value = [
                        'verifikasi' => 'Y',
                        'tgl_verifikasi' => date('Y-m-d H:i:s')
                    ];
                    $diterima = $this->db->update('pmb_buktibayar', $value, ['id_akun' => $id]);
                    if ($diterima) {
                        $response = [
                            'status'  => true,
                            'message' => 'Bukti bayar diterima',
                            'title'   => 'Sukses!',
                            'type'    => 'success'
                        ];
                    } else {
                        $response = [
                            'status'  => false,
                            'message' => 'Gagal verifikasi bukti bayar',
                            'title'   => 'Gagal!',
                            'type'    => 'danger'
                        ];
                    }
                } else {
                    // jika Y, berarti sudah diterima
                    // lakukan update ke N
                    $dibatalkan = $this->db->update('pmb_buktibayar', ['verifikasi' => 'N'], ['id_akun' => $id]);
                    if ($dibatalkan) {
                        $response = [
                            'status'  => true,
                            'message' => 'Bukti bayar dibatalkan',
                            'title'   => 'Sukses!',
                            'type'    => 'success'
                        ];
                    } else {
                        $response = [
                            'status'  => false,
                            'message' => 'Gagal membatalkan bukti bayar',
                            'title'   => 'Gagal!',
                            'type'    => 'danger'
                        ];
                    }
                }
            } else {
                $response = [
                    'status'  => false,
                    'message' => 'Tidak ada data akun yang diterima',
                    'title'   => 'Gagal!',
                    'type'    => 'danger'
                ];
            }
        } else {
            $response = [
                'status'  => false,
                'message' => 'Tidak ada ID yang diterima',
                'title'   => 'Gagal!',
                'type'    => 'danger'
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
        $table = "( SELECT a.id_buktibayar, b.id_akun, b.nama_akun, a.tgl_upload, a.tgl_upload as tgl, a.verifikasi, a.skip FROM pmb_buktibayar a LEFT JOIN pmb_akunmaba b ON a.id_akun = b.id_akun WHERE a.soft_del = '0' AND a.skip = '0' ) as new_tb";
        $column_order = array(null, 'tgl_upload', 'nama_akun', 'verifikasi');
        $column_search = array('nama_akun');
        $orders = array('tgl_upload' => 'DESC');

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
