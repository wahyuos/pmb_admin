<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_atur_briva extends CI_Model
{
    public function get_briva()
    {
        return $this->db->get('ref_pmbva')->row();
    }

    public function getDataByBriva($kode)
    {
        return $this->db->get_where('ref_pmbva', ['kodebriva' => $kode])->row();
    }

    public function updateInfoBriva($data)
    {
        $value = [
            'urlApi' => $data['urlApi'],
            'kodeInstitusi' => $data['kodeInstitusi'],
            'kodebriva' => $data['kodebriva'],
            'biayaDaftar' => $data['biayaDaftar'],
            'ketBayar' => $data['ketBayar'],
            'client_id' => $data['client_id'],
            'secret_id' => $data['secret_id'],
        ];

        $update = $this->db->update('ref_pmbva', $value);

        if ($update) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Info BRIVA berhasil diubah',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal merubah Info BRIVA',
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }

        return $response;
    }
}
