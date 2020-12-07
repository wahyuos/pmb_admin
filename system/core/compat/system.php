<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('set_active')) {
    function set_active()
    {
        if (verify_author()) {
            if (SNID == hash('gost', gethostname())) {
                $arr = [
                    'status' => true,
                    'message' => 'success',
                ];
            } else {
                $arr = [
                    'status' => false,
                    'message' => '<p style="padding:5px">The SNID is not corresponding.<br>SNID is serial number identification. Serves to determine that the application used is legal.<br>If you see this message, make sure to use the app with permission from the owner or developer of the app.<br><br>Please contact: 0853 1449 9212 [' . AUTHOR . ']</p>
                        <p style="border:1px solid #D0D0D0;padding:5px">Hostname : ' . $_SERVER['HTTP_HOST'] . '<br>IP Address : ' . $_SERVER['SERVER_ADDR'] . '<br>User Agent : ' . $_SERVER['HTTP_USER_AGENT'] . '<br>Server name : ' . gethostname() . '</p>',
                ];
            }
        } else {
            $arr = [
                'status' => false,
                'message' => '<p style="padding:5px">The Hash is not corresponding.<br>HASH is a unique number to verify application developers.<br>If you see this message, make sure to use the app with permission from the owner or developer of the app.<br><br>Please contact: 0853 1449 9212 [' . AUTHOR . ']
                    </p>
                    <p style="border:1px solid #D0D0D0;padding:5px">Hostname : ' . $_SERVER['HTTP_HOST'] . '<br>IP Address : ' . $_SERVER['SERVER_ADDR'] . '<br>User Agent : ' . $_SERVER['HTTP_USER_AGENT'] . '<br>Server name : ' . gethostname() . '</p>',
            ];
        }

        return $arr;
    }
}

if (!function_exists('verify_author')) {
    function verify_author()
    {
        if (@HASH == hash('ripemd128', @AUTHOR)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('application_status')) {
    function application_status()
    {
        if (set_active()['status'] == true) {
            return "Application Registered by " . @AUTHOR;
        }
    }
}
