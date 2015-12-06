<?php

require_once __DIR__ . "/database.php";
require_once __DIR__ . "/thread.php";

class ThreadDAO {
    public static function createThread($eventId, $title, $description){
        $db = Database::getInstance();

        $query = "INSERT INTO Threads(eventId, title, description) VALUES(?, ?, ?)";
        $params = [$eventId, $title, $description];
        $types = [PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_STR];

        $result = $db->executeUpdate($query, $params, $types);

        if($result != 1){
            return NULL;
        }

        $query = "SELECT last_insert_rowid() AS id FROM Threads";
        $params = [];
        $types = [];

        $result = $db->executeQuery($query, $params, $types);

        if(count($result) != 1){
            return NULL;
        }

        $id = $result[0]['id'];

        return $self.getById($id);
    }

    public static function getThreadsFromEvent($eventId){
        $db = Database::getInstance();

        $query = "SELECT * FROM Threads WHERE eventId = ?";
		$params = [$eventId];
		$types = [PDO::PARAM_INT];

		$result = $db->executeQuery($query, $params, $types);

		return $result;
	}
}