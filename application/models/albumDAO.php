<?php

require_once __DIR__ . "album.php";

class AlbumDAO {
    public static function getById($id) {
        $database = Database::getInstance();
        $query = "SELECT * FROM Album WHERE id = ?";
        $params = [ $id ];
        $types = [ PDO::PARAM_INT ];
        $result = $database->executeQuery($query, $params, $types);
        if (count($result) != 1) {
            return NULL;
        }
        $albumData = $result[0];
        return new Album($albumData['id'], $albumData['eventId'], $albumData['title']);
    }

    public static function getPhotosFromAlbum($albumId){
        $database = Database::getInstance();
        $query = "SELECT path FROM Photo WHERE albumId = ?";
        $params = [$albumId];
        $types = [ PDO::PARAM_INT ];

        $result = $database->executeQuery($query, $params, $types);

        foreach($result as $row){
            $photos[] = $row['path'];
        }

        return $photos;
    }

    public static function createAlbum($eventId, $title){
        $db = Database::getInstance();

        $query = "INSERT INTO Album(eventId, title) VALUES(?, ?)";
        $params = [$eventId, $title];
        $types = [PDO::PARAM_INT, PDO::PARAM_STR];

        $result = $db->executeUpdate($query, $params, $types);

        if($result != 1){
            return NULL;
        }

        $query = "SELECT last_insert_rowid() AS id FROM Album";
        $params = [];
        $types = [];

        $result = $db->executeQuery($query, $params, $types);

        if(count($result) != 1){
            return NULL;
        }

        $id = $result[0]['id'];

        return $self.getById($id);
    }

    public static function getAlbumsFromEvent($eventId){
        $db = Database::getInstance();

        $query = "SELECT * FROM Album WHERE eventId = ?";
        $params = [$eventId];
        $types = [PDO::PARAM_INT];

        $result = $db->executeQuery($query, $params, $types);

        foreach($result as $row){
            $photos = $self.getPhotosFromAlbum($row['id']);
            $albums[] = new Album($row['id'], $row['eventId'], $row['title'], $photos);
        }

        return $albums;
    }


}