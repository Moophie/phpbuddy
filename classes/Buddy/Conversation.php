<?php

namespace classes\Buddy;

class Conversation
{
    private $id;
    private $user_1;
    private $user_2;
    private $active;


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
     * Get the value of user_1
     */
    public function getUser_1()
    {
        return $this->user_1;
    }

    /**
     * Set the value of user_1
     *
     * @return  self
     */
    public function setUser_1($user_1)
    {
        $this->user_1 = $user_1;

        return $this;
    }

    /**
     * Get the value of user_2
     */
    public function getUser_2()
    {
        return $this->user_2;
    }

    /**
     * Set the value of user_2
     *
     * @return  self
     */
    public function setUser_2($user_2)
    {
        $this->user_2 = $user_2;

        return $this;
    }

    /**
     * Get the value of active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    public function saveConversation()
    {
        //Check if the conversation already exists
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id FROM conversations WHERE (user_1 = :user_1 AND user_2 = :user_2) OR (user_1 = :user_2 AND user_2 = :user_1)");
        $statement->bindValue(":user_1", $this->getUser_1());
        $statement->bindValue(":user_2", $this->getUser_2());
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_OBJ);

        if (empty($result)) :
            //If it doesn't create a new conversation
            $statement = $conn->prepare("INSERT INTO conversations (user_1, user_2, active) VALUES (:user_1, :user_2, 1)");
            $statement->bindValue(":user_1", $this->getUser_1());
            $statement->bindValue(":user_2", $this->getUser_2());
            $statement->execute();
        else :
            //If it already exists, update the conversation to active
            $statement = $conn->prepare("UPDATE conversations SET active = 1 WHERE (user_1 = :user_1 AND user_2 = :user_2) OR (user_1 = :user_2 AND user_2 = :user_1)");
            $statement->bindValue(":user_1", $this->getUser_1());
            $statement->bindValue(":user_2", $this->getUser_2());
            $statement->execute();

        endif;

        return $result;
    }

    //Function that gets all messages from the current conversation
    public function getMessages()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT messages.id, messages.sender_id, messages.receiver_id, messages.content, messages.reaction, messages.timestamp, messages.message_read, users.fullname FROM messages, users WHERE messages.sender_id = users.id AND conversation_id = :conversation_id ORDER BY messages.id ASC");
        $statement->bindValue(":conversation_id", $this->getId());
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    //Function that updates the messages to be "read" when they're displayed on the user's page
    public function readMessages($user_id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE messages SET message_read = 1 WHERE conversation_id = :conversation_id AND receiver_id = :user_id");
        $statement->bindValue(":conversation_id", $this->getId());
        $statement->bindValue(":user_id", $user_id);
        $statement->execute();
    }

    //Function that grabs the chat-partners name and id
    public function getPartner($user_id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT users.fullname, users.id FROM conversations, users WHERE (conversations.user_1 = users.id OR conversations.user_2 = users.id) AND conversations.id = :conversation_id AND users.id <> :user_id");
        $statement->bindValue(":conversation_id", $this->getId());
        $statement->bindValue(":user_id", $user_id);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_OBJ);

        return $result;
    }
}
