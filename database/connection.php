<?php
try {
	$parentfolder = dirname(dirname(__FILE__));
 	$db = new PDO('sqlite:' . $parentfolder . '/SQL/news.db');
 	} catch(PDOException $e) {
}

?>