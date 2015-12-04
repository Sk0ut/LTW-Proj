<?php

class Event {
	private $_id;
	private $_name;
	private $_description;
	private $_ownerId;
	private $_photo;
	private $_date;
	private $_type;
	private $_private;
	
	public function __construct($id, $name, $description, $ownerId, $photo, $date, $type, $private) {
		$this->_id = $id;
		$this->_name = $name;
		$this->_description = $description;
		$this->_ownerId = $ownerId;
		$this->_photo = $photo;
		$this->_date = $date;
		$this->_type = $type;
		$this->_private = $private;
	}
	
	public function getId() {
		return $this->_id;
	}
	
	public function setId($id) {
		$this->_id = $id;
	}
	
	public function getName() {
		return $this->_name;
	}
	
	public function setName($name) {
		$this->_name = $name;
	}
	
	public function getDescription() {
		return $this->_description;
	}
	
	public function setDescription($description) {
		$this->_description = $description;
	}
	
	public function getOwnerId() {
		return $this->_ownerId;
	}
	
	public function setOwnerId($ownerId) {
		$this->_ownerId = $ownerId;
	}
	
	public function getPhoto() {
		return $this->_photo;
	}
	
	public function setPhoto($photo) {
		$this->_photo = $photo;
	}
	
	public function getDate() {
		return $this->_date;
	}
	
	public function setDate($date) {
		$this->_date = $date;
	}
	
	public function getType() {
		return $this->_type;
	}
	
	public function setType($type) {
		$this->_type = $type;
	}
	
	public function getPrivate() {
		return $this->_private;
	}
	
	public function setPrivate($private) {
		$this->_private = $private;
	}
}