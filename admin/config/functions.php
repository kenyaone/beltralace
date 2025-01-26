<?php

function encrypt_data($string)
{
    $cipher = 'AES-128-ECB';
    $secret = SECRET_KEY;
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = substr($string, 0, $iv_length);
    return base64_encode(openssl_encrypt($string, $cipher, $secret, 0, $iv));
}

function decrypt_data($string)
{
    $cipher = 'AES-128-ECB';
    $secret = SECRET_KEY;
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = substr($string, 0, $iv_length);
    return openssl_decrypt(base64_decode($string), $cipher, $secret, 0, $iv);
}
