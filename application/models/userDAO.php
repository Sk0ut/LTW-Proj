<?php
require_once __DIR__ . "/database.php";
require_once __DIR__ . "/user.php";
require_once __DIR__ . "/../../library/security.php";

/**
 * User Database Access Object
 */
class UserDAO {

    /**
     * Create a new username on the events manager
     * @param username username of the new user
     * @param password password of the user
     * @param email email of the user
     * @return true if was successfull, false otherwise
     */
    public static function createNewUser($username, $password, $email) {
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
    public static function getCurrentUser() {
        // Check cookies
        $cookies = [ 'em_username', 'em_token', 'em_remember' ];
        foreach ($cookies as $cookie) {
            if(isset($_COOKIE[$cookie])) {
                $cookies[$cookie] = $_COOKIE[$cookie];
                continue;
            }

            return NULL;
        }

        return UserDAO::validateToken($cookies['em_username'], $cookies['em_token']);
    }

    /**
     * Get the foot print of a user
     * @param userId id of the user to get the footprint
     * @param token token associated with that footprint
     * @return footprint with that user and token
     */
    public static function getFootPrint($userId, $token) {
        $database = Database::getInstance();

        $query = "SELECT footprint FROM UserSessions WHERE userId = ? AND token = ?";
        $params = [ $userId, $token ];
        $types = [ PDO::PARAM_INT, PDO::PARAM_STR ];
        $result = $database->executeQuery($query, $params, $types);

        if(!$result || count($result) <= 0)
            return NULL;

        return $result[0]['footprint'];
    }

    /**
     * Get a user from his id
     * @param id id of the user
     * @return user with that id or NULL
     */
    public static function getUserFromId($id) {
        $database = Database::getInstance();

        $query = "SELECT * FROM Users WHERE id = ?";
        $params = [ $id ];
        $types = [ PDO::PARAM_INT ];
        $result = $database->executeQuery($query, $params, $types);

        if(!$result || count($result) <= 0)
            return NULL;

        return new User($result[0]['id'], $result[0]['username'], $result[0]['password'], $result[0]['email']);
    }

    /**
     * Get a user from his username
     * @param username username of the user
     * @return user with that username or NULL
     */
    public static function getUserFromUsername($username) {
        $database = Database::getInstance();

        $query = "SELECT * FROM Users WHERE username = ?";
        $params = [ $username ];
        $types = [ PDO::PARAM_STR ];
        $result = $database->executeQuery($query, $params, $types);

        if(!$result || count($result) <= 0)
            return NULL;

        return new User($result[0]['id'], $result[0]['username'], $result[0]['password'], $result[0]['email']);
    }

    /**
     * Get a user from his email
     * @param email email of the user
     * @return user with that email or NULL
     */
    public static function getUserFromEmail($email) {
        $database = Database::getInstance();

        $query = "SELECT * FROM Users WHERE email = ?";
        $params = [ $email ];
        $types = [ PDO::PARAM_STR ];
        $result = $database->executeQuery($query, $params, $types);

        if(!$result || count($result) <= 0)
            return NULL;

        return new User($result[0]['id'], $result[0]['username'], $result[0]['password'], $result[0]['email']);
    }

    /**
     * Check if a login is valid
     * @param username username to check login
     * @param password password of the username to check
     * @return true if is a valid login combination, false otherwise
     */
    public static function isValidLogin($username, $password) {
        $user = UserDAO::getUserFromUsername($username);
        if($user == NULL)
            return false;
        return $user->passwordMatch($password);
    }

    /**
     * Validate a token
     * @param username username to check the token
     * @param token token of the current user
     * @return user with that username and token
     */
    public static function validateToken($username, $token) {
        $user = UserDAO::getUserFromUsername($username);
        if($user == NULL)
            return NULL;

        if(!isset($_SERVER['HTTP_USER_AGENT']) || !isset($_SERVER['REMOTE_ADDR']))
            return NULL;

        $footprint = UserDAO::getFootPrint($user->getId(), $token);
        if(!password_verify($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'], $footprint))
            return NULL;
        return $user;
    }

    /**
     * Check if a user with a username exists
     * @param username username to check if has user associated
     * @return true if a user exists with that username
     */
    public static function usernameExists($username) {
        return UserDAO::getUserFromUsername($username) != NULL;
    }

    /**
     * Check if a user with a email exists
     * @param email email to check if has user associated
     * @return true if a user exists with that email
     */
    public static function emailExists($email) {
        return UserDAO::getUserFromEmail($email) != NULL;
    }

    /**
     * Regenerate a user's login token and save the ip address associated
     * with that token
     * @param username username to be regen
     * @param remember true to remember the token
     * @return token if successful, false otherwise
     */
    public static function regenToken($username, $remember) {
        // Needed variables
        $user = UserDAO::getUserFromUsername($username);
        if($user == NULL)
            return false;
        if(!isset($_SERVER['HTTP_USER_AGENT']) || !isset($_SERVER['REMOTE_ADDR']))
            return false;
        $userId = $user->getId();
        $footprint = password_hash($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'], PASSWORD_BCRYPT);

        // Delete previous token (if exists)
        if(isset($_COOKIE['em_token']))
            UserDAO::deleteToken($username, $_COOKIE['em_token']);

        // Generate new token
        $token = generateToken(256);

        // Save in the database
        $database = Database::getInstance();
        $query = "INSERT INTO UserSessions(userId, footprint, token) VALUES (?, ?, ?)";
        $params = [ $userId, $footprint, $token ];
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
    public static function deleteToken($username, $token) {
        $user = UserDAO::getUserFromUsername($username);
        if($user == NULL)
            return false;

        // Delete from the database
        $database = Database::getInstance();
        $query = "DELETE FROM UserSessions WHERE userId = ? AND token = ?";
        $params = [ $user->getId(), $token ];
        $types = [ PDO::PARAM_INT, PDO::PARAM_STR ];
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
	
		public static function searchUsername($username) {
		$database = Database::getInstance();

		$query = "SELECT id FROM Users WHERE username LIKE ?";
		$params = ['%' . $username . '%'];
		$types = [PDO::PARAM_STR];

		$result = $database->executeQuery($query, $params, $types);
		$users = [];

		foreach($result as $row){
			$user = self::getUserFromId($row['id']);
			if ($user == NULL)
				return NULL;
			$users[] = $user;
		}

		return $users;
	}
}

?>
