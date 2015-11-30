<?php

/**
 * Print a response
 * @param key key of the response
 * @param value value of the response
 */
function printResponse($key, $value) {
    $data = [$key => $value];
    header('Content-Type: application/json');
    echo json_encode($data);
}

/**
 * Fill the params needed to check and process in the action
 * @param params array with expected parameters name
 * @return true if successfull, false otherwise
 */
function fillParameters(&$params) {
    foreach ($params as $param => $value)
        if(isset($_POST[$param])) $params[$param] = $_POST[$param];
        else return false;
    return true;
}

/**
 * Update the token id of the username
 * @param username username to be updated
 * @param token new token value
 */
function updateToken($username, $token, $remember) {
    // Remove token cookie
    if($token == NULL) {
        unset($_COOKIE['em_username']);
        unset($_COOKIE['em_token']);
        $expireTimeCookie = time() - 3600; // Back in time so cookie gets deleted
    }
    // Create token cookie
    else {
        // Cookies
        if($remember == "true")
            $expireTimeCookie = 2147483647;
        else
            $expireTimeCookie = time() + 30 * 60; // Expire in 30 minutes
    }
    setcookie('em_username', $username, $expireTimeCookie, "/", false);
    setcookie('em_token', $token, $expireTimeCookie, "/", false);
}

?>
