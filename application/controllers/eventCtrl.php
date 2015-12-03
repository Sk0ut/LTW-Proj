<?php
require_once __DIR__ . "/../core/controller.php";
require_once __DIR__ . "/../models/eventDAO.php";
require_once __DIR__ . "/../models/event.php";
require_once __DIR__ . "/../models/userDAO.php";

class EventCtrl extends Controller {
	public function index($id) {
		$event = EventDAO::getById($id);
		$owner = UserDAO::getUserFromId($event->getOwnerId());
		
		$this->view("event_view", ['event' => $event, 'owner' => $owner]);
	}
}