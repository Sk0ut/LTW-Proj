<?php
require_once __DIR__ . "/../core/controller.php";
require_once __DIR__ . "/../models/eventDAO.php";
require_once __DIR__ . "/../models/event.php";
require_once __DIR__ . "/../models/userDAO.php";

class EventCtrl extends Controller {
	public function index() {
		if (!isset($_GET['id'])) {
			$this->view("error_view");
			return;
		}
		$id = $_GET['id'];
		$event = EventDAO::getById($id);
		if ($event == NULL) {
			$this->view("error_view");
			return;
		}
		$owner = UserDAO::getUserFromId($event->getOwnerId());
		if ($owner == NULL) {
			$this->view("error_view");
			return;
		}
		$this->view("event_view", ['event' => $event, 'owner' => $owner]);
	}

	public function edit() {
		$key = "editEvent";
		$missing_params = "missing_params";
		$corrupted_file = "corrupted_file";
		$created_event = "created_event";
		$params = ['id' => '', 'name' => '', 'description' => '', 'date' => '', 'type' => ''];

		if(!$this->fillPostParameters($params)) {
            $this->printResponse($key, $missing_params);
            return;
        }

        $params['private'] = isset($_POST['private']);

        if (isset($_FILES['image']) && $_FILES['image']['name'] == "") {
			$this->printResponse($key, $corrupted_file);
			return;
		}

		if(!isset($_FILES['image'])) {
			EventDAO::editEvent($params['id'],$user->getId(), $params['name'], $params['description'], NULL, $params['date'], $params['type'], $params['private']);
		}

		else {
			$photo = time() . $_FILES['image']['name'];
			$photoPath = __DIR__ . "/../../public/img/uploaded/" . $photo;
			move_uploaded_file( $_FILES['image']['tmp_name'], $photoPath);
			EventDAO::editEvent($params['id'],$user->getId(), $params['name'], $params['description'], $photoPath, $params['date'], $params['type'], $params['private']);
		}

		$this->printResponse($key, $created_event);
	}
	
	public function create() {
		$key = "createEvent";
        $missing_params = "missing_params";
		$missing_file = "missing_file";
		$created_event = "created_event";
		$params = ['name' => '', 'description' => '', 'date' => '', 'type' => ''];
		
		if(!$this->fillPostParameters($params)) {
            $this->printResponse($key, $missing_params);
            return;
        }
		
		if (!isset($_FILES['image']) || $_FILES['image']['name'] == "") {
			$this->printResponse($key, $missing_file);
			return;
		}
		
		
		require_once(__DIR__ . '/../../library/headerSession.php');
		if ($user == NULL) {
			$this->printResponse($key, "no user");
			return;
		}
		
		$photo = time() . $_FILES['image']['name'];
		$photoPath = __DIR__ . "/../../public/img/uploaded/" . $photo;
		if (!move_uploaded_file( $_FILES['image']['tmp_name'], $photoPath)) {
			$this->printResponse($key, "image upload failed");
			return;
		}
		
        if(isset($_POST['private']))
            $params['private'] = 1;
        else
            $params['private'] = 0;
		
        EventDAO::createEvent($user->getId(), $params['name'], $params['description'], $photoPath, $params['date'], $params['type'], $params['private']);
		
		$this->printResponse($key, $created_event);
	}
	
	
	public function search() {
		$name = $_GET['name'];
		
		$events = EventDAO::searchEventName($name);
		
		var_dump($events);
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
