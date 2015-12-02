<?php

require_once("database.php");

/**
 * User object
 */
class User {

    /**
     * Id of the user
     */
    private $_id;

    /**
     * Username of the user
     */
    private $_username;

    /**
     * Password of the user
     */
    private $_password;

    /**
     * Email of the user
     */
    private $_email;

    /**
     * Current login token of the user
     */
    private $_token;

    /**
     * IP Address of the user on last login
     */
    private $_ipAddress;

    /**
     *
     */
    private $_ownerEvents;

    /**
     *
     */
    private $_registeredEvents;

    /**
     * Constructor of User
     * @param id id of the user
     * @param username username of the user
     * @param password password of the user
     * @param email email of the user
     * @param token token of the user
     * @param ipAddress ip address of the user
     */
    public function __construct($id, $username, $password, $email, $token, $ipAddress) {
        $this->_id = $id;
        $this->_username = $username;
        $this->_password = $password;
        $this->_email = $email;
        $this->_token = $token;
        $this->_ipAddress = $ipAddress;
        $this->_ownevents = array();
        $this->_registeredEvents = array();
    }

    public static function find($id){
        $database = Database::getInstance();
        $data = $database->executeQuery("SELECT * FROM Users WHERE id = ?",[$id],[PDO::PARAM_STR])[0];
        $user = new User($data["id"], $data["username"], $data["password"], $data["email"], $data["token"], $data["ipAddress"]);

        $user->setRegisteredEvents($database->executeQuery("SELECT eventId FROM UserEvents WHERE userId = ?", [$id], [PDO::PARAM_STR]));
        $user->setOwnerEvents($ownEvents = $database->executeQuery("SELECT id FROM Events WHERE ownerId = ?", [$id], [PDO::PARAM_STR]));

        return $user;
    }

    /**
     *
     */
    public function setOwnerEvents($ownEvents){
        return $this->_ownerEvents;
    }

    /**
     *
     */
    public function setRegisteredEvents($registeredEvents){
        return $this->_registeredEvents;
    }

        /**
     *
     */
    public function getOwnerEvents(){
        return $this->_ownerEvents;
    }

    /**
     *
     */
    public function getRegisteredEvents(){
        return $this->_registeredEvents;
    }




    /**
     * Get the id of the user
     * @return id of the user
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Get the username of the user
     * @return username of the user
     */
    public function getUsername() {
        return $this->_username;
    }

    /**
     * Get the password of the user
     * @return password of the user
     */
    public function getPassword() {
        return $this->_password;
    }

    /**
     * Get the email of the user
     * @return email of the user
     */
    public function getEmail() {
        return $this->_email;
    }

    /**
     * Get the token of the user
     * @return token of the user
     */
    public function getToken() {
        return $this->_token;
    }

    /**
     * Get the ip address of the user
     * @return ip address of the user
     */
    public function getIpAddress() {
        return $this->_ipAddress;
    }

    /**
     * Set the token of the user
     * @param token new token of the user
     */
    public function setToken($token) {
        $this->_token = $token;
    }

    /**
     * Check if a password matches the user's password
     * @param password password to be checked
     * @return true if matches, false otherwise
     */
    public function passwordMatch($password) {
        return password_verify($password, $this->_password);
    }

    /**
     * Check if a token matches the user's token and
     * if the ip address is the same
     * @param token token to be checked
     * @return true if matches, false otherwise
     */
    public function tokenMatch($token) {
        return $this->_token === $token &&
                $this->_ipAddress === $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Convert a user to string
     */
    public function __toString() {
        return json_encode(
            [
                $this->_username,
                $this->_password,
                $this->_email,
                $this->_token,
                $this->_ipAddress
            ]);
    }
}

?>
