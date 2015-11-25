<?php
	function getComments($id){
		 global $db;
		 $comments = $db->prepare('SELECT * FROM comments WHERE news_id = :id');
 		 $comments->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
 		 $comments->execute();

 		 return $comments->fetchAll();
	}
?>