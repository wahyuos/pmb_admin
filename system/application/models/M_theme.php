<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model theme
 * 
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_theme extends CI_Model
{
    // ubah warna tema
    public function ubah_tema($data)
    {
        // set value
        $value = [
            'theme' => $data['theme'],
            'css' => $data['css']
        ];
        $ubah = $this->db->update('ref_theme', $value);
        if ($ubah) {
            // buat respon berhasil
            $response = [
                'status'  => true,
                'message' => 'Tema berhasil diubah',
                'title'   => 'Berhasil!',
                'type'    => 'success'
            ];
        } else {
            // buat respon gagal
            $response = [
                'status'  => false,
                'message' => 'Gagal mengganti tema',
                'title'   => 'Gagal!',
                'type'    => 'error'
            ];
        }
        return $response;
    }
}
