<?php
	/* Returns a user from its id*/
	function getUser($id){
		global $db;
		$user = $db->prepare('SELECT * FROM users WHERE id = :id');
		$user->bindParam(':id', $idm PDO::PARAM_INT);
		$user->execute();

		return $user->fetch();
	}

	/* Returns the events from a user */
	function getEvents($username){
		global $db;
		$user = $db->prepare(
			'SELECT * FROM Events WHERE ownerid=
			(SELECT id FROM Users WHERE username = :username)');
		$user->bindParam(':username', $idm PDO::PARAM_INT);
		$user->execute();

		return $user->fetchAll();
	}

	/* */
?>