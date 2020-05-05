<?php

namespace classes\Buddy;

class classroom
{
    private $id;
    private $name;
    private $building;
    private $floor;
    private $room_number;

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
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of building
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set the value of building
     *
     * @return  self
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get the value of floor
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set the value of floor
     *
     * @return  self
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get the value of room_number
     */
    public function getRoom_number()
    {
        return $this->room_number;
    }

    /**
     * Set the value of room_number
     *
     * @return  self
     */
    public function setRoom_number($room_number)
    {
        $this->room_number = $room_number;

        return $this;
    }

    public static function getClassrooms($search)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM classrooms WHERE name LIKE concat('%', :search, '%')");
        $statement->bindValue(":search", $search);
        $statement->execute();
        $search = $statement->fetchAll();

        return $search;
    }

    public static function completeSearch($keyword)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM classrooms WHERE name LIKE :keyword ORDER BY id LIMIT 5");
        $statement->bindValue(":keyword", $keyword);
        $statement->execute();
        $classrooms = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $classrooms;
    }
}
