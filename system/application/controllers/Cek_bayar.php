<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Cek_bayar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_login == false) redirect(base_url('login'));
        if ($this->session->level == 'mitra') redirect(base_url('home'));
    }

    public function index()
    {
        $data = [
            'title' => 'Cek Pembayaran Pendaftaran',
            'm_bayar' => 'active',
        ];
        template('cek_bayar/index', $data);
    }

    // method untuk mengambil sttaus pembayaran VA
    public function status_va()
    {
        // post data
        $post    = $this->input->post(null, true);
        if ($post) {
            // ambil nomor va tanpa kode briva
            $nomor_va = substr($post['nomor_va'], 5);
            // load lib briva dan lib curl
            $this->load->library('curl');
            $this->load->library('briva');
            // data untuk dikirim ke briva
            $val = [
                'urlApi' => arr_briva()->urlApi,
                'kodeInstitusi' => arr_briva()->kodeInstitusi,
                'kodebriva' => arr_briva()->kodebriva,
                'nomor' => $nomor_va,
            ];
            // proses ambil data briva
            $result = $this->briva->candak($val);
        } else {
            $result = [
                "status" => false,
                "errDesc" => "Customer Code tidak ada",
                "responseCode" => "99"
            ];
            $result = json_encode($result);
        }
        echo $result;
    }
}
