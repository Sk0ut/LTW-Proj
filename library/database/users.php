<?php
require_once __DIR__ . "/../../application/models/database.php";
require_once __DIR__ . "/../../application/models/user.php";
require_once __DIR__ . "/../security.php";

/**
 * Create a new username on the events manager
 * @param username username of the new user
 * @param password password of the user
 * @param email email of the user
 * @return true if was successfull, false otherwise
 */
function createNewUser($username, $password, $email) {
    $database = Database::getInstance();

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
    $cookies = [ 'em_username', 'em_token', 'em_remember' ];
    foreach ($cookies as $cookie) {
        if(isset($_COOKIE[$cookie])) {
            $cookies[$cookie] = $_COOKIE[$cookie];
            continue;
        }

        return NULL;
    }

    $user = getUserFromUsername($cookies['em_username']);
    if($user->tokenMatch($cookies['em_token']))
        return $user;
    return NULL;
}

/**
 * Get a user from his id
 * @param id id of the user
 * @return user with that id or NULL
 */
function getUserFromId($id) {
    $database = Database::getInstance();

    $query = "SELECT * FROM Users WHERE id = ?";
    $params = [ $id ];
    $types = [ PDO::PARAM_INT ];
    $result = $database->executeQuery($query, $params, $types);

    if(!$result || count($result) <= 0)
        return NULL;

    return new User($result[0]['id'], $result[0]['username'], $result[0]['password'], $result[0]['email'], $result[0]['token'], $result[0]['ipAddress']);
}

/**
 * Get a user from his username
 * @param username username of the user
 * @return user with that username or NULL
 */
function getUserFromUsername($username) {
    $database = Database::getInstance();

    $query = "SELECT * FROM Users WHERE username = ?";
    $params = [ $username ];
    $types = [ PDO::PARAM_STR ];
    $result = $database->executeQuery($query, $params, $types);

    if(!$result || count($result) <= 0)
        return NULL;

    return new User($result[0]['id'], $result[0]['username'], $result[0]['password'], $result[0]['email'], $result[0]['token'], $result[0]['ipAddress']);
}

/**
 * Get a user from his email
 * @param email email of the user
 * @return user with that email or NULL
 */
function getUserFromEmail($email) {
    $database = Database::getInstance();

    $query = "SELECT * FROM Users WHERE email = ?";
    $params = [ $email ];
    $types = [ PDO::PARAM_STR ];
    $result = $database->executeQuery($query, $params, $types);

    if(!$result || count($result) <= 0)
        return NULL;

    return new User($result[0]['id'], $result[0]['username'], $result[0]['password'], $result[0]['email'], $result[0]['token'], $result[0]['ipAddress']);
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
 * @param remember true to remember the token
 * @return token if successful, false otherwise
 */
function regenToken($username, $remember) {
    $token = generateToken(256);

    // Save in the database
    $database = Database::getInstance();
    $query = "UPDATE Users SET token = ?, ipAddress = ? WHERE username = ?";
    $params = [ $token, $_SERVER['REMOTE_ADDR'], $username ];
    $types = [ PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR ];
    $result = $database->executeUpdate($query, $params, $types);
    if($result <= 0)
        return false;

    // Create the cookies
    if($remember == "true")
        $expireTimeCookie = 2147483647;
    else
        $expireTimeCookie = time() + 30 * 60; // Expire in 30 minutes
    setcookie('em_username', $username, $expireTimeCookie, "/", $_SERVER['SERVER_NAME'], false, true);
    setcookie('em_token', $token, $expireTimeCookie, "/", $_SERVER['SERVER_NAME'], false, true);
    setcookie('em_remember', $remember, $expireTimeCookie, "/", $_SERVER['SERVER_NAME'], false, true);

    return $token;
}

/**
 * Delete the token of a user
 * @param username username to delete the token
 * @return true if successful, false otherwise
 */
function deleteToken($username) {
    // Delete from the database
    $database = Database::getInstance();
    $query = "UPDATE Users SET token = ?, ipAddress = ? WHERE username = ?";
    $params = [ NULL, NULL, $username ];
    $types = [ PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR ];
    $result = $database->executeUpdate($query, $params, $types);
    if($result <= 0)
        return false;

    // Delete the cookies
    $expireTimeCookie = time() - 3600; // Past date
    unset($_COOKIE['em_username']);
    unset($_COOKIE['em_token']);
    unset($_COOKIE['em_remember']);
    setcookie('em_username', NULL, $expireTimeCookie, "/", $_SERVER['SERVER_NAME'], false, true);
    setcookie('em_token', NULL, $expireTimeCookie, "/", $_SERVER['SERVER_NAME'], false, true);
    setcookie('em_remember', NULL, $expireTimeCookie, "/", $_SERVER['SERVER_NAME'], false, true);

    return true;
}

?>
