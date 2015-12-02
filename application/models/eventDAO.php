<?php

require_once "database.php";
require_once "event.php"

class EventDAO {
	public static function getById($id) {
		$db = Database::getInstance();
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
}