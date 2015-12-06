<?php

require_once(__DIR__ . '/../../library/bcrypt.php');
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
     * Constructor of User
     * @param id id of the user
     * @param username username of the user
     * @param password password of the user
     * @param email email of the user
     */
    public function __construct($id, $username, $password, $email) {
        $this->_id = $id;
        $this->_username = $username;
        $this->_password = $password;
        $this->_email = $email;
    }
	
	/**
	 * method that retrieves the object attributes as an associative array
	 * @return class attributes as associative array
	 */
	public function expose() {
		return get_object_vars($this);
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
     * Check if a password matches the user's password
     * @param password password to be checked
     * @return true if matches, false otherwise
     */
    public function passwordMatch($password) {
        return Bcrypt::checkPassword($password, $this->_password);
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
            ]);
    }
}

?>
