<?php
include_once(__DIR__ . "/Db.php");

Class Upvote{
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

    public function save(){

        // @todo: hook in a new function that checks if a user has already liked a post

        $conn = Db::getConnection();
        $statement = $conn->prepare("insert into upvotes (post_id, user_id) values (:postid, :userid");
        $statement->bindValue(":postid", $this->getPost_Id());
        $statement->bindValue(":userid", $this->getUser_Id());
        return $statement->execute();
    }
}

?>