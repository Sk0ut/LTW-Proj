<?php

class CommentDAO {
    public static function addComment($userId, $threadId, $comment, $parentId){
        $db = Database::getInstance();


        if($parentId == NULL){
            $query = "INSERT INTO Comments(userId, threadId, comment, commentDate) VALUES(?, ?, ?, datetime(now))";
            $params = [$userId, $threadId, $comment];
            $types = [PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_STR];
        }

        else {
            $query = "INSERT INTO Comments(userId, threadId, comment, commentDate, parentId) VALUES(?, ?, ?, datetime(now), ?)";
            $params = [$userId, $threadId, $comment, $commentDate, $parentId];
            $types = [PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_INT];
        }

        $result = $db->executeUpdate($query, $params, $types);

        if($result != 1){
            return NULL;
        }

        $query = "SELECT last_insert_rowid() AS id FROM Comments";
        $params = [];
        $types = [];

        $result = $db->executeQuery($query, $params, $types);

        if(count($result) != 1){
            return NULL;
        }

        $id = $result[0]['id'];

        return $self.getById($id);
    }

    public static function getCommentsFromThread($threadId) {
        $db = Database::getInstance();

        $query = "SELECT * FROM Comments WHERE threadId = ?";
        $params = [$threadId];
        $types = [$PDO::PARAM_INT];

        $result = $db->executeQuery($query, $params, $types);

        return $result;
    }

    public static function getById($id) {
        $database = Database::getInstance();
        $query = "SELECT * FROM Comments WHERE id = ?";
        $params = [ $id ];
        $types = [ PDO::PARAM_INT ];
        $result = $database->executeQuery($query, $params, $types);
        if (count($result) != 1) {
            return NULL;
        }
        $commentData = $result[0];
        
        return new Thread($commentData['id'], $commentData['userId'], $commentData['threadId'], $commentData['comment'], $commentData['commentDate'], $commentData['parentId'];
    }
}