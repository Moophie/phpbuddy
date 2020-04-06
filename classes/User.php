<?php

include_once(__DIR__ . "/Db.php");

class User
{
    private $id;
    private $buddyStatus;
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
    private $buddy_id;

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
     * Get the value of buddyStatus
     */
    public function getBuddyStatus()
    {
        return $this->buddyStatus;
    }

    /**
     * Set the value of buddyStatus
     *
     * @return  self
     */
    public function setBuddyStatus($buddyStatus)
    {
        $this->buddyStatus = $buddyStatus;

        return $this;
    }

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
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $existingEmails = $statement->rowCount();

        if ($existingEmails > 0) {
            return $error = "Email already in use";
        } elseif (!(substr($email, -22) === "@student.thomasmore.be")) {
            return $error = "Not a valid Thomas More email";
        } else {
            $this->email = $email;
            return $this;
        }
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

    /**
     * Get the value of buddy_id
     */
    public function getBuddy_id()
    {
        return $this->buddy_id;
    }

    /**
     * Set the value of buddy_id
     *
     * @return  self
     */
    public function setBuddy_id($buddy_id)
    {
        $this->buddy_id = $buddy_id;

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
        $statement = $conn->prepare("SELECT * from users");
        $statement->execute();

        //Fetch all rows as an array indexed by column name
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        //Return the result from the query
        return $users;
    }

    //Function that fetches all users from the database
    public function getAllExceptUser()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare and executestatement
        $statement = $conn->prepare("SELECT * FROM users WHERE email <> :email");
        $statement->bindValue(':email', $this->getEmail());
        $statement->execute();

        //Fetch all rows as an array indexed by column name
        $users = $statement->fetchAll(PDO::FETCH_OBJ);

        //Return the result from the query
        return $users;
    }

    public function __construct($email)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_OBJ);

        $this->id = $user->id;
        $this->buddyStatus = $user->buddy_status;
        $this->fullname = $user->fullname;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->profileImg = $user->profileImg;
        $this->bio = $user->bio;
        $this->location = $user->location;
        $this->games = $user->games;
        $this->music = $user->music;
        $this->films = $user->films;
        $this->books = $user->books;
        $this->study_pref = $user->study_pref;
        $this->hobby = $user->hobby;
        $this->buddy_id = $user->buddy_id;
    }

    public function changePassword($newpassword)
    {
        $conn = Db::getConnection();
        $newpassword = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);

        $insert = $conn->prepare("UPDATE users SET password = :newpassword WHERE email = :email");
        $insert->bindValue(':email', $this->getEmail());
        $insert->bindValue(':newpassword', $newpassword);
        $insert->execute();
    }


    public function changeEmail($newemail)
    {
        $conn = Db::getConnection();
        $newemail = strtolower($newemail);

        $insert = $conn->prepare("UPDATE users SET email = :newemail WHERE email = :email");
        $insert->bindValue(':email', $this->getEmail());
        $insert->bindValue(':newemail', $newemail);
        $insert->execute();

        $_SESSION['user'] = $newemail;
    }

    public function changeBuddyStatus($newstatus)
    {
        $conn = Db::getConnection();

        $insert = $conn->prepare("UPDATE users SET buddy_status = :newstatus WHERE email = :email");
        $insert->bindValue(':email', $this->getEmail());
        $insert->bindValue(':newstatus', $newstatus);
        $insert->execute();
    }

    //Function that updates profile in the database
    public function completeProfile()
    {
        //Database connection
        $conn = Db::getConnection();

        $email = $_SESSION['user'];

        //Prepare the INSERT query
        $statement = $conn->prepare("UPDATE users SET bio = :bio, location = :location, games = :games, music = :music, films = :films, books = :books, study_pref = :study_pref, hobby = :hobby WHERE email = :email");

        //Put object values into variables
        $bio = $this->getBio();
        $location = $this->getLocation();
        $games = $this->getGames();
        $music = $this->getMusic();
        $films = $this->getFilms();
        $books = $this->getBooks();
        $study_pref = $this->getStudy_pref();
        $hobby = $this->getHobby();

        //Bind variables to parameters from prepared query
        $statement->bindValue(":bio", $bio);
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

    public function checkProfileComplete()
    {
        if (!empty($this->profileImg) && !empty($this->getBio()) && !empty($this->getLocation()) && !empty($this->getGames()) && !empty($this->getMusic()) && !empty($this->getFilms()) && !empty($this->getBooks()) && !empty($this->getStudy_pref()) && !empty($this->getHobby())) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkPassword($email, $password)
    {
        // Prepared PDO statement that fetches the password corresponding to the inputted email
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT password FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Check if the password is correct
        if (isset($result['password'])) {
            if (password_verify($password, $result['password'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getMatch($potMatch)
    {
        $score = 0;

        if ($this->getLocation() == $potMatch->location){
            $score += 10;
        }

        if ($this->getGames() == $potMatch->games){
            $score += 10;
        }

        if ($this->getMusic() == $potMatch->music){
            $score += 10;
        }

        if ($this->getFilms() == $potMatch->films){
            $score += 10;
        }

        if ($this->getBooks() == $potMatch->books){
            $score += 10;
        }

        if ($this->getHobby() == $potMatch->hobby){
            $score += 10;
        }

        if ($this->getStudy_pref() == $potMatch->study_pref){
            $score += 10;
        }

        if($score >= 20){
            return $potMatch;
        }
    }
}
