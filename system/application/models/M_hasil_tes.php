<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_hasil_tes extends CI_Model
{
    /**
     * ============================================================
     * DATATABLE QUERY
     * ============================================================
     */
    private function _get_datatables_query()
    {
        $table = "( SELECT a.id_tes_masuk, b.id_akun, b.nama_akun, a.waktu_mulai, a.waktu_mulai as tgl, a.nilai FROM pmb_hasil_tes a LEFT JOIN pmb_akunmaba b ON a.id_akun = b.id_akun WHERE a.status = 'Y') as new_tb";
        $column_order = array(null, 'waktu_mulai', 'nama_akun', 'nilai');
        $column_search = array('nama_akun');
        $orders = array('waktu_mulai' => 'DESC');

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
