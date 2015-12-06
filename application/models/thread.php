<?php
	/**
	* 
	*/
	class ClassName	{
		private $_id;
		private $_eventId;
		private $_title;
		private $_description;
		
		public function __construct($id, $eventId, $title, $description) {
			$this->_id = $id;
			$this->_eventId = $eventId;
			$this->_title = $title;
			$this->_description = $description;
		}

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->_id = $id;
        }

        /**
         * @param mixed $eventId
         */
        public function setEventId($eventId)
        {
            $this->_eventId = $eventId;
        }

        /**
         * @param mixed $description
         */
        public function setDescription($description)
        {
            $this->_description = $description;
        }

        /**
         * Get the title of the thread
         * @return title of the thread
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
		 * method that retrieves the object attributes as an associative array
		 * @return class attributes as associative array
		 */
		public function expose() {
			return get_object_vars($this);
		}

		 /**
	     * Get the id of the thread
	     * @return id of the thread
	     */
	    public function getId() {
	        return $this->_id;
	    }

	    /**
	     * Get the id of the thread's event
	     * @return id of the thread's event
	     */
	    public function getEventId() {
	        return $this->_eventId;
	    }

        /**
         * Get the description of the thread's event
         * @return description of the thread's event
         */
	    public function getDescription() {
			return $this->_description;
		}

        /**
         * Convert a thread to string
         */
        public function __toString() {
            return json_encode(
                [
                    $this->_id,
                    $this->_description,
                    $this->_eventId,
                    $this->_title
                ]);
        }
	}