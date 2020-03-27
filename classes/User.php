<?php

include_once(__DIR__ . "/Db.php");

class User
{
    private $fullname;
    private $email;
    private $password;
    private $profileImg;
    private $bio;
    private $location;
    private $games;
    private $music;
    private $films;
    private $books;
    private $study_pref;
    private $hobby;


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

    /**
     * Get the value of location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of location
     *
     * @return  self
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of games
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Set the value of games
     *
     * @return  self
     */
    public function setGames($games)
    {
        $this->games = $games;

        return $this;
    }

    /**
     * Get the value of music
     */
    public function getMusic()
    {
        return $this->music;
    }

    /**
     * Set the value of music
     *
     * @return  self
     */
    public function setMusic($music)
    {
        $this->music = $music;

        return $this;
    }

    /**
     * Get the value of films
     */
    public function getFilms()
    {
        return $this->films;
    }

    /**
     * Set the value of films
     *
     * @return  self
     */
    public function setFilms($films)
    {
        $this->films = $films;

        return $this;
    }

    /**
     * Get the value of books
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * Set the value of books
     *
     * @return  self
     */
    public function setBooks($books)
    {
        $this->books = $books;

        return $this;
    }

    /**
     * Get the value of study_pref
     */
    public function getStudy_pref()
    {
        return $this->study_pref;
    }

    /**
     * Set the value of study_pref
     *
     * @return  self
     */
    public function setStudy_pref($study_pref)
    {
        $this->study_pref = $study_pref;

        return $this;
    }

    /**
     * Get the value of hobby
     */
    public function getHobby()
    {
        return $this->hobby;
    }

    /**
     * Set the value of hobby
     *
     * @return  self
     */
    public function setHobby($hobby)
    {
        $this->hobby = $hobby;

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

    public static function profileImg()
    {
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
        session_start();

       $conn = Db::getConnection();

        if (isset($_POST['submit'])) {
            $email = $_SESSION['user'];
            $oldpassword = ($_POST['oldpassword']);
            $newpassword = ($_POST['newpassword']);

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
            session_start();

            $conn = Db::getConnection();
    
            if(isset($_POST['submit'])){
                $newemail = strtolower($_POST['email']);
                $email = $_SESSION['user'];
                $password = ($_POST['password']);
    
                if(empty($password)){
                    echo "<font color='red'>Password field is empty!</font><br/>";
                }else{
    
                    $insert = $conn->prepare("UPDATE users SET email = :newemail WHERE email = :email");
                    $insert->bindValue(':email', $email);
                    $insert->bindValue(':newemail', $newemail);
                    $insert->execute();

                    $_SESSION['user'] = $newemail;
                    header('Location:profile.php');
                }
                return $insert;
            }
        }

    //Function that updates profile in the database
    public function completeProfile()
    {
        //Database connection
        $conn = Db::getConnection();

        $email = $_SESSION['user'];

        //Prepare the INSERT query
        $statement = $conn->prepare("UPDATE users SET location = :location, games = :games, music = :music, films = :films, books = :books, study_pref = :study_pref, hobby = :hobby WHERE email = :email");

        //Put object values into variables
        $location = $this->getLocation();
        $games = $this->getGames();
        $music = $this->getMusic();
        $films = $this->getFilms();
        $books = $this->getBooks();
        $study_pref = $this->getStudy_pref();
        $hobby = $this->getHobby();

        //Bind variables to parameters from prepared query
        $statement->bindValue(":location", $location);
        $statement->bindValue(":games", $games);
        $statement->bindValue(":music", $music);
        $statement->bindValue(":films", $films);
        $statement->bindValue(":books", $books);
        $statement->bindValue(":study_pref", $study_pref);
        $statement->bindValue(":hobby", $hobby);
        $statement->bindValue(":email", $email);

        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }

    // Function to check if profile is complete

    public static function checkProfileComplete(){
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT profileImg, bio, location, games, music, films, books, study_pref, hobby FROM users WHERE email = :email");
        $statement->bindValue(":email", $_SESSION['user']);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_OBJ);
        
        if(!empty($result->profileImg) && !empty($result->bio) && !empty($result->location) && !empty($result->games) && !empty($result->music) && !empty($result->films) && !empty($result->books) && !empty($result->study_pref) && !empty($result->hobby)){
            return true;
        } else {
            return false;
        }

    }
}
