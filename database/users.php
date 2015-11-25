<?php

require_once('utils.php');

function getUserInfoFromName($username) {
    $query = "SELECT * FROM Users WHERE username = ?";
    $params = [ $username ];
    $types = [ PDO::PARAM_STR ];
    $result = executeQuery($query, $params, $types);
    return $result;
}

function getUserInfoFromEmail($email) {
    $query = "SELECT * FROM Users WHERE email = ?";
    $params = [ $email ];
    $types = [ PDO::PARAM_STR ];
    $result = executeQuery($query, $params, $types);
    return $result;
}

/**
 * Check if a user exists
 * @param username username to check if exists
 * @return true if exists, false otherwise
 */
function userExists($username) {
    $result = getUserInfoFromName($username);
    if($result == NULL)
        return false;
    return count($result) > 0;
}

/**
 * Check if a login is valid. First checks if a username actually
 * exists, if so compare the plain password with the hashed one
 * @param username username to check login
 * @param password password of the username to check
 * @return true if is a valid login combination, false otherwise
 */
function isValidLogin($username, $password) {
    $query = "SELECT password FROM Users WHERE username = ?";
    $params = [ $username ];
    $types = [ PDO::PARAM_STR ];
    $result = executeQuery($query, $params, $types);
    if($result == NULL)
        return false;

    return password_verify($password, $result[0]['password']);
}

/**
 * Create a new username on the events manager
 * @param username username of the new user
 * @param password password of the user
 * @param email email of the user
 * @return true if was successfull, false otherwise
 */
function createUser($username, $password, $email) {
    $query = "INSERT INTO Users(username, password, email) VALUES (?, ?, ?)";
    $params = [ $username, $password, $email ];
    $types = [ PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR ];
    $result = executeQuery($query, $params, $types);
    return $result > 0;
}

/**
 * Update the user's token
 * @param username username to be updated
 * @param token new token of the user
 * @return true if successfull, false otherwise
 */
function updateToken($username, $token) {
    $query = "UPDATE Users SET token = ? WHERE username = ?";
    $params = [ $token, $username ];
    $types = [ PDO::PARAM_STR, PDO::PARAM_STR ];
    $result = executeQuery($query, $params, $types);
    return $result > 0;
}

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
