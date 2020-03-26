<?php
   include_once(__DIR__ . "/Db.php");


class User{
    private $fullname;
    private $email;
    private $password;
    private $profileImg;
    private $bio;

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
      /**
     * Get the value of bio
     */ 
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set the value of bio
     *
     * @return  self
     */ 
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }
    



     //Function that inserts users into the database
     public function save()
     {
         //Database connection
         $conn = Db::getConnection();
 
         //Prepare the INSERT query
         $statement = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)");
 
         //Put object values into variables
         $fullname = $this->getFullname();
         $email = $this->getEmail();
         $password = $this->getPassword();
 
         //Bind variables to parameters from prepared query
         $statement->bindValue(":fullname", $fullname);
         $statement->bindValue(":email", $email);
         $statement->bindValue(":password", $password);
 
         //Execute query
         $result = $statement->execute();
 
         //Return the results from the query
         return $result;
     }
 
     //Function that fetches all users from the database
     public static function getAll()
     {
         //Database connection
         $conn = Db::getConnection();
 
         //Prepare and executestatement
         $statement = $conn->prepare("select * from users");
         $statement->execute();
 
         //Fetch all rows as an array indexed by column name
         $users = $statement->fetchAll(PDO::FETCH_ASSOC);
 
         //Return the result from the query
         return $users;
     }
 

    /************PROFILE IMAGE SEARCH*************/

    public static function profileImg(){
        session_start();
        $conn = Db::getConnection();

        $statement = $conn->prepare('SELECT profileImg FROM users WHERE email = :email');
        $email = $_SESSION['user'];
        $statement->bindValue(':email', $email);
        $statement->execute();
        $profileImg = $statement->fetch(PDO::FETCH_COLUMN);

        return $profileImg;
    }



    public static function bio(){
        $conn = Db::getConnection();

        $statement = $conn->prepare('SELECT bio FROM users WHERE email = :email');
        $email = $_SESSION['user'];
        $statement->bindValue(':email', $email);
        $statement->execute();
        $bio = $statement->fetch(PDO::FETCH_COLUMN);

        return $bio;
    }

    public static function updateBio()
    {
        $conn = Db::getConnection();

        if (isset($_POST['submit'])) {
            $bio = htmlspecialchars($_POST['bio']);

            if (empty($bio)) {
                echo '<p Write something nice! (or not)</p><br/>';
            } else {

                $insert = $conn->prepare('UPDATE users SET bio = :bio WHERE email = :email');
                $email = $_SESSION['user'];
                $insert->bindValue(':bio', $bio);
                $insert->bindValue(':email', $email);
                $insert->execute();
            }

            return $insert;
        }
    }
 

 
    public static function changePassword()
    {
        //session_start();

       $conn = Db::getConnection();

        if (isset($_POST['submit'])) {
            $email = $_SESSION['user'];
            $oldpassword = htmlspecialchars($_POST['oldpassword']);
            $newpassword = htmlspecialchars($_POST['newpassword']);

            $new = password_hash($newpassword, PASSWORD_BCRYPT);

            if (empty($oldpassword)) {
                echo "<font color='red'>Old password is empty!</font><br/>";
            } else {
                $insert = $conn->prepare("UPDATE users SET password = :newpassword WHERE email = :email");
                $insert->bindValue(':email', $email);
                $insert->bindValue(':newpassword', $new);
                $insert->execute();
                header('Location:profile.php');
            }

            return $insert;
        }
    }

    
        public static function changeEmail(){
            $conn = Db::getConnection();
    
            if(isset($_POST['submit'])){
                $email = $_SESSION['user'];
                $password = htmlspecialchars($_POST['password']);
    
                if(empty($password)){
                    echo "<font color='red'>Password field is empty!</font><br/>";
                }else{
    
                    $insert = $conn->prepare("UPDATE users SET email = ('".$_POST['email']."') WHERE email = :email");
                    $insert->bindValue(':email', $email);
                    $insert->execute();
                    header('Location:profile.php');
                }
                return $insert;
            }
        }
  
}

?>