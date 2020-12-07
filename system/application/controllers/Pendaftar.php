<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Pendaftar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        $this->load->model('M_pendaftar', 'daftar');
        $this->load->model('M_ref', 'ref');
        $this->load->library('urutan');
    }

    public function index()
    {

        $data = [
            'title' => 'Data Pendaftar',
            'm_pendaftaran' => 'active',
            'dt_pendaftaran' => 'active',
        ];
        template('pendaftar/index', $data);
    }

    public function tambah()
    {
        // data yang perlu disiapkan
        $agama = $this->ref->get_agama();
        $pekerjaan = $this->ref->get_pekerjaan();
        $prodi_reg   = $this->ref->get_prodi('Reguler');
        $prodi_kar   = $this->ref->get_prodi('Karyawan');
        $ref_masuk = $this->ref->get_ref_masuk();

        $data = [
            'title'       => 'Biodata Pendaftar',
            'agama'       => $agama,
            'pekerjaan'   => $pekerjaan,
            'prodi_reg'   => $prodi_reg,
            'prodi_kar'   => $prodi_kar,
            'ref_masuk'   => $ref_masuk,
            'm_pendaftaran' => 'active',
            'dt_tambah' => 'active',
        ];
        template('pendaftar/tambah', $data);
    }

    public function detail($id = null)
    {
        // cek id
        if ($id) {
            // get data pendaftar
            $detail = $this->daftar->read($id);
            $data = [
                'title'       => 'Biodata Pendaftar',
                'detail_pd'   => $detail,
                'm_pendaftaran' => 'active',
                'dt_tambah' => 'active',
            ];
            template('pendaftar/detail', $data);
        } else {
            $this->tambah();
        }
    }

    public function simpan_pendaftaran()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            $value = [
                // set value untuk akun
                'id_akun'       => htmlspecialchars($post['id_akun']),
                'nama_akun'     => htmlspecialchars($post['nm_pd']),
                'password_akun' => htmlspecialchars($post['no_hp']),
                'hp_akun'       => htmlspecialchars($post['no_hp']),
                'tgl_akun'      => date("Y-m-d H:i:s"),
                'thn_akademik'  => $this->ref->tahun_akademik_aktif()->tahun_akademik,

                // set value untuk biodata
                'nm_pd'      => htmlspecialchars($post['nm_pd']),
                'nik'        => htmlspecialchars($post['nik']),
                'tmpt_lahir' => htmlspecialchars($post['tmpt_lahir']),
                'tgl_lahir'  => htmlspecialchars($post['tgl_lahir']),
                'id_agama'   => htmlspecialchars($post['id_agama']),
                'jk'         => htmlspecialchars($post['jk']),

                // set value untuk kontak
                'no_hp'      => htmlspecialchars($post['no_hp']),
                'no_hp_ortu' => htmlspecialchars($post['no_hp_ortu']),
                'email'      => htmlspecialchars($post['email']),

                // set val untuk orang tua
                'nm_ayah'           => htmlspecialchars($post['nm_ayah']),
                'id_pekerjaan_ayah' => htmlspecialchars($post['id_pekerjaan_ayah']),
                'nm_ibu'            => htmlspecialchars($post['nm_ibu']),
                'id_pekerjaan_ibu'  => htmlspecialchars($post['id_pekerjaan_ibu']),

                // set val untuk alamat
                'jln' => htmlspecialchars($post['jln']),
                'rt'  => htmlspecialchars($post['rt']),
                'rw'  => htmlspecialchars($post['rw']),
                'nm_dsn'   => htmlspecialchars($post['nm_dsn']),
                'ds_kel'   => htmlspecialchars($post['ds_kel']),
                'kode_pos' => htmlspecialchars($post['kode_pos']),
                'id_prov'  => htmlspecialchars($post['id_prov']),
                'id_kab'   => htmlspecialchars($post['id_kab']),
                'id_wil'   => htmlspecialchars($post['id_wil']),
                'kewarganegaraan' => htmlspecialchars($post['kewarganegaraan']),

                // set val untuk prodi pilihan
                'id_prodi' => htmlspecialchars($post['id_prodi']),

                // set val untuk sekolah asal
                'jenjang' => htmlspecialchars($post['jenjang']),
                'sekolah' => htmlspecialchars($post['sekolah']),
                'alamat_sekolah' => htmlspecialchars($post['alamat_sekolah']),
                'id_ref_masuk'   => htmlspecialchars($post['id_ref_masuk'])
            ];

            $response = $this->daftar->create($value);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    public function status_diterima()
    {
        // raw data
        $data   = file_get_contents('php://input');
        // jika ada raw data
        if ($data) {
            $endata  = json_decode($data);
            // id yg akan dikirim
            $id_akun = htmlspecialchars($endata->id_akun);
            // kirim ke model 
            $response = $this->daftar->status_diterima($id_akun);
            // tampilkan hasil yang terima dari respon
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    public function get_data()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            $list = $this->daftar->get_datatables();
            $data = array();
            $no   = $post['start'];
            foreach ($list as $field) {
                $status_diterima = ($field->status_diterima == '1') ? 'checked' : '';
                $no++;
                $row = array();
                $row[] = '<div class="custom-control custom-switch">
                            <input type="checkbox" onchange="status_diterima(`' . $field->id_akun . '`)" class="custom-control-input" id="customSwitch' . $field->id_akun . '" ' . $status_diterima . '>
                            <label class="custom-control-label" for="customSwitch' . $field->id_akun . '"></label>
                        </div>';
                $row[] = $field->nm_pd;
                $row[] = $field->no_daftar;
                $row[] = $field->jk;
                $row[] = $field->jenjang . ' ' . $field->nm_prodi;
                $row[] = $field->sekolah;
                $row[] = $this->date->tanggal($field->tgl_akun, 's');
                $row[] = '<div class="dropdown">
                        <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                            </svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="' . site_url('pendaftar/detail/') . $field->id_akun . '">Detail</a>
                            <a class="dropdown-item" href="#">Edit</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-warning" href="#">Buang</a>
                            <a class="dropdown-item text-danger" href="#">Hapus</a>
                        </div>
                    </div>';

                $data[] = $row;
            }

            $output = array(
                "draw" => $post['draw'],
                "recordsTotal" => $this->daftar->count_all(),
                "recordsFiltered" => $this->daftar->count_filtered(),
                "data" => $data,
            );
            // tampilkan data
            echo json_encode($output);
        } else {
            $this->index();
        }
    }

    /**
     * Proses pengecekan ketersediaan data wilayah sesuai keyword yang dikirim kesini
     * Proses pengecekan dilakukan saat mengetik pada kolom input kecamatan
     * Data yang ditampilkan Kecamatan-Kabupaten/Kota-Provinsi dalam bentuk list
     * Klik pada salah satu list kecamatan untuk memilih
     */
    public function cek_wilayah()
    {
        // raw data
        $data     = file_get_contents('php://input');
        // encode data yang diterima
        $value  = json_decode($data);
        //periksa jenis wilayah yang dicari
        if ($value->wilayah == 'provinsi') {
            $func = "prov";
            // cari dari get_provinsi
            $response = $this->ref->get_provinsi($value->keyword, $value->induk);
        } elseif ($value->wilayah == 'kabupaten/kota') {
            $func = "kab_kota";
            // cari dari get_kab_kota
            $response = $this->ref->get_kab_kota($value->keyword, $value->induk);
        } else {
            $func = "kec";
            // cari dari get_kecamatan
            $response = $this->ref->get_kecamatan($value->keyword, $value->induk);
        }

        // jika ada
        if ($response != null) {
            // tampilkan data dalam list
            $ret = "<ul id='country-list' class='list-group shadow-lg'>";
            foreach ($response as $r) {
                $ret .= "<li id='list_wilayah' class='list-group-item list-group-item-action p-2' style='cursor:pointer' onClick='select_" . $func . "(`$r[id_wil]`, `$r[nm_wil]`);' >$r[nm_wil]</li>";
            }
        }
        // jika data tidak ada
        else {
            // informasi data tidak ada
            $ret = '<ul id="list_wilayah" class="list-group"><li class="list-group-item p-2 disabled">Data ' . $value->wilayah . ' tidak ditemukan</li>';
        }
        echo $ret;
    }
}
