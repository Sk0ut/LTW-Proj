<?php

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
     * Current login token for the user
     */
    private $_tokens;

    /**
     * Constructor of User
     * @param id id of the user
     * @param username username of the user
     * @param password password of the user
     * @param email email of the user
     * @param tokens tokens of the user
     */
    public function __construct($id, $username, $password, $email, $tokens) {
        $this->_id = $id;
        $this->_username = $username;
        $this->_password = $password;
        $this->_email = $email;
        $this->_tokens = $tokens;
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
     * Get the ip address of the user
     * @return ip address of the user
     */
    public function getIpAddress() {
        return $this->_ipAddress;
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
     * Convert a user to string
     */
    public function __toString() {
        return json_encode(
            [
                $this->_username,
                $this->_password,
                $this->_email,
                $this->_tokens,
            ]);
    }
}

?>
