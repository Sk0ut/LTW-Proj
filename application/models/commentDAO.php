<?php

class CommentDAO {
    public static function addComment($userId, $threadId, $comment, $commentDate, $parentId){
        $db = Database::getInstance();

        if($parentId == NULL){
            $query = "INSERT INTO Comments(userId, threadId, comment, commentDate) VALUES(?, ?, ?, ?)";
            $params = [$userId, $threadId, $comment, $commentDate];
            $types = [PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_STR];
        }

        else {
            $query = "INSERT INTO Comments(userId, threadId, comment, commentDate, parentId) VALUES(?, ?, ?, ?, ?)";
            $params = [$userId, $threadId, $comment, $commentDate, $parentId];
            $types = [PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT];
        }

        $result = $db->executeUpdate($query, $params, $types);

        if($result != 1){
            return FALSE;
        }

        return TRUE;
    }

    public static function getCommentsFromThread($threadId) {
        $db = Database::getInstance();

        $query = "SELECT * FROM Comments WHERE threadId = ?";
        $params = [$threadId];
        $types = [$PDO::PARAM_INT];

        $result = $db->executeQuery($query, $params, $types);

        return $result;
    }
}