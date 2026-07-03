<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// Required database columns on users table:
//   two_factor_enabled TINYINT(1) DEFAULT 0
//   two_factor_secret  VARCHAR(64) DEFAULT NULL
function totp_generate_secret($length = 16)
{
    $validChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $secret = '';

    for ($i = 0; $i < $length; $i++) {
        $secret .= $validChars[random_int(0, 31)];
    }

    return $secret;
}

function totp_base32_decode($secret)
{
    if (empty($secret)) {
        return '';
    }

    $secret = strtoupper($secret);
    $base32chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $base32charsFlipped = array_flip(str_split($base32chars));

    $paddingCharCount = substr_count($secret, '=');
    $allowedValues = [6, 4, 3, 1, 0];
    if (!in_array($paddingCharCount, $allowedValues)) {
        return false;
    }

    $secret = str_replace('=', '', $secret);
    $secretLength = strlen($secret);
    $binaryString = '';

    for ($i = 0; $i < $secretLength; $i++) {
        $currentChar = $secret[$i];
        if (!isset($base32charsFlipped[$currentChar])) {
            return false;
        }

        $binaryString .= str_pad(decbin($base32charsFlipped[$currentChar]), 5, '0', STR_PAD_LEFT);
    }

    $eightBitBytes = str_split($binaryString, 8);
    $decoded = '';

    foreach ($eightBitBytes as $byte) {
        if (strlen($byte) === 8) {
            $decoded .= chr(bindec($byte));
        }
    }

    return $decoded;
}

function totp_get_code($secret, $timeSlice = null)
{
    if ($timeSlice === null) {
        $timeSlice = floor(time() / 30);
    }

    $secretKey = totp_base32_decode($secret);
    if ($secretKey === false) {
        return false;
    }

    $time = pack('N*', 0) . pack('N*', $timeSlice);
    $hm = hash_hmac('sha1', $time, $secretKey, true);
    $offset = ord(substr($hm, -1)) & 0x0F;
    $hash = substr($hm, $offset, 4);
    $value = unpack('N', $hash)[1] & 0x7FFFFFFF;

    return str_pad($value % 1000000, 6, '0', STR_PAD_LEFT);
}

function totp_verify_code($secret, $code, $window = 1)
{
    $code = trim($code);
    if (strlen($code) !== 6 || !ctype_digit($code)) {
        return false;
    }

    $timeSlice = floor(time() / 30);

    for ($i = -$window; $i <= $window; $i++) {
        $calculatedCode = totp_get_code($secret, $timeSlice + $i);
        if ($calculatedCode === $code) {
            return true;
        }
    }

    return false;
}

function totp_uri($label, $issuer, $secret)
{
    $label = rawurlencode($issuer . ':' . $label);
    $issuer = rawurlencode($issuer);
    $secret = rawurlencode($secret);

    return "otpauth://totp/{$label}?secret={$secret}&issuer={$issuer}&algorithm=SHA1&digits=6&period=30";
}

function totp_qr_url($label, $issuer, $secret)
{
    $uri = totp_uri($label, $issuer, $secret);
    return 'https://chart.googleapis.com/chart?chs=250x250&chld=M|0&cht=qr&chl=' . rawurlencode($uri);
}
