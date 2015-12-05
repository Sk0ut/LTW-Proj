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
		$row = $result[0];

		$row['type'] = $typeData[0]['type'];
		return new Event($row['id'], $row['name'], $row['description'],
						 $row['ownerId'], $row['photo'], $row['eventDate'],
						 $row['type'], $row['private']);
	}

	public static function getOwnerEvents($ownerId) {
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

			$row['type'] = $typeData[0]['type'];
			$events[] = new Event($row['id'], $row['name'], $row['description'],
						 $row['ownerId'], $row['photo'], $row['eventDate'],
						 $row['type'], $row['private']);

		}

		return $events;
	}
	
	public static function getRegisteredEvents($userId) {

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

			$row['type'] = $typeData[0]['type'];
			$events[] = new Event($row['id'], $row['name'], $row['description'],
						 $row['ownerId'], $row['photo'], $row['eventDate'],
						 $row['type'], $row['private']);

		}

		return $events;
	}
	
	public static function getEventTypeId($type) {
		$database = Database::getInstance();
		
		$query = "SELECT id FROM EventType WHERE type = ?";
		$params = [$type];
		$types = [PDO::PARAM_STR];

		$result = $database->executeQuery($query, $params, $types);

		if(count($result) != 1){
			return NULL;
		}

		return $result[0]['id'];
	}
	
	public static function getEventTypesInfo() {
		$database = Database::getInstance();
		
		$query = "SELECT * FROM EventType";
		return $database->executeQuery($query, [], []);
	}
	
	public static function createEvent($ownerId, $name, $description, $photo, $date, $typeId, $private){
		$db = Database::getInstance();

		$query = "INSERT INTO Events(name, description, ownerId, photo, eventDate, typeId, private) VALUES(?, ?, ?, ?, ?, ?, ?)";
		$params = [$name, $description, $ownerId, $photo, $date, $typeId, $private];
		$types = [PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_BOOL];

		$result = $db->executeUpdate($query, $params, $types);

		if($result != 1){
			return NULL;
		}

		$query = "SELECT last_insert_rowid() AS id FROM Events";
		$params = [];
		$types = [];

		$result = $db->executeQuery($query, $params, $types);

		if(count($result) != 1){
			return NULL;
		}

		$id = $result[0]['id'];

		return $self.getById($id);

	}

	public static function editEvent($id, $ownerId, $name, $description, $photo, $date, $typeId, $private){
		$db = Database::getInstance();

		if($photo == NULL){
			$query = "UPDATE Events SET name=?, description=?, ownerId = ?, eventDate = ?, typeId = ?, private = ? WHERE id = ?";
			$params = [$name, $description, $ownerId, $date, $typeId, $private, $id];
			$types = [PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_BOOL, PDO::PARAM_INT];
		}
		else {
			$query = "UPDATE Events SET name=?, description=?, ownerId = ?, photo = ?, eventDate = ?, typeId = ?, private = ? WHERE id = ?";
			$params = [$name, $description, $ownerId, $photo, $date, $typeId, $private, $id];
			$types = [PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_BOOL, PDO::PARAM_INT];
		}

		$result = $db->executeUpdate($query, $params, $types);

		if($result != 1){
			return NULL;
		}

		return $self.getById($id);
	}
	
	public static function searchEventName($name) {
		$db = Database::getInstance();

		$query = "SELECT id FROM Events WHERE name LIKE ?";
		$params = ['%' . $name . '%'];
		$types = [PDO::PARAM_STR];

		$result = $db->executeQuery($query, $params, $types);
		$events = [];

		foreach($result as $row){
			$event = self::getById($row['id']);
			if ($event == NULL)
				return NULL;
			$events[] = $event;
		}

		return $events;
	}
}
