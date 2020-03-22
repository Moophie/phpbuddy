<?php 

include_once(__DIR__ . "./Db.php");

class User {

    private $fullname;
    private $email;
    private $password;



      /**
     * Get the value of fullname
     */ 
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set the value of fullname
     *
     * @return  self
     */ 
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }


    public function save() {
        //db conn
        $conn = Db::getConnection();
        //insert query
        $statement = $conn->prepare("insert into users (fullname, email, password) values (:fullname, :email, :password)");
        $fullname = $this->getFullname();
        $email = $this->getEmail();
        $password = $this->getPassword();
        
        $statement->bindValue(":fullname", $fullname);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":password", $password);
        //return result
        $result = $statement->execute();

        return $result;
    }

    public static function getAll() {
        //db conn
        $conn = Db::getConnection();

        $statement = $conn->prepare("select * from users");
        
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $users;

    }

}