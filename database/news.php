 <?php
function getAllNews() {
	global $db;
	$stmt = $db->prepare('SELECT * FROM news');
 	$stmt->execute();

 	return $stmt->fetchAll();
}

function getNews($id) {
	global $db;
	$stmt = $db->prepare('SELECT * FROM news WHERE id = :id');
 	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
 	$stmt->execute();

 	return $stmt->fetchAll();
}
?>