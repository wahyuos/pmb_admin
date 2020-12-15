<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == true) redirect(base_url('home'));
        $this->load->model('M_login', 'login');
    }

    public function index()
    {
        $data = [
            'title' => 'Halaman Login'
        ];
        $this->load->view('login/index', $data);
    }

    public function do_login()
    {
        // post data
        $post    = $this->input->post(null, true);
        if ($post) {
            $value = [
                'username' => htmlspecialchars(trim($post['username'])),
                'password' => htmlspecialchars(trim($post['password']))
            ];
            // kirim ke model login
            $response = $this->login->doLogin($value);
        } else {
            // buat respon
            $response = [
                'status'  => false,
                'message' => 'Tidak ada post data',
                'title'   => 'Akses ditolak!',
                'type'    => 'text-danger'
            ];
        }

        echo json_encode($response);
    }
}
