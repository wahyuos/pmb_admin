<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_panduan extends CI_Model
{
    public function get_panduan()
    {
        return $this->db->get('pmb_panduan')->row();
    }

    public function simpan($data)
    {
        // periksa data berdasarkan id_akun
        $cek_data = $this->db->get('pmb_panduan')->num_rows();
        $cek = ($cek_data == 0) ? true : false;
        if ($cek) {
            // set data untuk disimpan
            $value = [
                'id_panduan' => 1,
                'file_path'  => $data['file_path'],
                'file_name'  => $data['file_name'],
                'file_type'  => $data['file_type'],
                'created_at' => date("Y-m-d H:i:s")
            ];
            // simpan ke tabel panduan
            $simpan = $this->db->insert('pmb_panduan', $value);
            // cek status simpan
            if ($simpan) {
                // buat respon berhasil
                $response = [
                    'status'  => true,
                    'message' => 'File berhasil diupload',
                    'title'   => 'Berhasil!',
                    'type'    => 'success'
                ];
            } else {
                // buat respon gagal
                $response = [
                    'status'  => false,
                    'message' => 'Gagal mengupload file',
                    'title'   => 'Gagal!',
                    'type'    => 'danger'
                ];
            }
        } else {
            // set data untuk diupdate
            $value = [
                'file_path' => $data['file_path'],
                'file_name' => $data['file_name'],
                'file_type' => $data['file_type'],
                'updated_at' => date("Y-m-d H:i:s")
            ];
            // update tabel panduan
            $update = $this->db->update('pmb_panduan', $value);
            // cek status simpan
            if ($update) {
                // buat respon berhasil
                $response = [
                    'status'  => true,
                    'message' => 'File berhasil diupload',
                    'title'   => 'Berhasil!',
                    'type'    => 'success'
                ];
            } else {
                // buat respon gagal
                $response = [
                    'status'  => false,
                    'message' => 'Gagal mengupload file',
                    'title'   => 'Gagal!',
                    'type'    => 'danger'
                ];
            }
        }

        return $response;
    }
}
