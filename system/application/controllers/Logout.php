<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller untuk logout
 * 
 * @author     Wahyu Kamaludin
 * @category   Controllers
 */
class Logout extends CI_Controller
{
    public function index()
    {
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
}
