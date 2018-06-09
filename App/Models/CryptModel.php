<?php
namespace App\Models;

class CryptModel
{

    public static function crypt($string, $action = 'e')
    {
        $secret_key = 'secretWord';
        $secret_iv = 'my_simple_secret_iv';

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'e') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        } else if ($action == 'd') {
            $output = openssl_decrypt($string, $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}
