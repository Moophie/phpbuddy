<?php

namespace classes\Buddy;

class Upvote
{
    private $id;
    private $post_id;
    private $user_id;


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
     * Get the value of id
     */
    public function getPost_id()
    {
        return $this->post_id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setPost_id($post_id)
    {
        $this->post_id = $post_id;

        return $this;
    }


    /**
     * Get the value of id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function saveUpvote()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO upvotes (post_id, user_id) VALUES (:post_id, :user_id)");
        $statement->bindValue(":post_id", $this->getPost_Id());
        $statement->bindValue(":user_id", $this->getUser_Id());
        $statement->execute();
    }

    public function deleteUpvote()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("DELETE FROM upvotes WHERE post_id= :post_id AND user_id = :user_id");
        $statement->bindValue(":post_id", $this->getPost_Id());
        $statement->bindValue(":user_id", $this->getUser_Id());
        $statement->execute();
    }
}
