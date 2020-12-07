<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
    }

    public function index()
    {
        $data = [
            'title' => 'Halaman Utama',
            'm_home' => 'active',
        ];
        template('home/index', $data);
    }
}
