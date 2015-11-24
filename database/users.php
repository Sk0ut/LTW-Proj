<?php
function getUserInfoFromName($username) {
	global $db;
	$stmt = $db->prepare('SELECT * FROM Users WHERE username = :username');
	$stmt->bindParam(":username", $username, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt->fetch();
}

function getUserInfoFromEmail($email) {
	global $db;
	$stmt = $db->prepare('SELECT * FROM Users WHERE email = :email');
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt->fetch();
}

function validLogin($username, $password) {
	global $db;
	$stmt = $db->prepare("SELECT COUNT(*) AS count FROM Users WHERE username = :username AND password = :password");
	$stmt->bindParam(":username", $username, PDO::PARAM_STR);
	$stmt->bindParam(":password", $password, PDO::PARAM_STR);
	$stmt->execute();
	
	$result = $stmt->fetch();
	
	return $result['count'] == 1;
}

function createUser($username, $password, $email) {
	global $db;
	
	$stmt = $db->prepare("INSERT INTO Users (username, password, email) VALUES (:username, :password, :email)");
	$stmt->bindParam(":username", $username, PDO::PARAM_STR);
	$stmt->bindParam(":password", $password, PDO::PARAM_STR);
	$stmt->bindParam(":email", $email, PDO::PARAM_STR);
	return $stmt->execute();
}
?>