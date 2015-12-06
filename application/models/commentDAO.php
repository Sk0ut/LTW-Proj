<?php

class CommentDAO {
    public static function addComment($userId, $threadId, $comment){
        $db = Database::getInstance();

        $query = "INSERT INTO Comments(userId, threadId, comment, commentDate) VALUES(?, ?, ?, datetime('now'))";
        $params = [$userId, $threadId, $comment];
        $types = [PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_STR];

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

        $query = "SELECT * FROM Comments ORDER BY datetime(commentDate) WHERE threadId = ?";
        $params = [$threadId];
        $types =[PDO::PARAM_INT];

        $result = $db->executeQuery($query, $params, $types);
        if($result == NULL || count($result) == 0){
            $result = array();
            return $result;
        }

        $comments = [];
        foreach($result as $row){
            $user = UserDAO::getUserFromId($row['userId']);
            if($user == NULL){
                continue;
            }
            $comment = new Comment($row['id'], $user, $row['threadId'], $row['comment'], $row['commentDate']);
            if($comment == NULL)
                continue;

            $comments[] = $comment;
        }

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
        
        return new Thread($commentData['id'], $commentData['userId'], $commentData['threadId'], $commentData['comment'], $commentData['commentDate']);
    }
}
