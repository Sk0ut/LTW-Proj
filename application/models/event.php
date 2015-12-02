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
	
	public __construct($id, $name, $description, $ownerId, $photo, $date, $type, $private) {
		$this->_id = $id;
		$this->_name = $name;
		$this->_description = $description;
		$this->_ownerId = $ownerId;
		$this->_photo = $photo;
		$this->_date = $date;
		$this->_type = $type;
		$this->_private = $private;
	}
	
	public getId() {
		return $this->_id;
	}
	
	public setId($id) {
		$this->_id = $id;
	}
	
	public getName() {
		return $this->_name;
	}
	
	public setName($name) {
		$this->_name = $name;
	}
	
	public getDescription() {
		return $this->_description;
	}
	
	public setDescription($description) {
		$this->_description = $description;
	}
	
	public getOwnerId() {
		return $this->_ownerId;
	}
	
	public setOwnerId($ownerId) {
		$this->_ownerId = $ownerId;
	}
	
	public getPhoto() {
		return $this->_photo;
	}
	
	public setPhoto($photo) {
		$this->_photo = $photo;
	}
	
	public getDate() {
		return $this->_date;
	}
	
	public setDate($date) {
		$this->_date = $date;
	}
	
	public getType() {
		return $this->_type;
	}
	
	public setType($type) {
		$this->_type = $type;
	}
	
	public getPrivate() {
		return $this->_private;
	}
	
	public setPrivate($private) {
		$this->_private = $private;
	}
}