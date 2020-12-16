<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_biaya extends CI_Model
{
    public function get_biaya($tahun_akademik)
    {
        return $this->db->get_where('pmb_biaya', ['tahun_akademik' => $tahun_akademik])->row();
    }

    public function simpan($data)
    {
        // periksa data berdasarkan id_akun
        $cek_data = $this->db->get_where('pmb_biaya', ['tahun_akademik' => $data['tahun_akademik']])->num_rows();
        $cek = ($cek_data == 0) ? true : false;
        if ($cek) {
            // set data untuk disimpan
            $value = [
                'id_biaya'  => uuid_v4(),
                'file_path' => $data['file_path'],
                'file_name' => $data['file_name'],
                'file_type' => $data['file_type'],
                'tahun_akademik' => $data['tahun_akademik'],
                'created_at' => date("Y-m-d H:i:s")
            ];
            // simpan ke tabel biaya
            $simpan = $this->db->insert('pmb_biaya', $value);
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
            // update tabel biaya
            $update = $this->db->update('pmb_biaya', $value, ['tahun_akademik' => $data['tahun_akademik']]);
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
