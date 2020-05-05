<?php

namespace classes\Buddy;

include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/Conversation.php");

class Message
{
    private $id;
    private $conversation_id;
    private $sender_id;
    private $receiver_id;
    private $content;
    private $timestamp;
    private $message_read;
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
     * Get the value of Conversation_id
     */
    public function getConversation_id()
    {
        return $this->conversation_id;
    }

    /**
     * Set the value of Conversation_id
     *
     * @return  self
     */
    public function setConversation_id($conversation_id)
    {
        $this->conversation_id = $conversation_id;

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
     * Get the value of timestamp
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set the value of timestamp
     *
     * @return  self
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get the value of message_read
     */
    public function getMessage_read()
    {
        return $this->message_read;
    }

    /**
     * Set the value of message_read
     *
     * @return  self
     */
    public function setMessage_read($message_read)
    {
        $this->message_read = $message_read;

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

    public function saveMessage()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("INSERT INTO messages (conversation_id, sender_id, receiver_id, content, timestamp) VALUES (:conversation_id, :sender_id, :receiver_id, :content, :timestamp)");

        $statement->bindValue(":conversation_id", $this->getConversation_id());
        $statement->bindValue(":sender_id", $this->getSender_id());
        $statement->bindValue(":receiver_id", $this->getReceiver_id());
        $statement->bindValue(":content", $this->getContent());
        $statement->bindValue(":timestamp", $this->gettimestamp());

        $result = $statement->execute();

        return $result;
    }

    public static function reaction()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE messages SET reaction = :reaction WHERE id = :message_id ");
        $statement->bindValue(":reaction",  $_POST['data_reaction']);
        $statement->bindValue(":message_id", $_POST['message_id']);
        $result = $statement->execute();
        return $result;
    }

    public static function undoReaction()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE messages SET reaction = :reaction WHERE id = :message_id ");
        $statement->bindValue(":reaction",  "");
        $statement->bindValue(":message_id", $_POST['message_id']);
        $result = $statement->execute();
        return $result;
    }
}
