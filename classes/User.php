<?php
include_once(__DIR__ . "./Db.php");

class User{
    private $profileImg;

    /**
     * Get the value of profileImg
     */ 
    public function getProfileImg()
    {
        return $this->profileImg;
    }

    /**
     * Set the value of profileImg
     *
     * @return  self
     */ 
    public function setProfileImg($profileImg)
    {
        $this->profileImg = $profileImg;

        return $this;
    }

    /************PROFILE IMAGE SEARCH*************/

    public static function profileImg(){
        $conn = Db::getConnection();

        $statement = $conn->prepare('SELECT profileImg FROM users WHERE users.id=:id');
        $statement->bindValue(':id', $id);
        $statement->execute();
        $profileImg = $statement->fetch(PDO::FETCH_COLUMN);

        return $profileImg;
    }

    
}

?>