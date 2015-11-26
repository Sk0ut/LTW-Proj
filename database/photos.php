<?php
	function getAlbumPhotos($albumId) {
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM Photos WHERE albumId = :albumId");
		$stmt->bindParam(":albumId", $albumId, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll();		
	}
	
	function getPhoto($id) {
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM Photos WHERE id = :id");
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch();
	}
?>