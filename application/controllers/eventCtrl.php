<?php
require_once __DIR__ . "/../core/controller.php";
require_once __DIR__ . "/../models/eventDAO.php";
require_once __DIR__ . "/../models/event.php";
require_once __DIR__ . "/../models/userDAO.php";
require_once __DIR__ . "/../models/thread.php";
require_once __DIR__ . "/../models/threadDAO.php";

class EventCtrl extends Controller {
	public function index() {
		require_once(__DIR__ . '/../../library/headerSession.php');
        if(is_null($user)) {
			$this->view("error_view");
			return;
		}
		
		if (!isset($_GET['id'])) {
			$this->view("error_view");
			return;
		}
		$id = $_GET['id'];
		$event = EventDAO::getById($id);
		if (is_null($event)) {
			$this->view("error_view");
			return;
		}
		$owner = UserDAO::getUserFromId($event->getOwnerId());
		if (is_null($owner)) {
			$this->view("error_view");
			return;
		}
		
		$isOwner = $owner->getId() == $user->getId();
		
		$registeredUsers = EventDAO::getRegisteredUsers($id);
		if (is_null($registeredUsers)) {
			$this->view("error_view");
			return;
		}
		
		$registered = False;
		
		foreach($registeredUsers as $registeredUser) {
			if ($registeredUser->getId() == $user->getId()) {
				$registered = True;
				break;
			}
		}

		$finished = time() > strtotime($event->getDate());
		
		$forum = ThreadDAO::getThreadsFromEvent($id);

		$this->view("event_view", ['event' => $event, 'owner' => $owner, 'registeredUsers' => $registeredUsers,
			'isOwner' => $isOwner, 'registered' => $registered, 'finished' => $finished, 'forum' => $forum]);
	}
	
	public function changePassword() {
		$key = 'change password';
		
		require_once(__DIR__ . '/../../library/headerSession.php');
        if(is_null($user)) {
			$this->printResponse($key, "missing params");
			return;
		}
		
		
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
		
        EventDAO::createEvent($user->getId(), $params['name'], $params['description'], $photo, $params['date'], $params['type'], $params['private']);
		
		$this->printResponse($key, $created_event);
	}

	public function createThread() {
		$key = 'createThread';
		$missing_params = "missing_params";
		$created_thread = "created_thread";
        $no_users = "no_users";
        $user_not_logged = "user_not_logged";
        $user_not_in_event="user_not_in_event";
		$params = ['eventId' => '', 'title' => '', 'description' => ''];

        require_once(__DIR__ . '/../../library/headerSession.php');
        if(is_null($user)) {
            $this->printResponse($key, $user_not_logged);
            return;
        }

        if(!$this->fillPostParameters($params)) {
            $this->printResponse($key, $missing_params);
            return;
        }

        $users = EventDAO::getRegisteredUsers($params['eventId']);
        if(is_null($users)){
            $this->printResponse($key, $no_users);
            return;
        }

        foreach($users as $row) {
            if($row->getId() == $user->getId()){
                EventDAO::createThread($user->getId(), $params['eventId'], $params['title'], $params['description']);
                $this->printResponse($key, $created_thread);
                return;
            }
        }

        $this->printResponse($key, $user_not_in_event);
        return;
	}


	public function addComment() {
		$key = 'addComment';
		$missing_params = "missing_params";
		$added_comment = "added_comment";
        $no_users = "no_users";
        $user_not_logged = "user_not_logged";
        $user_not_in_event="user_not_in_event";

		$params = ['threadId' => '', 'comment' => ''];

        require_once(__DIR__ . '/../../library/headerSession.php');
        if(is_null($user)) {
            $this->printResponse($key, $user_not_logged);
            return;
        }

		if(!$this->fillPostParameters($params)) {
            $this->printResponse($key, $missing_params);
            return;
        }

        $users = EventDAO::getRegisteredUsers($params['eventId']);
        if(is_null($users)){
            $this->printResponse($key, $no_users);
            return;
        }

        foreach($users as $row) {
            if($row->getId() == $user->getId()){
                EventDAO::addComment($user->getId(), $params['threadId'], $params['comment']);
                $this->printResponse($key, $added_comment);
                return;
            }
        }

        $this->printResponse($key, $user_not_in_event);
        return;
	}
	
	/**
	 * Search for event.
	 */
	public function search() {
		$name = $_GET['name'];
		
		$events = EventDAO::searchEventName($name);
		
		$eventsJSON = [];
		
		foreach ($events as $event) {
			$eventsJSON[] = $event->expose();
		}
		
		$this->printResponse("search_events", $eventsJSON);
	}
	
	/**
	 * Register user in event.
	 */
	public function register() {
		$key = "register event";
		
		require_once(__DIR__ . '/../../library/headerSession.php');
		if ($user == NULL) {
			$this->printResponse($key, "no user");
			return;
		}

		$params = ['eventId' => ''];
		if (!$this->fillPostParameters($params))
		{
			$this->printResponse($key, "mising parameters");
			return;
		}
		
		if (!EventDAO::register($user->getId(), $params['eventId'])) {
			$this->printResponse($key, "register fail");
			return;
		}
		
		$this->printResponse($key, "registered");		
	}
	
	
	/**
	 * Unregister user from event.
	 */
	public function unregister() {
		$key = "unregister event";
		
		require_once(__DIR__ . '/../../library/headerSession.php');
		if ($user == NULL) {
			$this->printResponse($key, "no user");
			return;
		}

		$params = ['eventId' => ''];
		if (!$this->fillPostParameters($params))
		{
			$this->printResponse($key, "mising parameters");
			return;
		}
		
		if (!EventDAO::unregister($user->getId(), $params['eventId'])) {
			$this->printResponse($key, "unregister fail");
			return;
		}
		
		$this->printResponse($key, "unregistered");		
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
