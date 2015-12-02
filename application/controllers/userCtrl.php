<?php
require_once __DIR__ . "/../core/controller.php";
require_once __DIR__ . "/../models/userDAO.php";
require_once __DIR__ . "/../models/eventDAO.php";

class UserCtrl extends Controller {
    public function index($params) {
    	if(count($params) != 1)
    		return NULL;
    	$id = $params[0];
    	$user = UserDAO::getUserFromId($id);
    	$ownedEvents = EventDAO::getOwnerEvents($id);
    	$userEvents = EventDAO::getRegisteredEvents($id);
        $this->view("userpage_view", ['user' => $user, 'ownedEvents' => $ownedEvents, 'userEvents' => $userEvents]);
    }
}