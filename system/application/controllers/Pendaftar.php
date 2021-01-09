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
        $this->load->model('M_persyaratan', 'persyaratan');
        $this->load->model('M_ref', 'ref');
        $this->load->library('urutan');
    }

    // halaman index, menampilkan datatabel
    public function index()
    {
        $data = [
            'title' => 'Data Pendaftar',
            'm_pendaftaran' => 'active',
            'dt_pendaftaran' => 'active',
        ];
        template('pendaftar/index', $data);
    }

    // menampilkan data peserta saat klik nama peserta pada tabel
    public function lihat()
    {
        // raw data
        $data   = file_get_contents('php://input');
        // jika ada raw data
        if ($data) {
            $endata  = json_decode($data);
            // id yg akan dikirim
            $id_akun = htmlspecialchars($endata->id_akun);
            // kirim ke model 
            $response = $this->daftar->read($id_akun);
            // tampilkan hasil yang terima dari respon
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    // halaman form tambah pendaftaran
    public function tambah()
    {
        // data yang perlu disiapkan
        $agama = $this->ref->get_agama();
        $pekerjaan = $this->ref->get_pekerjaan();
        $prodi_reg   = $this->ref->get_prodi('Reguler');
        $prodi_kar   = $this->ref->get_prodi('Karyawan');
        $ref_masuk = $this->ref->get_ref_masuk();

        $data = [
            'title'       => 'Tambah Pendaftar',
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

    // halaman detail lengkap pendaftar
    public function detail($id = null)
    {
        // cek id
        if ($id) {
            // get data pendaftar
            $detail = $this->daftar->read($id);
            // cek apakah data pendaftar ditemukan
            if ($detail) {
                // get jalur dan gelombang pendaftaran
                $gelombang = $this->daftar->getGelombang($detail->tgl_daftar);
            } else {
                $gelombang = null;
            }
            // persyaratan
            $persyaratan = $this->ref->jnsPersyaratan();
            $kelengkapan_persyaratan = $this->persyaratan->cek_kelengkapan_persyaratan($detail->id_pd);
            $data = [
                'title'       => 'Detail Pendaftar',
                'detail_pd'   => $detail,
                'gelombang'   => $gelombang,
                'persyaratan'     => $persyaratan,
                'cek_persyaratan' => $kelengkapan_persyaratan,
                'm_pendaftaran'   => 'active',
                'dt_pendaftaran'  => 'active',
            ];
            template('pendaftar/detail', $data);
        } else {
            $this->index();
        }
    }

    // proses menyimpan data dari form pendaftaran
    public function simpan_pendaftaran()
    {
        // cek pendaftaran dibuka atau belum
        if ($this->cek_pendaftaran->status(date('Y-m-d'))['status']) {
            $post = $this->input->post(null, true);
            if ($post) {
                $value = [
                    // set value untuk akun
                    'id_akun'       => htmlspecialchars($post['id_akun']),
                    'nama_akun'     => htmlspecialchars($post['nm_pd']),
                    'password_akun' => htmlspecialchars($post['no_hp']),
                    'hp_akun'       => htmlspecialchars($post['no_hp']),
                    'tgl_akun'      => date("Y-m-d H:i:s"),
                    'tahun_akademik' => tahun_akademik(),

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
        } else {
            $this->index();
        }
    }

    public function hapus_pendaftaran()
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
            // kirim ke model simpan
            $response = $this->daftar->delete($value);
            echo json_encode($response);
        } else {
            $this->index();
        }
    }

    // halaman form edit biodata
    public function edit_biodata($id = null)
    {
        // cek id
        if ($id) {
            // cek post dari form
            $post = $this->input->post(null, true);
            // jika ada post dari form, lakukan proses update biodata
            if ($post) {
                // set value untuk biodata
                $value = [
                    'id_akun'    => htmlspecialchars($post['id_akun']),
                    'nm_pd'      => htmlspecialchars($post['nm_pd']),
                    'nik'        => htmlspecialchars($post['nik']),
                    'tmpt_lahir' => htmlspecialchars($post['tmpt_lahir']),
                    'tgl_lahir'  => htmlspecialchars($post['tgl_lahir']),
                    'id_agama'   => htmlspecialchars($post['id_agama']),
                    'jk'         => htmlspecialchars($post['jk'])
                ];
                // kirim ke model
                $response = $this->daftar->edit_biodata($value);
                echo json_encode($response);
            }
            // jika tidak ada post dari form tampilkan form edit
            else {
                // get data biodata
                $biodata = $this->daftar->get_biodata($id);
                // get data pendaftar
                $detail = $this->daftar->read($id);
                // data yang perlu disiapkan
                $agama = $this->ref->get_agama();

                $data = [
                    'title'     => 'Edit Biodata',
                    'agama'     => $agama,
                    'biodata'   => $biodata,
                    'detail_pd' => $detail,
                    'm_pendaftaran' => 'active',
                    'dt_pendaftaran' => 'active',
                ];
                template('pendaftar/edit_biodata', $data);
            }
        } else {
            $this->index();
        }
    }

    // halaman form edit kontak
    public function edit_kontak($id = null)
    {
        // cek id
        if ($id) {
            // cek post dari form
            $post = $this->input->post(null, true);
            // jika ada post dari form, lakukan proses update kontak
            if ($post) {
                // set value untuk kontak
                $value = [
                    'id_akun'    => htmlspecialchars($post['id_akun']),
                    'no_hp'      => htmlspecialchars($post['no_hp']),
                    'no_hp_ortu' => htmlspecialchars($post['no_hp_ortu']),
                    'email'      => htmlspecialchars($post['email']),
                ];
                // kirim ke model
                $response = $this->daftar->edit_kontak($value);
                echo json_encode($response);
            }
            // jika tidak ada post dari form tampilkan form edit
            else {
                // get data kontak
                $kontak = $this->daftar->get_kontak($id);
                // get data pendaftar
                $detail = $this->daftar->read($id);

                $data = [
                    'title'  => 'Edit Kontak',
                    'kontak' => $kontak,
                    'detail_pd' => $detail,
                    'm_pendaftaran' => 'active',
                    'dt_pendaftaran' => 'active',
                ];
                template('pendaftar/edit_kontak', $data);
            }
        } else {
            $this->index();
        }
    }

    // halaman form edit alamat
    public function edit_alamat($id = null)
    {
        // cek id
        if ($id) {
            // cek post dari form
            $post = $this->input->post(null, true);
            // jika ada post dari form, lakukan proses update alamat
            if ($post) {
                // set value untuk alamat
                $value = [
                    'id_akun'  => htmlspecialchars($post['id_akun']),
                    'jln'      => htmlspecialchars($post['jln']),
                    'rt'       => htmlspecialchars($post['rt']),
                    'rw'       => htmlspecialchars($post['rw']),
                    'nm_dsn'   => htmlspecialchars($post['nm_dsn']),
                    'ds_kel'   => htmlspecialchars($post['ds_kel']),
                    'kode_pos' => htmlspecialchars($post['kode_pos']),
                    'id_prov'  => htmlspecialchars($post['id_prov']),
                    'id_kab'   => htmlspecialchars($post['id_kab']),
                    'id_wil'   => htmlspecialchars($post['id_wil']),
                ];
                // kirim ke model
                $response = $this->daftar->edit_alamat($value);
                echo json_encode($response);
            }
            // jika tidak ada post dari form tampilkan form edit
            else {
                // get data alamat
                $alamat = $this->daftar->get_alamat($id);
                // get data pendaftar
                $detail = $this->daftar->read($id);

                $data = [
                    'title'  => 'Edit alamat',
                    'alamat' => $alamat,
                    'detail_pd' => $detail,
                    'm_pendaftaran' => 'active',
                    'dt_pendaftaran' => 'active',
                ];
                template('pendaftar/edit_alamat', $data);
            }
        } else {
            $this->index();
        }
    }

    // halaman form edit ortu
    public function edit_ortu($id = null)
    {
        // cek id
        if ($id) {
            // cek post dari form
            $post = $this->input->post(null, true);
            // jika ada post dari form, lakukan proses update ortu
            if ($post) {
                // set value untuk ortu
                $value = [
                    'id_akun'  => htmlspecialchars($post['id_akun']),
                    'nm_ayah'  => htmlspecialchars($post['nm_ayah']),
                    'id_pekerjaan_ayah' => htmlspecialchars($post['id_pekerjaan_ayah']),
                    'nm_ibu'     => htmlspecialchars($post['nm_ibu']),
                    'id_pekerjaan_ibu' => htmlspecialchars($post['id_pekerjaan_ibu']),
                ];
                // kirim ke model
                $response = $this->daftar->edit_ortu($value);
                echo json_encode($response);
            }
            // jika tidak ada post dari form tampilkan form edit
            else {
                // get data ortu
                $ortu = $this->daftar->get_ortu($id);
                // data yang dibutuhkan
                $pekerjaan = $this->ref->get_pekerjaan();
                // get data pendaftar
                $detail = $this->daftar->read($id);

                $data = [
                    'title'  => 'Edit Orang Tua',
                    'ortu' => $ortu,
                    'pekerjaan' => $pekerjaan,
                    'detail_pd' => $detail,
                    'm_pendaftaran' => 'active',
                    'dt_pendaftaran' => 'active',
                ];
                template('pendaftar/edit_ortu', $data);
            }
        } else {
            $this->index();
        }
    }

    // halaman form edit sekolah asal
    public function edit_sekolah_asal($id = null)
    {
        // cek id
        if ($id) {
            // cek post dari form
            $post = $this->input->post(null, true);
            // jika ada post dari form, lakukan proses update sekolah asal
            if ($post) {
                // set value untuk sekolah asal
                $value = [
                    'id_akun' => htmlspecialchars($post['id_akun']),
                    'jenjang' => htmlspecialchars($post['jenjang']),
                    'sekolah' => htmlspecialchars($post['sekolah']),
                    'alamat_sekolah' => htmlspecialchars($post['alamat_sekolah']),
                    'id_ref_masuk'   => htmlspecialchars($post['id_ref_masuk'])
                ];
                // kirim ke model
                $response = $this->daftar->edit_sekolah_asal($value);
                echo json_encode($response);
            }
            // jika tidak ada post dari form tampilkan form edit
            else {
                // get data sekolah asal
                $sekolah_asal = $this->daftar->get_sekolah_asal($id);
                // data yang dibutuhkan
                $ref_masuk = $this->ref->get_ref_masuk();
                // get data pendaftar
                $detail = $this->daftar->read($id);

                $data = [
                    'title'  => 'Edit Sekolah Asal',
                    'sekolah_asal' => $sekolah_asal,
                    'ref_masuk' => $ref_masuk,
                    'detail_pd' => $detail,
                    'm_pendaftaran' => 'active',
                    'dt_pendaftaran' => 'active',
                ];
                template('pendaftar/edit_sekolah_asal', $data);
            }
        } else {
            $this->index();
        }
    }

    // halaman form edit prodi
    public function edit_prodi($id = null)
    {
        // cek id
        if ($id) {
            // cek post dari form
            $post = $this->input->post(null, true);
            // jika ada post dari form, lakukan proses update prodi
            if ($post) {
                // set value untuk prodi
                $value = [
                    'id_akun'  => htmlspecialchars($post['id_akun']),
                    'id_prodi' => htmlspecialchars($post['id_prodi']),
                ];
                // kirim ke model
                $response = $this->daftar->edit_prodi($value);
                echo json_encode($response);
            }
            // jika tidak ada post dari form tampilkan form edit
            else {
                // get data prodi
                $prodi = $this->daftar->get_prodi($id);
                // get data pendaftar
                $detail = $this->daftar->read($id);
                // data yang dibutuhkan
                $prodi_reg   = $this->ref->get_prodi('Reguler');
                $prodi_kar   = $this->ref->get_prodi('Karyawan');

                $data = [
                    'title'  => 'Edit Program Studi',
                    'prodi' => $prodi,
                    'prodi_reg' => $prodi_reg,
                    'prodi_kar' => $prodi_kar,
                    'detail_pd' => $detail,
                    'm_pendaftaran' => 'active',
                    'dt_pendaftaran' => 'active',
                ];
                template('pendaftar/edit_prodi', $data);
            }
        } else {
            $this->index();
        }
    }

    // tombol switch untuk merubah status pendaftaran (diterima)
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

    // method untuk menampilkan semua data pendaftar ke dalam datatable
    public function get_data()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            // ambil data dari model
            $list = $this->daftar->get_datatables();
            $data = array();
            $no   = $post['start'];
            foreach ($list as $field) {
                // pemeriksaan kelengkapan persyaratan
                $kelengkapan_persyaratan = $this->persyaratan->cek_kelengkapan_persyaratan($field->id_akun);
                if (!$kelengkapan_persyaratan || $kelengkapan_persyaratan == 0) {
                    $btn_terima = false;
                    $persyaratan = '<span class="badge badge-danger">Belum upload</span>';
                } elseif ($kelengkapan_persyaratan == 3) {
                    $btn_terima = true;
                    $persyaratan = '<span class="badge badge-success">Lengkap</span>';
                } else {
                    $btn_terima = false;
                    $persyaratan = '<span class="badge badge-warning">' . $kelengkapan_persyaratan . ' dari 3</span>';
                }
                $switch_checked = ($field->status_diterima == '1') ? 'checked' : '';
                $status_diterima = ($field->status_diterima == '1') ? '<span class="badge badge-success">Diterima</span>' : '<span class="badge badge-secondary">Pending</span>';
                $no++;
                $row = array();
                /**1*/ $row[] = '<a role="button" data-toggle="modal" data-target="#modal_' . $field->id_akun . '" class="text-danger" title="HAPUS"><i class="fas fa-times"></i></a>' . modal_danger($field->id_akun, $field->nm_pd);
                /**2*/ $row[] = '<a href="' . site_url('pendaftar/detail/' . $field->id_akun) . '">' . $field->nm_pd . '</a><br>' . $field->jalur . ' : ' . $field->no_daftar;
                /**3*/ $row[] = $field->nama_prodi;
                /**4*/ $row[] = $field->hp_akun;

                // cek level user
                $level_user = $this->session->level;
                if ($level_user == 'mitra') {
                    /**5*/ $row[] = $field->nama_gelombang;
                    /**6*/ $row[] = $this->date->tanggal($field->tgl_akun, 's');
                } else {
                    // cek level dari id_user
                    if ($field->level == 'admin' || $field->level == 'super') {
                        $nm_user = 'Admin BAAK';
                    } elseif ($field->level == 'mitra') {
                        $nm_user = $field->nama_user;
                    } else {
                        $nm_user = 'Mandiri';
                    }
                    /**5*/ $row[] = $field->sekolah;
                    /**6*/ $row[] = $nm_user;
                }

                /**7*/ $row[] = $persyaratan;

                // jika sudah ada nomor daftar, tampilkan kolom status
                if (empty($field->no_daftar)) {
                    /**8*/ $row[] = '';
                } else {
                    // cek level pengguna
                    if ($this->session->level == 'mitra') {
                        // jika level mitra, hanya melihat status diterima
                        /**8*/ $row[] = $status_diterima;
                    } else {
                        // jika level admin, maka tampilkan tombol switch
                        // jika persyaratan lengkap, tampilkan switch
                        if ($btn_terima) {
                            /**8*/ $row[] = $status_diterima;
                            //     $row[] = '<div class="custom-control custom-switch" title="STATUS">
                            //     <input type="checkbox" onchange="status_diterima(`' . $field->id_akun . '`)" class="custom-control-input" id="customSwitch' . $field->id_akun . '" ' . $switch_checked . '>
                            //     <label class="custom-control-label" for="customSwitch' . $field->id_akun . '"></label>
                            // </div>';
                        } else {
                            $row[] = '<small>Lengkapi persyaratan</small>';
                        }
                    }
                }

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
