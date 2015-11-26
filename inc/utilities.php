<?php
require_once 'database.php';
require_once 'user.php';
require_once 'security.php';

/**
 * Create a new username on the events manager
 * @param username username of the new user
 * @param password password of the user
 * @param email email of the user
 * @return true if was successfull, false otherwise
 */
function createNewUser($username, $password, $email) {
    global $database;

    $query = "INSERT INTO Users(username, password, email) VALUES (?, ?, ?)";
    $params = [ $username, $password, $email ];
    $types = [ PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR ];
    $result = $database->executeUpdate($query, $params, $types);
    return $result > 0;
}

/**
 * Get the user that is currently navigating
 * the website
 * @return current user or NULL
 */
function getCurrentUser() {
    // Check cookies
    $cookies = [ 'username', 'token' ];
    foreach ($cookies as $cookie) {
        if(isset($_COOKIE[$cookie])) {
            $cookies[$cookie] = $_COOKIE[$cookie];
            continue;
        }

        return NULL;
    }

    $user = getUserFromUsername($cookies['username']);
    if($user->tokenMatch($cookies['token']))
        return $user;
    return NULL;
}

/**
 * Get a user from his username
 * @param username username of the user
 * @return user with that username or NULL
 */
function getUserFromUsername($username) {
    global $database;

    $query = "SELECT * FROM Users WHERE username = ?";
    $params = [ $username ];
    $types = [ PDO::PARAM_STR ];
    $result = $database->executeQuery($query, $params, $types);

    if(!$result || count($result) <= 0)
        return NULL;

    return new User($result[0]['username'], $result[0]['password'], $result[0]['email'], $result[0]['token'], $result[0]['ipAddress']);
}

/**
 * Get a user from his email
 * @param email email of the user
 * @return user with that email or NULL
 */
function getUserFromEmail($email) {
    global $database;

    $query = "SELECT * FROM Users WHERE email = ?";
    $params = [ $email ];
    $types = [ PDO::PARAM_STR ];
    $result = $database->executeQuery($query, $params, $types);

    if(!$result || count($result) <= 0)
        return NULL;

    return new User($result[0]['username'], $result[0]['password'], $result[0]['email'], $result[0]['token'], $result[0]['ipAddress']);
}

/**
 * Check if a login is valid
 * @param username username to check login
 * @param password password of the username to check
 * @return true if is a valid login combination, false otherwise
 */
function isValidLogin($username, $password) {
    $user = getUserFromUsername($username);
    if($user == NULL)
        return false;
    return $user->passwordMatch($password);
}

/**
 * Check if a token is valid
 * @param username username to check the token
 * @param token token of the current user
 * @return true if is a valid token, false otherwise
 */
function isValidToken($username, $token) {
    $user = getUserFromUsername($username);
    if($user == NULL)
        return false;
    return $user->tokenMatch($token);
}

/**
 * Check if a user with a username exists
 * @param username username to check if has user associated
 * @return true if a user exists with that username
 */
function usernameExists($username) {
    return getUserFromUsername($username) != NULL;
}

/**
 * Check if a user with a email exists
 * @param email email to check if has user associated
 * @return true if a user exists with that email
 */
function emailExists($email) {
    return getUserFromEmail($email) != NULL;
}

/**
 * Regenerate a user's login token and save the ip address associated
 * with that token
 * @param username username to be regen
 * @return new token of the user, false otherwise
 */
function regenToken($username) {
    $token = generateToken(256);

    global $database;

    $query = "UPDATE Users SET token = ?, ipAddress = ? WHERE username = ?";
    $params = [ $token, $_SERVER['REMOTE_ADDR'], $username ];
    $types = [ PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR ];
    $result = $database->executeUpdate($query, $params, $types);
    if($result <= 0)
        return false;
    return $token;
}

?>
