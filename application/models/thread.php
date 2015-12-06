<?php
	/**
	* 
	*/
	class Thread {
		private $_id;
		private $_eventId;
		private $_title;
		private $_description;
        private $_comments;
        private $_user;
		
		public function __construct($id, $eventId, $user, $title, $description, $comments) {
			$this->_id = $id;
			$this->_eventId = $eventId;
			$this->_title = $title;
			$this->_description = $description;
			$this->_comments = $comments;
            $this->_user = $user;
		}

        /**
         * @return mixed
         */
        public function getUser()
        {
            return $this->_user;
        }

        /**
         * @param mixed $user
         */
        public function setUser($user)
        {
            $this->_user = $user;
        }

		/**
		 * @return mixed
		 */
		public function getComments()
		{
			return $this->_comments;
		}

		/**
		 * @param mixed $comments
		 */
		public function setComments($comments)
		{
			$this->_comments = $comments;
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