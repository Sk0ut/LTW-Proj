<?php

class CommentDAO {
    public static function addComment($userId, $threadId, $comment){
        $db = Database::getInstance();

        $query = "INSERT INTO UserComment(userId, threadId, comment, commentDate) VALUES(?, ?, ?, datetime('now'))";
        $params = [$userId, $threadId, $comment];
        $types = [PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_STR];

        $result = $db->executeUpdate($query, $params, $types);

        if(!$result || $result <= 0)
            return false;
        return true;
   }

    public static function getCommentsFromThread($threadId) {
        $db = Database::getInstance();

        $query = "SELECT * FROM UserComment WHERE threadId = ? ORDER BY datetime(commentdate)";
        $params = [$threadId];
        $types =[PDO::PARAM_INT];

        $result = $db->executeQuery($query, $params, $types);
        if($result == NULL || count($result) == 0)
            $result = array();
        return $result;
    }

    public static function getById($id) {
        $database = Database::getInstance();
        $query = "SELECT * FROM UserComment WHERE id = ?";
        $params = [ $id ];
        $types = [ PDO::PARAM_INT ];
        $result = $database->executeQuery($query, $params, $types);
        if (count($result) != 1) {
            return NULL;
        }
        $commentData = $result[0];
        
        return new Thread($commentData['id'], $commentData['userId'], $commentData['threadId'], $commentData['comment'], $commentData['commentDate']);
    }
}
