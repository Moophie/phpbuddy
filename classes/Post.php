<?php

include_once(__DIR__ . "/Db.php");

class Post
{

    private $id;
    private $op;
    private $timestamp;
    private $content;
    private $faq;


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
     * Get the value of op
     */
    public function getOp()
    {
        return $this->op;
    }

    /**
     * Set the value of op
     *
     * @return  self
     */
    public function setOp($op)
    {
        $this->op = $op;

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
     * Get the value of faq
     */
    public function getFaq()
    {
        return $this->faq;
    }

    /**
     * Set the value of faq
     *
     * @return  self
     */
    public function setFaq($faq)
    {
        $this->faq = $faq;

        return $this;
    }

    public function savePost()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("INSERT INTO posts (op, timestamp, content, faq) VALUES (:op, :timestamp, :content, 0)");

        $statement->bindValue(":op", $this->getOp());
        $statement->bindValue(":timestamp", $this->getTimestamp());
        $statement->bindValue(":content", $this->getContent());

        $result = $statement->execute();

        return $result;
    }

    public function pinPost($pin)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("UPDATE posts SET faq = :faq WHERE id = :id");

        $statement->bindValue(":id", $this->getId());
        $statement->bindValue(":faq", $pin);
        $result = $statement->execute();

        return $result;
    }

    public static function getAllPosts()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM posts");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    public static function getFaqPosts()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM posts WHERE faq = 1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        
        return $result;
    }
    
}
