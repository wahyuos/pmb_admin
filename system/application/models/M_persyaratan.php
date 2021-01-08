<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_persyaratan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cek_data($table, $id, $id_jns_persyaratan)
    {
        // periksa data peserta pada tabel yang dimaksud berdasarkan id_akun
        $cek_data = $this->db->get_where($table, ['id_akun' => $id, 'id_jns_persyaratan' => $id_jns_persyaratan])->num_rows();
        return ($cek_data == 0) ? true : false;
    }

    public function cek_kelengkapan_persyaratan($id_akun)
    {
        return $this->db->get_where('pmb_persyaratan', ['id_akun' => $id_akun])->num_rows();
    }

    public function jnsPersyaratan()
    {
        return $this->db->order_by('id_jns_persyaratan', 'asc')->get('pmb_jns_persyaratan')->result();
    }

    public function getKK($id_akun, $id_jns_persyaratan)
    {
        return $this->db->get_where('pmb_persyaratan', ['id_akun' => $id_akun, 'id_jns_persyaratan' => $id_jns_persyaratan])->row();
    }

    public function getIjazah($id_akun, $id_jns_persyaratan)
    {
        return $this->db->get_where('pmb_persyaratan', ['id_akun' => $id_akun, 'id_jns_persyaratan' => $id_jns_persyaratan])->row();
    }

    public function getFoto($id_akun, $id_jns_persyaratan)
    {
        return $this->db->get_where('pmb_persyaratan', ['id_akun' => $id_akun, 'id_jns_persyaratan' => $id_jns_persyaratan])->row();
    }

    public function simpan($data)
    {
        // periksa data berdasarkan id_akun
        $cek_data = $this->db->get_where('pmb_persyaratan', ['id_akun' => $data['id_akun'], 'id_jns_persyaratan' => $data['id_jns_persyaratan']])->num_rows();
        $cek = ($cek_data == 0) ? true : false;
        if ($cek) {
            // set data untuk disimpan
            $value = [
                'id_persyaratan'  => uuid_v4(),
                'id_akun'    => $data['id_akun'],
                'blob_doc'   => $data['blob_doc'],
                'type_doc'   => $data['type_doc'],
                'name_doc'   => $data['name_doc'],
                'id_jns_persyaratan' => htmlspecialchars($data['id_jns_persyaratan']),
                'created_at' => date("Y-m-d H:i:s")
            ];
            // simpan ke tabel persyaratan
            $simpan = $this->db->insert('pmb_persyaratan', $value);
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
                'blob_doc' => $data['blob_doc'],
                'type_doc' => $data['type_doc'],
                'name_doc' => $data['name_doc'],
            ];
            // update tabel persyaratan
            $update = $this->db->update('pmb_persyaratan', $value, ['id_akun' => $data['id_akun'], 'id_jns_persyaratan' => $data['id_jns_persyaratan']]);
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
