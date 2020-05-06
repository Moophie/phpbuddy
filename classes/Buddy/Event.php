<?php

namespace classes\Buddy;

class Event
{
    private $id;
    private $title;
    private $timestamp;
    private $description;
    private $max;
    private $creator;

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
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
        $time = date('Y-m-d H:i:s');

        if((strtotime($timestamp) > strtotime($time) + 60*60)  && (strtotime($timestamp) < strtotime($time) + 60*60*24*365)) {
            $this->timestamp = $timestamp;
            return $this;
        }
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of max
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Set the value of max
     *
     * @return  self
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Get the value of creator
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set the value of creator
     *
     * @return  self
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    public function __construct($event_id = 0)
    {
        //Select all of the event's data from the database
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM events WHERE id = :event_id');
        $statement->bindValue(':event_id', $event_id);
        $statement->execute();
        $event = $statement->fetch(\PDO::FETCH_OBJ);

        //If the search returns a result, set all the objects properties to the properties taken from the database
        if (!empty($event)) {
            $this->id = $event->id;
            $this->title = $event->title;
            $this->timestamp = $event->timestamp;
            $this->description = $event->description;
            $this->max = $event->max;
            $this->creator = $event->creator;
        }
    }

    public function saveEvent()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("INSERT INTO events (title, timestamp, description, max, creator) VALUES (:title, :timestamp, :description, :max, :creator)");

        $statement->bindValue(":title", $this->getTitle());
        $statement->bindValue(":timestamp", $this->getTimestamp());
        $statement->bindValue(":description", $this->getDescription());
        $statement->bindValue(":max", $this->getMax());
        $statement->bindValue(":creator", $this->getCreator());

        $result = $statement->execute();

        return $result;
    }

    public static function getAllEvents()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM events");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function amountParticipants()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM users_events WHERE event_id = :event_id");
        $statement->bindValue(":event_id", $this->getId());
        $statement->execute();
        $count = $statement->rowCount();

        return $count;
    }
}
