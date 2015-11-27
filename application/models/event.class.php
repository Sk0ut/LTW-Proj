<?php

require_once("database.php");
require_once("user.php");

class Event {
	private $id;
	private $name;
	private $owner;
	private $type;
	private $description;
	private $date;
	private $picture;
	private $albums;
	private $forum;
	
	public function __construct($id, $name, $owner, $type, $description, $date, $picture) {
		$this->id = $id;
		$this->name = $name;
		$this->owner = $owner;
		$this->type = $type;
		$this->description = $description;
		$this->date = $date;
		$this->picture = $picture;
		$this->albums = array();
		$this->forum = array();
	}
	
	public function addAlbum($album) {
		$this->albums[] = $album;
	}
	
	public function addThread($thread) {
		$this->forum[] = $thread;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getOwner() {
		return $this->owner;
	}
	
	public function getType() {
		return $this->date;
	}

	public function getDescription() {
		return $this->description;
	}
	
	public function getPicture() {
		return $this->picture;
	}
	
	public function getDate() {
		return $this->date;
	}
	
	public function getAlbums() {
		return $this->albums;
	}
	
	public function getForum() {
		return $this->forum;
	}
	
	public static function find($id) {
		global $database;
		$data = $database->executeQuery("SELECT * FROM Events WHERE id = ?", [$id], [PDO::PARAM_STR])[0];
		
		$event = new Event($data['id'], $data['name'], $owner, $type, $description, $date, $picture);
	}
}
?>