<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model rekapitulasi mitra
 * 
 * Menghitung jumlah atau banyaknya siswa yang didaftarkan oleh tiap mitra
 * 
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_rekap_mitra extends CI_Model
{
    public function getDataPendaftar($id_user)
    {
        return $this->db->order_by('nm_pd', 'ASC')->get_where('v_data_pendaftar', ['id_user' => $id_user])->result();
    }

    public function totalByMitra($ta)
    {
        return $this->db->select('count(id_akun) as total')->get_where('v_data_pendaftar', ['level' => 'mitra', 'tahun_akademik' => $ta])->row();
    }
    /**
     * ============================================================
     * DATATABLE QUERY
     * ============================================================
     */
    private function _get_datatables_query()
    {
        $table = "( SELECT id_user, nama_user, instansi, COUNT(id_akun) as jml FROM v_data_pendaftar WHERE level = 'mitra' GROUP BY id_user ) as new_tb";
        $column_order = array(null, 'nama_user', 'instansi', 'jml', null);
        $column_search = array('nama_user', 'instansi');
        $orders = array('jml' => 'DESC', 'nama_user' => 'ASC');

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
