<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @category    Controller
 * @author      Wahyu Kamaludin
 */

class Lakukeun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pmbva/M_briva', 'briva');
        $this->load->library('curl');
    }

    private function kaamanan()
    {
        // authorization
        $client_id = 'swG7yG7PmxHQ11QpTxDoXltol8svPAQw';
        $secret_id = 'xADFHIAfw0mPNBx4';
        $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
        $token = $this->briva->BRIVAgenerateToken($client_id, $secret_id);
        // buat array untuk di return
        $value = [
            'secret_id' => $secret_id,
            'timestamp' => $timestamp,
            'token' => $token
        ];
        return $value;
    }

    // simpan 
    public function simpen()
    {
        // authorization
        $auth = $this->kaamanan();
        $secret_id = $auth['secret_id'];
        $timestamp = $auth['timestamp'];
        $token = $auth['token'];

        // data yang akan disimpan
        $institutionCode = "J104408";
        $brivaNo = "77777";
        $custCode = "123456789115";
        $nama = "Sabrina";
        $amount = "100000";
        $keterangan = "Testing BRIVA";
        $expiredDate = "2020-02-27 23:59:00";
        // simpan dalam array
        $datas = array(
            'institutionCode' => $institutionCode,
            'brivaNo' => $brivaNo,
            'custCode' => $custCode,
            'nama' => $nama,
            'amount' => $amount,
            'keterangan' => $keterangan,
            'expiredDate' => $expiredDate
        );

        // param untuk signature
        $payload = json_encode($datas, true);
        $path = "/v1/briva";
        $verb = "POST";
        // buat signature
        $base64sign = $this->briva->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret_id);

        // header
        $request_headers = array(
            "Content-Type:" . "application/json",
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );

        // akses CURL
        $urlPost = "https://sandbox.partner.api.bri.co.id/v1/briva";
        $result = $this->briva->BRIVAurlAPI($urlPost, $request_headers, $verb, $payload);

        // hasil
        echo $result;
    }

    // get
    public function candak()
    {
        // authorization
        $auth = $this->kaamanan();
        $secret_id = $auth['secret_id'];
        $timestamp = $auth['timestamp'];
        $token = $auth['token'];

        // data yang akan diambil
        $institutionCode = "J104408";
        $brivaNo = "77777";
        $custCode = "123456789115";

        // param untuk signature
        $payload = null;
        $path = "/v1/briva/" . $institutionCode . "/" . $brivaNo . "/" . $custCode;
        $verb = "GET";
        // buat signature
        $base64sign = $this->briva->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret_id);

        // header
        $request_headers = array(
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );

        // akses CURL
        $urlPost = "https://sandbox.partner.api.bri.co.id/v1/briva/" . $institutionCode . "/" . $brivaNo . "/" . $custCode;
        $result = $this->briva->BRIVAurlAPI($urlPost, $request_headers, $verb, $payload);

        // hasil
        echo $result;
    }

    // get report
    public function candak_report()
    {
        // authorization
        $auth = $this->kaamanan();
        $secret_id = $auth['secret_id'];
        $timestamp = $auth['timestamp'];
        $token = $auth['token'];

        // data yang akan diambil
        $institutionCode = "J104408";
        $brivaNo = "77777";
        $startDate = "20210201";
        $endDate = "20210202";

        // param untuk signature
        $payload = null;
        $path = "/v1/briva/report/" . $institutionCode . "/" . $brivaNo . "/" . $startDate . "/" . $endDate;
        $verb = "GET";
        // buat signature
        $base64sign = $this->briva->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret_id);

        // header
        $request_headers = array(
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );

        // akses CURL
        $urlPost = "https://sandbox.partner.api.bri.co.id/v1/briva/report/" . $institutionCode . "/" . $brivaNo . "/" . $startDate . "/" . $endDate;
        $result = $this->briva->BRIVAurlAPI($urlPost, $request_headers, $verb, $payload);

        // hasil
        echo $result;
    }

    // get status
    public function candak_status()
    {
        // authorization
        $auth = $this->kaamanan();
        $secret_id = $auth['secret_id'];
        $timestamp = $auth['timestamp'];
        $token = $auth['token'];

        // data yang akan diambil
        $institutionCode = "J104408";
        $brivaNo = "77777";
        $custCode = "123456789115";

        // param untuk signature
        $payload = null;
        $path = "/v1/briva/status/" . $institutionCode . "/" . $brivaNo . "/" . $custCode;
        $verb = "GET";
        // buat signature
        $base64sign = $this->briva->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret_id);

        // header
        $request_headers = array(
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );

        // akses CURL
        $urlPost = "https://sandbox.partner.api.bri.co.id/v1/briva/status/" . $institutionCode . "/" . $brivaNo . "/" . $custCode;
        $result = $this->briva->BRIVAurlAPI($urlPost, $request_headers, $verb, $payload);

        // hasil
        echo $result;
    }

    // update
    public function robih()
    {
        // authorization
        $auth = $this->kaamanan();
        $secret_id = $auth['secret_id'];
        $timestamp = $auth['timestamp'];
        $token = $auth['token'];

        // data yang akan diambil
        $institutionCode = "J104408";
        $brivaNo = "77777";
        $custCode = "123456789115";
        $nama = "Brigita";
        $amount = "1000000";
        $keterangan = "BRIVA Testing";
        $expiredDate = "2021-02-10 23:59:00";
        // simpan dalam array
        $datas = array(
            'institutionCode' => $institutionCode,
            'brivaNo' => $brivaNo,
            'custCode' => $custCode,
            'nama' => $nama,
            'amount' => $amount,
            'keterangan' => $keterangan,
            'expiredDate' => $expiredDate
        );

        // param untuk signature
        $payload = json_encode($datas, true);
        $path = "/v1/briva";
        $verb = "PUT";
        // buat signature
        $base64sign = $this->briva->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret_id);

        // header
        $request_headers = array(
            "Content-Type:" . "application/json",
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );

        // akses CURL
        $urlPost = "https://sandbox.partner.api.bri.co.id/v1/briva";
        $result = $this->briva->BRIVAurlAPI($urlPost, $request_headers, $verb, $payload);

        // hasil
        echo $result;
    }

    // update status
    public function robih_status()
    {
        // authorization
        $auth = $this->kaamanan();
        $secret_id = $auth['secret_id'];
        $timestamp = $auth['timestamp'];
        $token = $auth['token'];

        // data yang akan diambil
        $institutionCode = "J104408";
        $brivaNo = "77777";
        $custCode = "123456789115";
        $statusBayar = "Y";
        // simpan dalam array
        $datas = array(
            'institutionCode' => $institutionCode,
            'brivaNo' => $brivaNo,
            'custCode' => $custCode,
            'statusBayar' => $statusBayar
        );

        // param untuk signature
        $payload = json_encode($datas, true);
        $path = "/v1/briva/status";
        $verb = "PUT";
        // buat signature
        $base64sign = $this->briva->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret_id);

        // header
        $request_headers = array(
            "Content-Type:" . "application/json",
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );

        // akses CURL
        $urlPost = "https://sandbox.partner.api.bri.co.id/v1/briva/status";
        $result = $this->briva->BRIVAurlAPI($urlPost, $request_headers, $verb, $payload);

        // hasil
        echo $result;
    }

    // delete
    public function mupus()
    {
        // authorization
        $auth = $this->kaamanan();
        $secret_id = $auth['secret_id'];
        $timestamp = $auth['timestamp'];
        $token = $auth['token'];

        // data yang akan diambil
        $institutionCode = "J104408";
        $brivaNo = "77777";
        $custCode = "123456789115";

        // param untuk signature
        $payload = "institutionCode=" . $institutionCode . "&brivaNo=" . $brivaNo . "&custCode=" . $custCode;
        $path = "/v1/briva";
        $verb = "DELETE";
        // buat signature
        $base64sign = $this->briva->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret_id);

        // header
        $request_headers = array(
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );

        // akses CURL
        $urlPost = "https://sandbox.partner.api.bri.co.id/v1/briva";
        $result = $this->briva->BRIVAurlAPI($urlPost, $request_headers, $verb, $payload);

        // hasil
        echo $result;
    }
}
