<?php

/**
 * User object
 */
class User {
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
     * Constructor of User
     * @param username username of the user
     * @param password password of the user
     * @param email email of the user
     * @param token token of the user
     */
    public function __construct($username, $password, $email, $token) {
        $this->_username = $username;
        $this->_password = $password;
        $this->_email = $email;
        $this->_token = $token;
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
     * Check if a password matches the user's password
     * @param password password of the user
     * @return true if matches, false otherwise
     */
    public function passwordMatch($password) {
        return password_verify($password, $this->_password);
    }
}

?>
