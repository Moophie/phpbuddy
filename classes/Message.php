<?php

include_once(__DIR__ . "/Db.php");

class Message
{
    private $id;
    private $chat_id;
    private $sender_id;
    private $receiver_id;
    private $content;
    private $time;
    private $read;
    private $reaction;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of chat_id
     */ 
    public function getChat_id()
    {
        return $this->chat_id;
    }

    /**
     * Set the value of chat_id
     *
     * @return  self
     */ 
    public function setChat_id($chat_id)
    {
        $this->chat_id = $chat_id;

        return $this;
    }

    /**
     * Get the value of sender_id
     */ 
    public function getSender_id()
    {
        return $this->sender_id;
    }

    /**
     * Set the value of sender_id
     *
     * @return  self
     */ 
    public function setSender_id($sender_id)
    {
        $this->sender_id = $sender_id;

        return $this;
    }

    /**
     * Get the value of receiver_id
     */ 
    public function getReceiver_id()
    {
        return $this->receiver_id;
    }

    /**
     * Set the value of receiver_id
     *
     * @return  self
     */ 
    public function setReceiver_id($receiver_id)
    {
        $this->receiver_id = $receiver_id;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of time
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get the value of read
     */ 
    public function getRead()
    {
        return $this->read;
    }

    /**
     * Set the value of read
     *
     * @return  self
     */ 
    public function setRead($read)
    {
        $this->read = $read;

        return $this;
    }

    /**
     * Get the value of reaction
     */ 
    public function getReaction()
    {
        return $this->reaction;
    }

    /**
     * Set the value of reaction
     *
     * @return  self
     */ 
    public function setReaction($reaction)
    {
        $this->reaction = $reaction;

        return $this;
    }


}