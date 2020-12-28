<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter
 * 
 * Untuk pengecekan dibuka pendaftaran
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Wahyu Kamaludin
 */

class CI_Cek_pendaftaran
{
    // keterangan gelombang pendaftaran
    public function status($tgl_daftar)
    {
        $keterangan = get_instance()->db->get_where('ref_jadwal', ['periode_awal <= ' => $tgl_daftar, 'periode_akhir >= ' => $tgl_daftar])->row();
        // jika null
        if ($keterangan) {
            if ($keterangan->soft_del == '0') {
                // jika sudah dibuka
                $response = [
                    'status' => true,
                    'keterangan' => 'Pendaftaran sudah dibuka.',
                ];
            } else {
                $response = [
                    'status' => false,
                    'keterangan' => 'Pendaftaran belum dibuka.',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'keterangan' => 'Pendaftaran belum dibuka.',
            ];
        }

        return $response;
    }
}
