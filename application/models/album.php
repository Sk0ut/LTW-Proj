<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 06-12-2015
 * Time: 16:54
 */
class Album {
    private $_id;
    private $_eventId;
    private $_title;
    private $_photos;

    /**
     * Album constructor.
     * @param $_id
     * @param $_eventId
     * @param $_title
     * @param $_photos
     */
    public function __construct($id, $eventId, $title, $photos) {
        $this->_id = $id;
        $this->_eventId = $eventId;
        $this->_title = $title;
        $this->_photos = $photos;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getEventId()
    {
        return $this->_eventId;
    }

    /**
     * @param mixed $eventId
     */
    public function setEventId($eventId)
    {
        $this->_eventId = $eventId;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->_photos;
    }

    /**
     * @param mixed $photos
     */
    public function setPhotos($photos)
    {
        $this->_photos = $photos;
    }
}