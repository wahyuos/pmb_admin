<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Akun_pendaftar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        if ($this->session->level == 'mitra') redirect(base_url('home'));

        $this->load->model('M_akun_pendaftar', 'akun_pendaftar');
    }

    public function index()
    {
        $total_akun = $this->akun_pendaftar->jmlAkun(tahun_akademik());
        $total_yang_nonaktif = $this->akun_pendaftar->jmlAkunNonaktif(tahun_akademik());
        $total_yang_daftar = $this->akun_pendaftar->jmlDaftar(tahun_akademik());
        $data = [
            'title' => 'Manajemen Akun Pendaftar',
            'm_akun_pendaftar' => 'active',
            'total_akun' => $total_akun,
            'total_yang_nonaktif' => $total_yang_nonaktif,
            'total_yang_daftar' => $total_yang_daftar
        ];
        template('akun_pendaftar/index', $data);
    }

    public function reset()
    {
        // raw data
        $data   = file_get_contents('php://input');
        // jika ada raw data
        // lakukan proses pengecekan
        if ($data) {
            // encode data
            $post  = json_decode($data);
            $value = [
                'id_akun' => htmlspecialchars($post->id_akun)
            ];
            // kirim ke model reset
            $response = $this->akun_pendaftar->resetAkun($value);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    public function hapus()
    {
        // raw data
        $data   = file_get_contents('php://input');
        // jika ada raw data
        // lakukan proses pengecekan
        if ($data) {
            // encode data
            $post  = json_decode($data);
            $value = [
                'id_akun' => htmlspecialchars($post->id_akun)
            ];
            // kirim ke model hapus
            $response = $this->akun_pendaftar->hapusAkun($value);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    public function get_data()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            $list = $this->akun_pendaftar->get_datatables();
            $data = array();
            foreach ($list as $field) {
                $status = ($field->status == '1') ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Belum Aktif</span>';
                $no_daftar = ($field->no_daftar) ? '<span class="badge badge-success">Sudah Daftar</span>' : '<span class="badge badge-danger">Belum Daftar</span>';
                $row = array();
                $row[] = '<div class="btn-group btn-group-sm m-0" role="group" aria-label="Small button group">
                        <a role="button" data-toggle="modal" data-target="#modal_' . $field->id_akun . '" class="text-danger mr-3" title="HAPUS"><i class="fas fa-times"></i></a>
                        <a role="button" data-toggle="modal" data-target="#reset_' . $field->id_akun . '" class="text-primary" title="RESET AKUN"><i class="fas fa-undo-alt"></i></a>
                        </div>' . modal_danger($field->id_akun, $field->nama_akun) . modal_reset($field->id_akun, $field->nama_akun);
                $row[] = $field->nama_akun;
                $row[] = $field->hp_akun;
                $row[] = $this->date->tanggal($field->tgl, 'p');
                $row[] = $status;
                $row[] = $no_daftar;

                $data[] = $row;
            }

            $output = array(
                "draw" => $post['draw'],
                "recordsTotal" => $this->akun_pendaftar->count_all(),
                "recordsFiltered" => $this->akun_pendaftar->count_filtered(),
                "data" => $data,
            );

            echo json_encode($output);
        } else {
            $this->index();
        }
    }
}
