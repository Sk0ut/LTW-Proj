<?php
require_once __DIR__ . "/../core/controller.php";

class LoginCtrl extends Controller {
    /**
     * Index function. Display the login / register form.
     */
    public function index() {
        require_once(__DIR__ . '/../../library/headerSession.php');
        if($user == NULL) {
            $this->view("login_view");
        } else {
            $this->view("userpage_view");
        }
    }

    /**
     * Check if a login is valid
     * @return JSON response
     */
    public function validateLogin($variables) {
        require_once __DIR__ . "/../models/userDAO.php";

        // Need error responses
        $key = "login";
        $missing_params = "missing_params";
        $fail_login = "fail";
        $success_login = "success";

        // Check parameters
        if(count($variables) != 3) {
            $this->printResponse($key, $missing_params);
            return false;
        }
        $params = ['username' => $variables[0], 'password' => $variables[1], 'remember' => $variables[2]];

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
    public function validateRegister($variables) {
        require_once __DIR__ . "/../models/userDAO.php";

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
        if(count($variables) != 4) {
            $this->printResponse($key, $missing_params);
            return false;
        }
        $params = ['username' => $variables[0], 'email' => $variables[1], 'password' => $variables[2], 'remember' => $variables[3]];

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
        require_once __DIR__ . "/../models/userDAO.php";

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
