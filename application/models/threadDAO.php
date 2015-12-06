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

        foreach($result as $row){
            $threads[] = new Thread($row['id'], $row['eventId'], $row['title'], $row['description']);
        }

		return $threads;
	}

    public static function getById($id) {
        $database = Database::getInstance();
        $query = "SELECT * FROM Threads WHERE id = ?";
        $params = [ $id ];
        $types = [ PDO::PARAM_INT ];
        $result = $database->executeQuery($query, $params, $types);
        if (count($result) != 1) {
            return NULL;
        }
        $threadData = $result[0];
        
        return new Thread($threadData['id'], $threadData['eventId'], $threadData['title'], $threadData['description']);
    }
}