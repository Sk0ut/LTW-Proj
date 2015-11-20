<?php
// Check parameters
if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['remember'])) {
    $data = [ "login" => "fail" ];
    header('Content-Type: application/json');
    echo json_encode($data);
    return;
}

$username = $_POST['username'];
$password = $_POST['password'];
$remember = $_POST['remember'];

// Validate login
$validLogin = validLogin($username, $password);
if(!validLogin) {
    $data = [ "login" => "fail" ];
    header('Content-Type: application/json');
    echo json_encode($data);
    return;
}

// Update session
$sessionId = generateSessionId();
updateSessionId($username, $sessionId);
$_SESSION['username'] = $username;
$_SESSION['sessionId'] = $sessionId;

// Cookies
$expireTimeCookie = 0;
if($remember)
    $expireTimeCookie = 2147483647;
else
    $expireTimeCookie = 30 * 60 * 60;
setcookie('username', $username, $expireTimeCookie);
setcookie('session', $sessionId, $expireTimeCookie);

header('Location: ../userpage.php');
?>
