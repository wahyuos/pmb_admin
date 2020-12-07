<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_login extends CI_Model
{
    public function doLogin($data)
    {
        // periksa akun
        $get_username = $this->db->get_where('adm_user', ['username' => $data['username'], 'soft_del' => '0']);
        $rows   = $get_username->num_rows();

        if ($rows > 0) {
            $result = $get_username->row();
            // cocokan password
            if (password_verify($data['password'], $result->password)) {
                $sesi = [
                    'is_login'  => true,
                    'id_user'   => $result->id_user,
                    'nama_user' => $result->nama_user,
                    'username'  => $result->username,
                    'level'     => $result->level,
                ];
                // buat sesi login
                $this->session->set_userdata($sesi);
                $response = [
                    'status'  => true,
                    'message' => 'Login berhasil',
                    'title'   => 'Sukses!',
                    'type'    => 'success'
                ];
            } else {
                $response = [
                    'status'  => false,
                    'message' => 'Password salah!',
                    'title'   => 'Gagal!',
                    'type'    => 'danger'
                ];
            }
        } else {
            $response = [
                'status'  => false,
                'message' => 'Username tidak ditemukan!',
                'title'   => 'Gagal!',
                'type'    => 'danger'
            ];
        }

        return $response;
    }
}
