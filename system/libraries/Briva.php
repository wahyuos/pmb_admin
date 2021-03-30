<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter BRIVA
 * 
 * Untuk API virtual akun BRI
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Wahyu Kamaludin
 */

class CI_Briva
{

    /* Generate Token */
    private function BRIVAgenerateToken($client_id, $secret_id)
    {
        // akses CURL
        $url = arr_briva()->urlApi . "/oauth/client_credential/accesstoken?grant_type=client_credentials";
        $data = "client_id=" . $client_id . "&client_secret=" . $secret_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // ambil nilai token
        $json = json_decode($result, true);
        $accesstoken = $json['access_token'];

        return $accesstoken;
    }

    /* Generate signature */
    private function BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret)
    {
        $payloads = "path=$path&verb=$verb&token=Bearer $token&timestamp=$timestamp&body=$payload";
        $signPayload = hash_hmac('sha256', $payloads, $secret, true);
        return base64_encode($signPayload);
    }

    /* Akses CURL */
    private function BRIVAurlAPI($url, $request_headers, $verb, $payload)
    {
        // akses CURL
        $chPost = curl_init();
        curl_setopt($chPost, CURLOPT_URL, $url);
        curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, $verb);
        curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
        curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);

        $resultPost = curl_exec($chPost);
        $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
        curl_close($chPost);

        return $resultPost;
    }

    /* authorization */
    private function kaamanan()
    {
        // authorization
        $client_id = arr_briva()->client_id;
        $secret_id = arr_briva()->secret_id;
        $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
        $token = $this->BRIVAgenerateToken($client_id, $secret_id);
        // buat array untuk di return
        $value = [
            'secret_id' => $secret_id,
            'timestamp' => $timestamp,
            'token' => $token
        ];
        return $value;
    }

    // get
    public function candak($data = null)
    {
        if ($data) {
            // authorization
            $auth = $this->kaamanan();
            $secret_id = $auth['secret_id'];
            $timestamp = $auth['timestamp'];
            $token = $auth['token'];

            // data yang akan diambil
            $institutionCode = arr_briva()->kodeInstitusi;
            $brivaNo = arr_briva()->kodebriva;
            $custCode = $data['nomor'];

            // param untuk signature
            $payload = null;
            $path = "/v1/briva/" . $institutionCode . "/" . $brivaNo . "/" . $custCode;
            $verb = "GET";
            // buat signature
            $base64sign = $this->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret_id);

            // header
            $request_headers = array(
                "Authorization:Bearer " . $token,
                "BRI-Timestamp:" . $timestamp,
                "BRI-Signature:" . $base64sign,
            );

            // akses CURL
            $urlPost = arr_briva()->urlApi . $path;
            $result = $this->BRIVAurlAPI($urlPost, $request_headers, $verb, $payload);
        } else {
            $result = [
                "status" => false,
                "errDesc" => "Parameter tidak ditemukan",
                "responseCode" => "99"
            ];
            $result = json_encode($result);
        }
        // hasil
        return $result;
    }
}
