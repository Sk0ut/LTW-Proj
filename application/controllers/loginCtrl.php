<?php
require_once __DIR__ . "/../core/controller.php";
require_once __DIR__ . "/userCtrl.php";
require_once __DIR__ . "/../models/eventDAO.php";
require_once __DIR__ . "/../models/userDAO.php";

class LoginCtrl extends Controller {
    /**
     * Index function. Display the login / register form.
     */
    public function index() {
        require_once(__DIR__ . '/../../library/headerSession.php');
        if($user == NULL) {
            $this->loginIndex();
        } else {
            $this->userPageIndex($user);
        }
    }

    /**
     * Login index page
     */
    private function loginIndex() {
        $this->view("login_view");
    }

    /**
     * User page index
     * @param user user to display user page
     */
    private function userPageIndex($user) {

        $ownedEvents = EventDAO::getOwnerEvents($user->getId());
        $userEvents = EventDAO::getRegisteredEvents($user->getId());
        $this->view("homepage_view", ['user' => $user, 'ownedEvents' => $ownedEvents, 'userEvents' => $userEvents]);
    }

    /**
     * Check if a login is valid
     * @return JSON response
     */
    public function validateLogin() {
        // Need error responses
        $key = "login";
        $missing_params = "missing_params";
        $fail_login = "fail";
        $success_login = "success";

        // Check parameters
        $params = ['username' => '', 'password' => '', 'remember' => ''];
        if(!$this->fillPostParameters($params)) {
            $this->printResponse($key, $missing_params);
            return false;
        }

        // Convert email to username
        if(filter_var($params['username'], FILTER_VALIDATE_EMAIL)) {
            $user = getUserFromEmail($params['username']);
            if($user == NULL) {
                $this->printResponse($key, $fail_login);
                return;
            }
            $params['username'] = $user->getUsername();
        }

        // Validate login
        if(!UserDAO::isValidLogin($params['username'], $params['password'])) {
            $this->printResponse($key, $fail_login);
            return;
        }

        // Update token
        $token = UserDAO::regenToken($params['username'], $params['remember']);
        if(!$token) {
            $this->printResponse($key, $fail_login);
            return;
        }

        $this->printResponse($key, $success_login);
    }

    /**
     * Validate the register of a user
     * @param variables variables sent by the user
     * @return response of valid register
     */
    public function validateRegister() {
        // Need error responses
        $key = "register";
        $missing_params = "missing_params";
        $taken_user = "taken_user";
        $taken_email = "taken_email";
        $invalid_username = "invalid_username";
        $invalid_email = "invalid_email";
        $invalid_password = "invalid_password";
        $fail_register = "fail";
        $success_register = "success";

        // Check parameters
        $params = ['username' => '', 'email' => '', 'password' => ''];
        if(!$this->fillPostParameters($params)) {
            $this->printResponse($key, $missing_params);
            return false;
        }

        // Validate parameters
        if(strlen($params['username']) < 4 || strlen($params['username']) > 15) {
            $this->printResponse($key, $invalid_username);
            return;
        }
        if(UserDAO::usernameExists($params['username'])) {
            $this->printResponse($key, $taken_user);
            return;
        }
        if(!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
            $this->printResponse($key, $invalid_email);
            return;
        }
        if(UserDAO::emailExists($params['email'])) {
            $this->printResponse($key, $taken_email);
            return;
        }
        if(strlen($params['password']) < 4) {
            $this->printResponse($key, $invalid_password);
            return;
        }

        // Create register
        $params['password'] = password_hash($params['password'], PASSWORD_BCRYPT);
        if(!UserDAO::createNewUser($params['username'], $params['password'], $params['email'])) {
            $this->printResponse($key, $fail_register);
            return;
        }

        // Update token
        $token = UserDAO::regenToken($params['username'], $params['remember']);
        if(!$token) {
            $this->printResponse($key, $fail_register);
            return;
        }

        $this->printResponse($key, $success_register);
    }

    /**
     * Validate a user logout
     */
    public function validateLogout() {
        // Check if is logged in
        $user = UserDAO::getCurrentUser();
        if($user == NULL) {
            $this->printResponse("logout", "not_logged");
            return;
        }

        // Delete token
        UserDAO::deleteToken($user->getUsername(), $_COOKIE['em_token']);

        $this->printResponse("logout", "success");
    }

    /**
     * Send an email to the user that lost
     * his password
     */
    public function forgotPassword() {

    }

    /**
     * Fill the expected post parameters
     * @param params array map with params
     * @return true if all the needed variables are set, false otherwise
     */
    public function fillPostParameters(&$params) {
        foreach($params as $key => $param) {
            if(!isset($_POST[$key]))
                return false;
            $params[$key] = $_POST[$key];
        }
        return true;
    }

    /**
     * Print a response
     * @param key key of the response
     * @param value value of the response
     */
    public function printResponse($key, $value) {
        $data = [$key => $value];
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
