<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter Tanggal Class
 * 
 * Untuk merubah format tanggal ke format Indonesia
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Wahyu Kamaludin
 */

class CI_Date
{
    public function hari($tanggal)
    {
        $hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        // tentukan nama hari
        $nama_hari = date('w', strtotime($tanggal));
        // kembalikan nama hari
        return $hari[$nama_hari];
    }

    public function bulan($tanggal)
    {
        $bulan    = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'];
        // pisahkan untuk mengambil angka bulan
        $pecahkan = explode('-', $tanggal);
        // kembalikan nama bulan dalam bentuk string
        return $bulan[(int) $pecahkan[1]];
    }

    public function tanggal($tanggal, $format = null)
    {
        if ($tanggal) {
            // nama hari
            $hari = $this->hari($tanggal);
            // memisahkan tanggal untuk menyesuaikan posisinya
            $pecahkan = explode('-', $tanggal);
            // nama bulan
            $nm_bulan = $this->bulan($tanggal);

            if ($format == 's') {
                // jika s, maka nama bulan disingkat, hanya 3 huruf pertama (tanpa hari)
                return $pecahkan[2] . ' ' . substr($nm_bulan, 0, 3) . ' ' . $pecahkan[0];
            } elseif ($format == 'p') {
                // jika p, maka nama bulan tidak disingkat (tanpa hari)
                return $pecahkan[2] . ' ' . $nm_bulan . ' ' . $pecahkan[0];
            } else {
                // jika kosong, maka akan ditampilkan tanggal lengkap (har, tanggal bulan tahun)
                return $hari . ', ' . $pecahkan[2] . ' ' . $nm_bulan . ' ' . $pecahkan[0];
            }
        } else {
            return "Format tanggal salah";
        }
    }
}
