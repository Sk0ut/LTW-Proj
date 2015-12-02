<?php

require_once "database.php";
require_once "event.php";

class EventDAO {
	public static function getById($id) {
		$database = Database::getInstance();
		$query = "SELECT * FROM Events WHERE id = ?";
		$params = [ $id ];
		$types = [ PDO::PARAM_INT ];
		$result = $database->executeQuery($query, $params, $types);
		if (count($result) != 1) {
			return NULL;
		}
		$eventData = $result[0];
		
		$query = "SELECT type FROM EventType WHERE id = ?";
		$params = [$eventData['typeId']];
		$types = [PDO::PARAM_INT];
		$result = $database->executeQuery($query, $params, $types);
		if (count($result) != 1) {
			return NULL;
		}
		$eventData['type'] = $result['type'];
		
		return new Event($eventData['id'], $eventData['name'], $eventData['ownerId'],
						 $eventData['photo'], $eventData['date'], $eventData['type'],
						 $eventData['private']);
	}

	function getOwnerEvents($ownerId) {
		$db = Database::getInstance();

		$query = "SELECT * FROM Events WHERE ownerId = ?";
		$params = [$ownerId];
		$types = [PDO::PARAM_INT];

		$result = $db->executeQuery($query, $params, $types);
		$events = [];

		$query = "SELECT type FROM EventType WHERE id=?";
		$types = [PDO::PARAM_INT];

		foreach($result as $row){
			$params = [$row['typeId']];
			$typeData = $db->executeQuery($query, $params, $types);

			if(count($typeData) != 1){
				return NULL;
			}

			$row['type'] = $typeData['type'];
			$events[] = new Event($row['id'], $row['name'], $row['ownerId'],
						 $row['photo'], $row['date'], $row['type'],
						 $row['private']);

		}

		return $events;
	}
	
	function getRegisteredEvents($userId) {

		$db = Database::getInstance();

		$query = "SELECT * FROM Events WHERE id IN (SELECT eventId FROM UserEvents WHERE userId = ?)";
		$params = [$userId];
		$types = [PDO::PARAM_INT];

		$result = $db->executeQuery($query, $params, $types);
		$events = [];

		$query = "SELECT type FROM EventType WHERE id=?";
		$types = [PDO::PARAM_INT];

		foreach($result as $row){
			$params = [$row['typeId']];
			$typeData = $db->executeQuery($query, $params, $types);

			if(count($typeData) != 1){
				return NULL;
			}

			$row['type'] = $typeData['type'];
			$events[] = new Event($row['id'], $row['name'], $row['ownerId'],
						 $row['photo'], $row['date'], $row['type'],
						 $row['private']);

		}

		return $events;
	}
}