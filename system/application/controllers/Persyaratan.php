<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persyaratan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // jika sesi login false, kembali ke login
        if ($this->session->is_login == false) redirect(base_url('login'));
        $this->load->model('M_persyaratan', 'persyaratan');
        $this->id_akun = $this->uri->segment(3);
    }

    private function cek_data()
    {
        return $this->persyaratan->cek_data('pmb_persyaratan', $this->id_akun, $this->uri->segment(4));
    }

    /**
     * Halaman form upload KK mahasiswa baru
     */
    public function upload_kk()
    {
        // cek ketersediaan ada
        if ($this->cek_data()) {
            $get_kk = '';
        } else {
            // ambil data persyaratan berdasarkan id_akun
            $get_kk = $this->persyaratan->getKK($this->id_akun, $this->uri->segment(4));
        }

        $data = [
            'title' => 'Upload KK',
            'm_pendaftaran' => 'active',
            'dt_pendaftaran' => 'active',
            'doc_kk' => $get_kk
        ];
        template('persyaratan/upload_kk', $data);
    }

    /**
     * Halaman form upload Ijazah mahasiswa baru
     */
    public function upload_ijazah()
    {
        // cek ketersediaan ada
        if ($this->cek_data()) {
            $get_ijazah = '';
        } else {
            // ambil data persyaratan berdasarkan id_akun
            $get_ijazah = $this->persyaratan->getIjazah($this->id_akun, $this->uri->segment(4));
        }

        $data = [
            'title' => 'Upload Ijazah',
            'm_pendaftaran' => 'active',
            'dt_pendaftaran' => 'active',
            'doc_ijazah' => $get_ijazah
        ];
        template('persyaratan/upload_ijazah', $data);
    }

    /**
     * Halaman form upload foto mahasiswa baru
     */
    public function upload_foto()
    {
        // cek ketersediaan ada
        if ($this->cek_data()) {
            $get_foto = '';
        } else {
            // ambil data persyaratan berdasarkan id_akun
            $get_foto = $this->persyaratan->getFoto($this->id_akun, $this->uri->segment(4));
        }

        $data = [
            'title' => 'Upload Foto',
            'm_pendaftaran' => 'active',
            'dt_pendaftaran' => 'active',
            'doc_foto' => $get_foto
        ];
        template('persyaratan/upload_foto', $data);
    }

    /**
     * Proses menyimpan dokumen persyaratan peserta
     */
    public function simpan()
    {
        // post data
        $post    = $this->input->post(null, true);
        if ($post) {
            $config['upload_path']   = './assets/temp';
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size']      = 200;
            // $config['max_width']            = 512;
            // $config['max_height']           = 512;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file_persyaratan')) {
                // buat respon
                $response = [
                    'status'  => false,
                    'message' => $this->upload->display_errors(),
                    'title'   => 'Gagal!',
                    'type'    => 'text-danger'
                ];
            } else {
                $image_data  = $this->upload->data();
                $imgdata     = file_get_contents($image_data['full_path']);
                $file_encode = base64_encode($imgdata);

                // set value untuk disimpan
                $value = [
                    'id_akun'  => htmlspecialchars($post['id_akun']),
                    'blob_doc' => $file_encode,
                    'type_doc' => $image_data['file_type'],
                    'name_doc' => $image_data['file_name'],
                    'id_jns_persyaratan' => htmlspecialchars($post['id_jns_persyaratan']),
                ];

                // kirim ke model simpan
                $response = $this->persyaratan->simpan($value);
                // hapus
                unlink($image_data['full_path']);
            }
        } else {
            // buat respon
            $response = [
                'status'  => false,
                'message' => 'Tidak ada data',
                'title'   => 'Gagal!',
                'type'    => 'text-danger'
            ];
        }

        echo json_encode($response);
    }
}
