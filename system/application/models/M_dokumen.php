<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dokumen extends CI_Model
{
    public function get_dokumen($tahun_akademik)
    {
        return $this->db->get_where('pmb_dokumen', ['tahun_akademik' => $tahun_akademik])->result();
    }

    public function simpan($data)
    {
        // set data untuk disimpan
        $value = [
            'id_dokumen' => uuid_v4(),
            'nama_dokumen' => $data['nama_dokumen'],
            'file_path' => $data['file_path'],
            'file_name' => $data['file_name'],
            'file_type' => $data['file_type'],
            'tahun_akademik' => $data['tahun_akademik'],
            'created_at' => date("Y-m-d H:i:s")
        ];
        // simpan ke tabel biaya
        $simpan = $this->db->insert('pmb_dokumen', $value);
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

        return $response;
    }

    public function hapus($id)
    {
        $get_data = $this->db->get_where('pmb_dokumen', ['id_dokumen' => $id['id_dokumen']])->row();
        $hapus = $this->db->delete('pmb_dokumen', ['id_dokumen' => $id['id_dokumen']]);
        if ($hapus) {
            // hapus file
            if ($get_data) {
                unlink($get_data->file_path . $get_data->file_name);
            }
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'File berhasil dihapus',
                'title'   => 'Berhasil',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'File gagal dihapus',
                'title'   => 'Gagal',
                'type'    => 'error'
            ];
        }

        return $response;
    }
}
