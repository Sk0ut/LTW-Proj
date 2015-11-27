<?php
	function getOwnerEvents($ownerId) {
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM Events WHERE ownerId = :ownerId");
		$stmt->bindParam(":ownerId", $ouwnerId, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	function getRegisteredEvents($userId) {
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM Events WHERE id IN (SELECT eventId FROM UserEvents WHERE userId = :userId)");
		$stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll();		
	}
	
	function createEvent($name, $description, $ownerId, $eventDate, $typeId) {
		
	}
?>