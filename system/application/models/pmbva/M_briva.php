<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author     Wahyu Kamaludin
 * @category   Models
 */

class M_briva extends CI_Model
{
    /* Generate Token */
    public function BRIVAgenerateToken($client_id, $secret_id)
    {
        // akses CURL
        $url = "https://sandbox.partner.api.bri.co.id/oauth/client_credential/accesstoken?grant_type=client_credentials";
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
    public function BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret)
    {
        $payloads = "path=$path&verb=$verb&token=Bearer $token&timestamp=$timestamp&body=$payload";
        $signPayload = hash_hmac('sha256', $payloads, $secret, true);
        return base64_encode($signPayload);
    }

    /* Akses CURL */
    public function BRIVAurlAPI($url, $request_headers, $verb, $payload)
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
}
