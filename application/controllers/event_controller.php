<?php
require_once __DIR__ . "/../core/controller.php";
require_once __DIR__ . "/../model/eventDAO.php";
require_once __DIR__ . "/../model/event.php";
require_once __DIR__ . "/../model/userDAO.php"

class Event_Controller extends Controller {
	public function index($id) {
		$event = EventDAO::getById($id);
		$owner = UserDAO::getUserFromId($event->getOwnerId());
		
		$this->view("event_view", ['event' => $event, 'owner' => $owner]);
	}
}