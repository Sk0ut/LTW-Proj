<?php

/**
 * Generate a random and secure number between a minimum and a maximum
 * @param min   minumum value
 * @param max   maximum value
 * @author http://us1.php.net/manual/en/function.openssl-random-pseudo-bytes.php#104322
 */
function cryptoRandomSecure($min, $max) {
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}

/**
 * Generate a secure token
 * @param length length of the token
 * @author http://us1.php.net/manual/en/function.openssl-random-pseudo-bytes.php#104322
 */
function generateToken($length) {
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet) - 1;
    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[cryptoRandomSecure(0, $max)];
    }

    return $token;
}

?>
