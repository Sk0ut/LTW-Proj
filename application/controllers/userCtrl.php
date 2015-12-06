<?php
require_once __DIR__ . "/../core/controller.php";
require_once __DIR__ . "/../models/userDAO.php";
require_once __DIR__ . "/../models/eventDAO.php";

class UserCtrl extends Controller {
	public function index() {
		require_once(__DIR__ . '/../../library/headerSession.php');
        if(is_null($user)) {
			$this->view("error_view");
			return;
		}
		
		if(!isset($_GET['id'])) {
			$this->model("error_view");
			return;
		}
        
		$user = UserDAO::getUserFromId($id);
        $ownedEvents = EventDAO::getOwnerEvents($id);
        $userEvents = EventDAO::getRegisteredEvents($id, true);
        $this->view("userpage_view", ['user' => $user, 'ownedEvents' => $ownedEvents, 'userEvents' => $userEvents]);
    }
	
	/**
     * Change a user password
     */
    public function changePassword() {
        $key = "change_password";
        $missing_params = "missing_params";
		$no_user = "user not logged";
		$fail_change_password = "fail";
        $success_change_password = "success";

		require_once(__DIR__ . '/../../library/headerSession.php');
        if($user == NULL) {
			$this->printResponse($key, $no_user);
            return;
		}
		
        // Check parameters
        $params = ['password' => ''];
        if(!$this->fillGetParameters($params)) {
            $this->printResponse($key, $missing_params);
            return;
        }

      
        // change the password
        $newPassword = UserDAO::changePassword($user, $params['password']);
        if(!$newPassword) {
            $this->printResponse($key, $fail_change_password);
            return;
        }

        $this->printResponse($key, $success_change_password);
    }
	
	/**
     * Change a user photo
     */
    public function changePhoto() {
        $key = "change_photo";
        $missing_params = "missing_params";
		$no_user = "user not logged";
		$fail_change_photo = "fail";
        $success_change_photo = "success";

		require_once(__DIR__ . '/../../library/headerSession.php');
        if($user == NULL) {
			$this->printResponse($key, $no_user);
            return;
		}
		
		// Check file
		if(!isset($_FILES['image'])) {
			$this->printResponse($key, $missing_params);
			return;
		}
		
		// Save the file
		$photo = time() . $_FILES['image']['name'];
		$photoPath = __DIR__ . "/../../public/img/uploaded/" . $photo;
		if (!move_uploaded_file( $_FILES['image']['tmp_name'], $photoPath)) {
			$this->printResponse($key, $fail_change_photo);
			return;
		}
      
        // change the photo
        if(!UserDAO::changePhoto($user, $photo)) {
            $this->printResponse($key, $fail_change_photo);
            return;
        }

        $this->printResponse($key, $success_change_photo);
    }
	
	/**
     * Fill the expected post parameters
     * @param params array map with params
     * @return true if all the needed variables are set, false otherwise
     */
    private function fillPostParameters(&$params) {
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
    private function printResponse($key, $value) {
        $data = [$key => $value];
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
