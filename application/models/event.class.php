<?php
class Event {
	private $_name;
	private $_owner;
	private $_type;
	private $_description;
	private $_date;
	private $_picture;
	private $_albums;
	private $_forum;
	
	public function __construct($name, $owner, $type, $description, $date, $picture) {
		$this->_name = $name;
		$this->_owner = $owner;
		$this->_type = $type;
		$this->_description = $description;
		$this->_date = $date;
		$this->_picture = $picture;
		$this->_albums = array();
		$this->_forum = array();
	}
	
	public function addAlbum($album) {
		$this->_albums[] = $album;
	}
	
	public function addThread($thread) {
		$this->_forum[] = $thread;
	}
	
	public function getName() {
		return $this->_name;
	}
	
	public function getOwner() {
		return $this->_owner;
	}
	
	public function getType() {
		return $this->_date;
	}

	public function getDescription() {
		return $this->_description;
	}
	
	public function getPicture() {
		return $this->_picture;
	}
	
	public function getDate() {
		return $this->_date;
	}
	
	public function getAlbums() {
		return $this->_albums;
	}
	
	public function getForum() {
		return $this->_forum;
	}
}
?>