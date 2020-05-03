<?php

include_once(__DIR__ . "/Db.php");

class Post
{

    private $id;
    private $op;
    private $timestamp;
    private $content;
    private $faq;
    private $parent;
    private $upvotes;


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

    /**
     * Get the value of parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the value of parent
     *
     * @return  self
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get the value of upvotes
     */ 
    public function getUpvotes()
    {
        return $this->upvotes;
    }

    /**
     * Set the value of upvotes
     *
     * @return  self
     */ 
    public function setUpvotes($upvotes)
    {
        $this->upvotes = $upvotes;

        return $this;
    }

    public function __construct($post_id = 0)
    {
        //Select all of the event's data from the database
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM posts WHERE id = :post_id');
        $statement->bindValue(':post_id', $post_id);
        $statement->execute();
        $post = $statement->fetch(PDO::FETCH_OBJ);

        //If the search returns a result, set all the objects properties to the properties taken from the database
        if (!empty($post)) {
            $this->id = $post->id;
            $this->op = $post->op;
            $this->timestamp = $post->timestamp;
            $this->content = $post->content;
            $this->faq = $post->faq;
            $this->parent = $post->parent;
        }
    }

    public function savePost()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("INSERT INTO posts (op, timestamp, content, faq, parent) VALUES (:op, :timestamp, :content, 0, :parent)");

        $statement->bindValue(":op", $this->getOp());
        $statement->bindValue(":timestamp", $this->getTimestamp());
        $statement->bindValue(":content", $this->getContent());
        $statement->bindValue(":parent", $this->getParent());

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

        $statement = $conn->prepare("SELECT * FROM posts WHERE parent = 0 ORDER BY upvotes DESC");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    public static function getFaqPosts()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM posts WHERE faq = 1 ORDER BY upvotes DESC");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    public function deletePost($id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("DELETE FROM posts WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
    }

    public function editPost($id, $content)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE posts SET content = :content WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->bindValue(":content", $content);
        $statement->execute();
    }

    public static function getReactions($post_id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM posts WHERE parent = :post_id ORDER BY upvotes DESC");
        $statement->bindValue(":post_id", $post_id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    public static function countUpvotes($post_id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM upvotes WHERE post_id = :post_id");
        $statement->bindValue(":post_id", $post_id);
        $statement->execute();
        $count = $statement->rowCount();
        return $count;
    }

    public function addUpvote(){
    
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT upvotes FROM posts WHERE id = :post_id");
        $statement->bindValue(":post_id", $this->getId());
        $statement->execute();
        $amountUpvotes = $statement->fetch(PDO::FETCH_OBJ);

        $upvotes = $amountUpvotes->upvotes + 1;
        var_dump($upvotes);

        $statement = $conn->prepare("UPDATE posts SET upvotes = :upvotes WHERE id = :post_id");
        $statement->bindValue(":upvotes", $upvotes);
        $statement->bindValue(":post_id", $this->getId());
        $statement->execute();
    }
}
