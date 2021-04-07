<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_pendaftar extends CI_Model
{
    // mengetahui jalur dan gelombang daftar sesuai tanggal daftar
    public function getGelombang($tgl_daftar)
    {
        return $this->db->get_where('ref_jadwal', ['periode_awal <= ' => $tgl_daftar, 'periode_akhir >= ' => $tgl_daftar])->row();
    }

    // mengetahui jadwal tes 
    public function getJadwalTes($id_jadwal)
    {
        return $this->db->get_where('ref_jadwal_tes', ['id_jadwal' => $id_jadwal])->row();
    }

    // ambil data lengkap si pendaftar dari view pada database berdasarkan ID
    public function read($id = null)
    {
        return $this->db->get_where('v_data_pd', ['id_pd' => $id])->row();
    }

    // ambil data lengkap si pendaftar dari view pada database berdasarkan ID untuk kartu pendaftaran
    public function data_kartu($id = null)
    {
        return $this->db->get_where('v_data_pendaftar', ['id_akun' => $id])->row();
    }

    // ambil data pendaftar dari view untuk export ke excel
    public function pendaftar_all($tahun_akademik)
    {
        return $this->db->order_by('id_prodi', 'ASC')->order_by('no_daftar', 'ASC')->get_where('v_data_pendaftar', ['tahun_akademik' => $tahun_akademik])->result();
    }

    // cek sudah ikut tes tulis atau belum
    // periksa apakah sudah mengerjakan atau belum
    public function cek_ikut_tes_tulis($id_akun)
    {
        return $this->db->get_where('pmb_hasil_tes', ['id_akun' => $id_akun, 'status' => 'Y'])->row();
    }

    // proses menyimpan data pendaftar
    public function create($data)
    {
        // jalur pendaftaran
        $jalur_pendaftaran = $this->getGelombang(date('Y-m-d'));
        // value insert akun
        $val_akun = [
            'id_akun'        => $data['id_akun'],
            'nama_akun'      => strtoupper($data['nama_akun']),
            'password_akun'  => set_password($data['password_akun']),
            'hp_akun'        => $data['hp_akun'],
            'tgl_akun'       => $data['tgl_akun'],
            'id_jadwal'      => $jalur_pendaftaran->id_jadwal,
            'tahun_akademik' => $data['tahun_akademik'],
            'id_user'        => $this->session->id_user,
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
            'email'      => strtolower($data['email']),
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

    // hapus data pendaftar
    public function delete($id)
    {
        // jika ada id nya
        if ($id) {
            // hapus data dengan cara soft delete ubah ke 1
            $hapus = $this->db->update('pmb_akunmaba', ['soft_del' => '1'], ['id_akun' => $id['id_akun']]);
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
     * BIODATA
     * 
     * 1. Proses ambil data biodata dari tabel biodata berdasarkan ID akun
     * 2. Proses update data biodata berdasarkan ID akun
     * ============================================================
     */
    public function get_biodata($id)
    {
        $this->db->select('*')
            ->from('pmb_biodata a')
            ->join('ref_agama b', 'a.id_agama = b.id_agama', 'LEFT')
            ->where(['id_akun' => $id]);
        return $this->db->get()->row();
    }

    public function edit_biodata($data)
    {
        // set data untuk diupdate
        $value = [
            'nm_pd'      => strtoupper($data['nm_pd']),
            'nik'        => $data['nik'],
            'tmpt_lahir' => $data['tmpt_lahir'],
            'tgl_lahir'  => $data['tgl_lahir'],
            'id_agama'   => $data['id_agama'],
            'jk'         => $data['jk'],
            'updated_at' => date("Y-m-d H:i:s")
        ];
        // set data untuk ganti ke akun jika ada perubahan nama
        $val_akun = [
            'nama_akun'  => strtoupper($data['nm_pd']),
        ];
        // update tabel biodata
        $update = $this->db->update('pmb_biodata', $value, ['id_akun' => $data['id_akun']]);
        // cek status simpan
        if ($update) {
            // update nama pada akun maba
            $updateakun = $this->db->update('pmb_akunmaba', $val_akun, ['id_akun' => $data['id_akun']]);
            if ($updateakun) {
                // buat respon berhasil
                $response = [
                    'status'  => true,
                    'message' => 'Biodata berhasil diubah',
                    'title'   => 'Berhasil!',
                    'type'    => 'success'
                ];
            } else {
                // buat respon gagal
                $response = [
                    'status'  => false,
                    'message' => 'Gagal merubah nama akun',
                    'title'   => 'Gagal!',
                    'type'    => 'danger'
                ];
            }
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal merubah biodata',
                'title'   => 'Gagal!',
                'type'    => 'danger'
            ];
        }
        return $response;
    }

    /**
     * ============================================================
     * KONTAK
     * 
     * 1. Proses ambil data kontak dari tabel kontak berdasarkan ID akun
     * 2. Proses update data kontak berdasarkan ID akun
     * ============================================================
     */
    public function get_kontak($id)
    {
        return $this->db->get_where('pmb_kontak', ['id_akun' => $id])->row();
    }

    public function edit_kontak($data)
    {
        // set data untuk diupdate
        $value = [
            'no_hp'      => $data['no_hp'],
            'no_hp_ortu' => $data['no_hp_ortu'],
            'email'      => strtolower($data['email']),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        // set akun untuk diupdate
        $value_akun = [
            'hp_akun'    => $data['no_hp'],
            'updated_at' => date("Y-m-d H:i:s")
        ];

        // update tabel biodata
        $update = $this->db->update('pmb_kontak', $value, ['id_akun' => $data['id_akun']]);
        // cek status simpan
        if ($update) {
            // ubah nomor pada tabel akun
            $update_akun = $this->db->update('pmb_akunmaba', $value_akun, ['id_akun' => $data['id_akun']]);
            // cek status simpan
            if ($update_akun) {
                // buat respon berhasil
                $response = [
                    'status'  => true,
                    'message' => 'Kontak berhasil diubah',
                    'title'   => 'Berhasil!',
                    'type'    => 'success'
                ];
            } else {
                // buat respon gagal
                $response = [
                    'status'  => false,
                    'message' => 'Kontak pada akun gagal diubah',
                    'title'   => 'Gagal!',
                    'type'    => 'danger'
                ];
            }
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal merubah kontak',
                'title'   => 'Gagal!',
                'type'    => 'danger'
            ];
        }
        return $response;
    }

    /**
     * ============================================================
     * ALAMAT
     * 
     * 1. Proses ambil data alamat dari tabel alamat berdasarkan ID akun
     * 2. Proses update data alamat berdasarkan ID akun
     * ============================================================
     */
    public function get_alamat($id)
    {
        $this->db->select('*')
            ->from('pmb_alamat a')
            ->join('ref_wilayah b', 'a.id_wil = b.id_wil', 'LEFT')
            ->where(['id_akun' => $id]);
        return $this->db->get()->row();
    }

    public function edit_alamat($data)
    {
        // set data untuk diupdate
        $value = [
            'jln'      => $data['jln'],
            'rt'       => $data['rt'],
            'rw'       => $data['rw'],
            'nm_dsn'   => $data['nm_dsn'],
            'ds_kel'   => $data['ds_kel'],
            'kode_pos' => $data['kode_pos'],
            'id_prov'  => $data['id_prov'],
            'id_kab'   => $data['id_kab'],
            'id_wil'   => $data['id_wil'],
        ];
        // update tabel biodata
        $update = $this->db->update('pmb_alamat', $value, ['id_akun' => $data['id_akun']]);
        // cek status simpan
        if ($update) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Alamat berhasil diubah',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal merubah alamat',
                'title'   => 'Gagal!',
                'type'    => 'danger'
            ];
        }
        return $response;
    }

    /**
     * ============================================================
     * ORANG TUA
     * 
     * 1. Proses ambil data ortu dari tabel ortu berdasarkan ID akun
     * 2. Proses update data ortu berdasarkan ID akun
     * ============================================================
     */
    public function get_ortu($id)
    {
        // $this->db->select('*')
        //     ->from('pmb_orang_tua a')
        //     ->join('ref_penghasilan b', 'a.id_penghasilan_ayah = b.id_penghasilan', 'LEFT')
        //     ->where(['id_akun' => $id]);
        return $this->db->get_where('pmb_orang_tua', ['id_akun' => $id])->row();
    }

    public function edit_ortu($data)
    {
        // set data untuk diupdate
        $value = [
            'nm_ayah'           => $data['nm_ayah'],
            'id_pekerjaan_ayah' => $data['id_pekerjaan_ayah'],
            'nm_ibu'            => $data['nm_ibu'],
            'id_pekerjaan_ibu'  => $data['id_pekerjaan_ibu'],
            'updated_at'        => date("Y-m-d H:i:s")
        ];
        // update tabel biodata
        $update = $this->db->update('pmb_orang_tua', $value, ['id_akun' => $data['id_akun']]);
        // cek status simpan
        if ($update) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Orang tua berhasil diubah',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal merubah ortu',
                'title'   => 'Gagal!',
                'type'    => 'danger'
            ];
        }
        return $response;
    }

    /**
     * ============================================================
     * SEKOLAH ASAL
     * 
     * 1. Proses ambil data sekolah dari tabel sekolah berdasarkan ID akun
     * 2. Proses update data sekolah berdasarkan ID akun
     * ============================================================
     */
    public function get_sekolah_asal($id)
    {
        $this->db->select('*')
            ->from('pmb_sekolah_asal a')
            ->join('pmb_ref_masuk b', 'a.id_ref_masuk = b.id_ref_masuk', 'LEFT')
            ->where(['id_akun' => $id]);
        return $this->db->get()->row();
    }

    public function edit_sekolah_asal($data)
    {
        // set data untuk diupdate
        $value = [
            'jenjang'        => $data['jenjang'],
            'sekolah'        => $data['sekolah'],
            'alamat_sekolah' => $data['alamat_sekolah'],
            'id_ref_masuk'   => $data['id_ref_masuk'],
            'updated_at'     => date("Y-m-d H:i:s")
        ];
        // update tabel biodata
        $update = $this->db->update('pmb_sekolah_asal', $value, ['id_akun' => $data['id_akun']]);
        // cek status simpan
        if ($update) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Sekolah asal berhasil diubah',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal merubah sekolah asal',
                'title'   => 'Gagal!',
                'type'    => 'danger'
            ];
        }
        return $response;
    }

    /**
     * ============================================================
     * PRODI PILIHAN
     * 
     * 1. Proses ambil data prodi dari tabel prodi berdasarkan ID akun
     * 2. Proses update data prodi berdasarkan ID akun
     * ============================================================
     */
    public function get_prodi($id)
    {
        $this->db->select('*')
            ->from('pmb_prodi_pilihan a')
            ->join('ref_jns_prodi b', 'b.id_prodi = a.id_prodi', 'LEFT')
            ->join('ref_prodi c', 'c.kode_prodi = b.kode_prodi', 'LEFT')
            ->where(['id_akun' => $id]);
        return $this->db->get()->row();
    }

    public function edit_prodi($data)
    {
        // set data untuk diupdate
        $value = [
            'id_prodi'   => $data['id_prodi'],
            'urutan'     => $this->urutan->urutan($data['id_prodi']),
            'no_daftar'  => $this->urutan->nomordaftar($data['id_prodi']),
            'updated_at' => date("Y-m-d H:i:s")
        ];
        // update tabel prodi
        $update = $this->db->update('pmb_prodi_pilihan', $value, ['id_akun' => $data['id_akun']]);
        // cek status simpan
        if ($update) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Prodi berhasil diubah',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal merubah prodi',
                'title'   => 'Gagal!',
                'type'    => 'danger'
            ];
        }
        return $response;
    }

    // proses penerimaan pendaftar
    // merubah status diterima pada tabel akun pendaftar
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
                        // $response = [
                        //     'status'  => true,
                        //     'message' => 'Peserta berhasil diterima',
                        //     'title'   => 'Sukses!',
                        //     'type'    => 'success'
                        // ];
                        // lakukan pengiriman SMS
                        $response = $this->kirim_sms($id);
                    } else {
                        $response = [
                            'status'  => false,
                            'message' => 'Gagal merubah status peserta',
                            'title'   => 'Gagal!',
                            'type'    => 'danger'
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

    // proses mengirim SMS bahwa status pendaftaran sudah diterima
    // sekaligus info jadwal registrasi ulang
    public function kirim_sms($id_akun)
    {
        // ambil nomor hp berdasarkan id_akun
        $get_data = $this->db->get_where('v_data_pendaftar', ['id_akun' => $id_akun])->row();
        // jika ada
        if ($get_data) {
            $userkey = '151b0f676f41';
            $passkey = '3df98d91c9debd05963099e7';
            $telepon = $get_data->hp_akun;
            $message = 'Hai, ' . $get_data->nm_pd . '. Selamat, kamu diterima di STIKes Muhammadiyah Ciamis. Segera registrasi ulang paling lambat ' . $this->date->tanggal($get_data->batas_reg_ulang, 'l') . '.';
            $url = 'https://console.zenziva.net/masking/api/sendsms/';
            $curlHandle = curl_init();
            curl_setopt($curlHandle, CURLOPT_URL, $url);
            curl_setopt($curlHandle, CURLOPT_HEADER, 0);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
            curl_setopt($curlHandle, CURLOPT_POST, 1);
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
                'userkey' => $userkey,
                'passkey' => $passkey,
                'to' => $telepon,
                'message' => $message
            ));
            $results = json_decode(curl_exec($curlHandle), true);
            curl_close($curlHandle);

            if ($results['status'] == '1') {
                // info pendaftaran berhasil
                $response = [
                    'status'  => true,
                    'message' => 'Berhasil diterima. Pesan berhasil dikirim',
                    'title'   => 'Berhasil',
                    'type'    => 'success'
                ];
            } else {
                // info pendaftaran akun gagal
                $response = [
                    'status'  => false,
                    'message' => 'Berhasil diterima. Pesan gagal dikirim!',
                    'title'   => 'Gagal',
                    'type'    => 'danger'
                ];
            }
        } else {
            // jika nomor hp tidak ada
            $response = [
                'status'  => false,
                'message' => 'Nomor HP tidak ditemukan!',
                'title'   => 'Gagal',
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
        // cek level user
        $level_user = $this->session->level;
        if ($level_user == 'mitra') {
            $by_mitra = ' AND id_user = "' .  $this->session->id_user . '"';
            $column = array(null, 'nm_pd', 'no_daftar', 'nama_prodi', 'hp_akun', 'sekolah', 'tgl_daftar', 'status_diterima');
        } else {
            $by_mitra = '';
            $column = array(null, 'nm_pd', 'no_daftar', 'nama_prodi', 'hp_akun', 'sekolah', 'nama_user', 'status_diterima');
        }

        // filter by tahun akademik
        $ta = tahun_akademik();
        $table = "( SELECT * FROM v_data_pendaftar WHERE tahun_akademik = '$ta' " . $by_mitra . " ) as new_tb";
        $column_order = $column;
        $column_search = array('nm_pd', 'no_daftar', 'nama_prodi', 'hp_akun', 'sekolah', 'jalur');
        $orders = array('created_at' => 'DESC');

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
