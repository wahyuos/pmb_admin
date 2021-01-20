<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_biaya extends CI_Model
{
    public function get_biaya($tahun_akademik)
    {
        return $this->db->get_where('pmb_biaya', ['tahun_akademik' => $tahun_akademik])->row();
    }

    public function get_biaya_prodi($tahun_akademik)
    {
        return $this->db->select('a.id_biaya_prodi, a.id_prodi, a.file_path, a.file_name, c.jenjang, c.nm_prodi, a.tahun_akademik')
            ->from('pmb_biaya_prodi a')
            ->join('ref_jns_prodi b', 'a.id_prodi = b.id_prodi', 'LEFT')
            ->join('ref_prodi c', 'b.kode_prodi = c.kode_prodi', 'LEFT')
            ->where(['tahun_akademik' => $tahun_akademik])
            ->order_by('a.created_at', 'DESC')
            ->get()->result();
    }

    public function hapus($id)
    {
        $get_data = $this->db->get_where('pmb_biaya_prodi', ['id_biaya_prodi' => $id['id_biaya_prodi']])->row();
        $hapus = $this->db->delete('pmb_biaya_prodi', ['id_biaya_prodi' => $id['id_biaya_prodi']]);
        if ($hapus) {
            // hapus file
            unlink($get_data->file_path . $get_data->file_name);
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

    public function simpan($data)
    {
        // periksa data berdasarkan id_akun
        $cek_data = $this->db->get_where('pmb_biaya_prodi', ['id_prodi'  => $data['id_prodi'], 'tahun_akademik' => $data['tahun_akademik']])->num_rows();
        $cek = ($cek_data == 0) ? true : false;
        if ($cek) {
            // set data untuk disimpan
            $value = [
                'id_biaya_prodi'  => uuid_v4(),
                'id_prodi'  => $data['id_prodi'],
                'file_path' => $data['file_path'],
                'file_name' => $data['file_name'],
                'file_type' => $data['file_type'],
                'tahun_akademik' => $data['tahun_akademik'],
                'created_at' => date("Y-m-d H:i:s")
            ];
            // simpan ke tabel biaya
            $simpan = $this->db->insert('pmb_biaya_prodi', $value);
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
