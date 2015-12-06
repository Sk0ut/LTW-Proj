<?php

class Comment {
    private $_id;
    private $_user;
    private $_threadId;
    private $_comment;
    private $_commentDate;

    /**
     * Comment constructor.
     * @param $_id
     * @param $_user
     * @param $_threadId
     * @param $_comment
     * @param $_commentDate
     * @param $_parentId
     */
    public function __construct($_id, $_user, $_threadId, $_comment, $_commentDate){
        $this->_id = $_id;
        $this->_user = $_user;
        $this->_threadId = $_threadId;
        $this->_comment = $_comment;
        $this->_commentDate = $_commentDate;
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
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @param mixed $userId
     */
    public function setUser($userId)
    {
        $this->_user = $userId;
    }

    /**
     * @return mixed
     */
    public function getThreadId()
    {
        return $this->_threadId;
    }

    /**
     * @param mixed $threadId
     */
    public function setThreadId($threadId)
    {
        $this->_threadId = $threadId;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->_comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->_comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getCommentDate()
    {
        return $this->_commentDate;
    }

    /**
     * @param mixed $commentDate
     */
    public function setCommentDate($commentDate)
    {
        $this->_commentDate = $commentDate;
    }
}