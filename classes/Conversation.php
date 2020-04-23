<?php

include_once(__DIR__ . "/Db.php");

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
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id FROM conversations WHERE (user_1 = :user_1 AND user_2 = :user_2) OR (user_1 = :user_2 AND user_2 = :user_1)");
        $statement->bindValue(":user_1", $this->getUser_1());
        $statement->bindValue(":user_2", $this->getUser_2());
        $result = $statement->execute();

        if (empty($result)) :

            $statement = $conn->prepare("INSERT INTO conversations (user_1, user_2, active) VALUES (:user_1, :user_2, 1)");
            $statement->bindValue(":user_1", $this->getUser_1());
            $statement->bindValue(":user_2", $this->getUser_2());
            $statement->execute();

        else:
            
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
        $statement = $conn->prepare("SELECT messages.id, messages.content, messages.reaction, messages.timestamp, users.fullname FROM messages, users WHERE messages.sender_id = users.id AND conversation_id = :conversation_id ORDER BY messages.id ASC");
        $statement->bindValue(":conversation_id", $this->getId());
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }
}
