<?php

require_once __DIR__ . "/database.php";
require_once __DIR__ . "/thread.php";

class ThreadDAO {
    public static function createThread($eventId, $userId, $title, $description){
        $db = Database::getInstance();

        $query = "INSERT INTO Threads(eventId, userId, title, description) VALUES(?, ?, ?, ?)";
        $params = [$eventId, $userId, $title, $description];
        $types = [PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_STR];

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

        $query = "SELECT id FROM Threads WHERE eventId = ?";
		$params = [$eventId];
		$types = [PDO::PARAM_INT];

		$result = $db->executeQuery($query, $params, $types);

        $threads = [];

        foreach($result as $row){
            $threads[] = $self.getById($row['id']);
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
        $user = UserDAO::getUserFromId($threadData['userId']);
        if(is_null($user))
            return NULL;

        $comments = CommentDAO::getCommentsFromThread($id);
        
        return new Thread($threadData['id'], $threadData['eventId'], $user, $threadData['title'], $threadData['description'], $comments);
    }
}