<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
/**
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_pendaftar extends CI_Model
{

    public function create($data)
    {
        // value insert akun
        $val_akun = [
            'id_akun'        => $data['id_akun'],
            'nama_akun'      => strtoupper($data['nama_akun']),
            'password_akun'  => set_password($data['password_akun']),
            'hp_akun'        => $data['hp_akun'],
            'tgl_akun'       => $data['tgl_akun'],
            'tahun_akademik' => $data['thn_akademik'],
            'soft_del'       => 0
        ];

        // value insert verifikasi akun (bypass admin)
        $val_verifikasi = [
            'id_verifikasi' => uuid_v4(),
            'id_akun'       => $data['id_akun'],
            'kode'          => 'BYPASS',
            'via'           => 'admin',
            'expire'        => date("Y-m-d H:i:s"),
            'status'        => '1'
        ];

        // value insert biodata
        $val_biodata = [
            'id_biodata' => uuid_v4(),
            'id_akun'    => $data['id_akun'],
            'nm_pd'      => strtoupper($data['nm_pd']),
            'nik'        => $data['nik'],
            'tmpt_lahir' => $data['tmpt_lahir'],
            'tgl_lahir'  => $data['tgl_lahir'],
            'id_agama'   => $data['id_agama'],
            'jk'         => $data['jk'],
            'created_at' => date("Y-m-d H:i:s")
        ];

        // value insert kontak
        $val_kontak = [
            'id_kontak'  => uuid_v4(),
            'id_akun'    => $data['id_akun'],
            'no_hp'      => $data['no_hp'],
            'no_hp_ortu' => $data['no_hp_ortu'],
            'email'      => $data['email'],
            'created_at' => date("Y-m-d H:i:s")
        ];

        // value insert orang tua
        $val_ortu = [
            'id_orang_tua'      => uuid_v4(),
            'id_akun'           => $data['id_akun'],
            'nm_ayah'           => $data['nm_ayah'],
            'id_pekerjaan_ayah' => $data['id_pekerjaan_ayah'],
            'nm_ibu'            => $data['nm_ibu'],
            'id_pekerjaan_ibu'  => $data['id_pekerjaan_ibu'],
            'created_at'        => date("Y-m-d H:i:s")
        ];

        // value insert alamat
        $val_alamat = [
            'id_alamat' => uuid_v4(),
            'id_akun'   => $data['id_akun'],
            'jln'       => $data['jln'],
            'rt'        => $data['rt'],
            'rw'        => $data['rw'],
            'nm_dsn'    => $data['nm_dsn'],
            'ds_kel'    => $data['ds_kel'],
            'kode_pos'  => $data['kode_pos'],
            'id_prov'   => $data['id_prov'],
            'id_kab'    => $data['id_kab'],
            'id_wil'    => $data['id_wil'],
            'kewarganegaraan' => $data['kewarganegaraan'],
            'created_at' => date("Y-m-d H:i:s")
        ];

        // value insert prodi pilihan
        $val_prodi = [
            'id_prodi_pilihan' => uuid_v4(),
            'id_akun'          => $data['id_akun'],
            'id_prodi'         => $data['id_prodi'],
            'urutan'           => $this->urutan->urutan($data['id_prodi']),
            'no_daftar'        => $this->urutan->nomordaftar($data['id_prodi']),
            'created_at'       => date("Y-m-d H:i:s")
        ];

        // value insert sekolah asal
        $val_sekolah_asal = [
            'id_sekolah_asal' => uuid_v4(),
            'id_akun'         => $data['id_akun'],
            'jenjang'         => $data['jenjang'],
            'sekolah'         => $data['sekolah'],
            'alamat_sekolah'  => $data['alamat_sekolah'],
            'id_ref_masuk'    => $data['id_ref_masuk'],
            'created_at'      => date("Y-m-d H:i:s")
        ];

        // PROSES PENYIMPANAN
        // cek ketersediaan hp_akun yang akan didaftarkan daripada tabel akun pmb
        $cek_hp_akun = $this->db->get_where('pmb_akunmaba', ['hp_akun' => $data['hp_akun'], 'soft_del' => '0'])->num_rows();
        // jika hp_akun yang tersebut belum ada
        // lakukan proses simpan
        if ($cek_hp_akun == 0) {
            // simpan data akun
            $simpan_akun = $this->db->insert('pmb_akunmaba', $val_akun);
            // jika proses membuat akun berhasil
            if ($simpan_akun) {

                // simpan kode verifikasi ke dalam tabel verifikasi akun
                $simpan_kode = $this->db->insert('pmb_verifikasi_akun', $val_verifikasi);
                // jika proses simpan kode verifikasi berhasil
                if ($simpan_kode) {

                    // simpan data biodata
                    $simpan_biodata = $this->db->insert('pmb_biodata', $val_biodata);
                    // jika proses simpan biodata berhasil
                    if ($simpan_biodata) {

                        // simpan data kontak
                        $simpan_kontak = $this->db->insert('pmb_kontak', $val_kontak);
                        // jika proses simpan kontak berhasil
                        if ($simpan_kontak) {

                            // simpan data orang tua
                            $simpan_ortu = $this->db->insert('pmb_orang_tua', $val_ortu);
                            // jika proses simpan orang tua berhasil
                            if ($simpan_ortu) {

                                // simpan data alamat
                                $simpan_alamat = $this->db->insert('pmb_alamat', $val_alamat);
                                // jika proses simpan alamat berhasil
                                if ($simpan_alamat) {

                                    // simpan data prodi pilihan
                                    $simpan_prodi = $this->db->insert('pmb_prodi_pilihan', $val_prodi);
                                    // jika proses simpan prodi berhasil
                                    if ($simpan_prodi) {

                                        // simpan data sekolah asal
                                        $simpan_sekolah_asal = $this->db->insert('pmb_sekolah_asal', $val_sekolah_asal);
                                        // jika proses simpan sekolah asal berhasil
                                        if ($simpan_sekolah_asal) {
                                            // buat respon berhasil
                                            $response = [
                                                'status'  => true,
                                                'message' => 'Pendaftaran berhasil disimpan',
                                                'title'   => 'Berhasil!',
                                                'type'    => 'success'
                                            ];
                                        }
                                        // jika gagal menyimpan sekolah asal
                                        // kembali lakukan daftar akun
                                        else {
                                            // hapus data akun
                                            $this->db->delete('pmb_akunmaba', ['id_akun' => $data['id_akun']]);
                                            $response = [
                                                'status'  => false,
                                                'message' => 'Gagal menyimpan sekolah asal! Silahkan ulangi!',
                                                'title'   => 'Gagal!',
                                                'type'    => 'danger'
                                            ];
                                        }
                                    }
                                    // jika gagal menyimpan prodi
                                    // kembali lakukan daftar akun
                                    else {
                                        // hapus data akun
                                        $this->db->delete('pmb_akunmaba', ['id_akun' => $data['id_akun']]);
                                        $response = [
                                            'status'  => false,
                                            'message' => 'Gagal menyimpan prodi pilihan! Silahkan ulangi!',
                                            'title'   => 'Gagal!',
                                            'type'    => 'danger'
                                        ];
                                    }
                                }
                                // jika gagal menyimpan alamat
                                // kembali lakukan daftar akun
                                else {
                                    // hapus data akun
                                    $this->db->delete('pmb_akunmaba', ['id_akun' => $data['id_akun']]);
                                    $response = [
                                        'status'  => false,
                                        'message' => 'Gagal menyimpan alamat! Silahkan ulangi!',
                                        'title'   => 'Gagal!',
                                        'type'    => 'danger'
                                    ];
                                }
                            }
                            // jika gagal menyimpan orang tua
                            // kembali lakukan daftar akun
                            else {
                                // hapus data akun
                                $this->db->delete('pmb_akunmaba', ['id_akun' => $data['id_akun']]);
                                $response = [
                                    'status'  => false,
                                    'message' => 'Gagal menyimpan orang tua! Silahkan ulangi!',
                                    'title'   => 'Gagal!',
                                    'type'    => 'danger'
                                ];
                            }
                        }
                        // jika gagal menyimpan kontak
                        // kembali lakukan daftar akun
                        else {
                            // hapus data akun
                            $this->db->delete('pmb_akunmaba', ['id_akun' => $data['id_akun']]);
                            $response = [
                                'status'  => false,
                                'message' => 'Gagal menyimpan kontak! Silahkan ulangi!',
                                'title'   => 'Gagal!',
                                'type'    => 'danger'
                            ];
                        }
                    }
                    // jika gagal menyimpan biodata
                    // kembali lakukan daftar akun
                    else {
                        // hapus data akun
                        $this->db->delete('pmb_akunmaba', ['id_akun' => $data['id_akun']]);
                        $response = [
                            'status'  => false,
                            'message' => 'Gagal menyimpan biodata! Silahkan ulangi!',
                            'title'   => 'Gagal!',
                            'type'    => 'danger'
                        ];
                    }
                }
                // jika gagal menyimpan kode verifikasi
                // kembali lakukan daftar akun
                else {
                    // hapus data akun
                    $this->db->delete('pmb_akunmaba', ['id_akun' => $data['id_akun']]);
                    $response = [
                        'status'  => false,
                        'message' => 'Aktivasi akun gagal! Silahkan ulangi!',
                        'title'   => 'Gagal!',
                        'type'    => 'danger'
                    ];
                }
            }
            // jika proses pembuatan akun gagal
            // kembali lakukan daftar akun
            else {
                $response = [
                    'status'  => false,
                    'message' => 'Buat akun gagal! Silahkan ulangi!',
                    'title'   => 'Gagal!',
                    'type'    => 'danger'
                ];
            }
        }
        // jika nomor hp yang didaftarkan sudah ada
        // kembali lakukan daftar akun
        else {
            $response = [
                'status'  => false,
                'message' => 'Nomor sudah terdaftar! Silahkan ulangi!',
                'title'   => 'Gagal!',
                'type'    => 'danger'
            ];
        }

        return $response;
    }

    public function read($id = null)
    {
        return $this->db->get_where('v_data_pd', ['id_pd' => $id])->row();
    }

    public function update($data)
    {
    }

    public function delete($id)
    {
    }

    public function status_diterima($id)
    {
        if ($id) {
            // get data dulu
            $get_status = $this->db->get_where('pmb_akunmaba', ['id_akun' => $id])->row();
            // cek data
            if ($get_status) {
                // cek status
                if ($get_status->status_diterima == '0') {
                    // jika 0, berarti belum diterima
                    // lakukan update ke 1
                    $diterima = $this->db->update('pmb_akunmaba', ['status_diterima' => '1'], ['id_akun' => $id]);
                    if ($diterima) {
                        $response = [
                            'status'  => true,
                            'message' => 'Peserta berhasil diterima',
                            'title'   => 'Sukses!',
                            'type'    => 'success'
                        ];
                    } else {
                        $response = [
                            'status'  => false,
                            'message' => 'Gagal merubah status peserta',
                            'title'   => 'Sukses!',
                            'type'    => 'success'
                        ];
                    }
                } else {
                    // jika 1, berarti sudah diterima
                    // lakukan update ke 0
                    $dibatalkan = $this->db->update('pmb_akunmaba', ['status_diterima' => '0'], ['id_akun' => $id]);
                    if ($dibatalkan) {
                        $response = [
                            'status'  => true,
                            'message' => 'Status diterima berhasil dibatalkan',
                            'title'   => 'Sukses!',
                            'type'    => 'success'
                        ];
                    } else {
                        $response = [
                            'status'  => false,
                            'message' => 'Gagal membatalkan status diterima peserta',
                            'title'   => 'Sukses!',
                            'type'    => 'success'
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
        $table = "( SELECT * FROM v_data_pendaftar ) as new_tb";
        $column_order = array('status_diterima', 'nm_pd', 'no_daftar', null, null, 'sekolah', 'tgl_akun', null);
        $column_search = array('nm_pd', 'no_daftar', 'jenjang', 'nm_prodi', 'sekolah');
        $orders = array('tgl_akun' => 'DESC');

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
