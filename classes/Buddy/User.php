<?php

namespace classes\Buddy;

class User
{
    private $id;
    private $active;
    private $validation_string;
    private $buddy_status;
    private $fullname;
    private $email;
    private $password;
    private $profile_img;
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
     * Get the value of validation_string
     */
    public function getValidation_string()
    {
        return $this->validation_string;
    }

    /**
     * Set the value of validation_string
     *
     * @return  self
     */
    public function setValidation_string($validation_string)
    {
        $this->validation_string = $validation_string;

        return $this;
    }

    /**
     * Get the value of active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the value of buddy_status
     */
    public function getBuddy_status()
    {
        return $this->buddy_status;
    }

    /**
     * Set the value of buddy_status
     *
     * @return  self
     */
    public function setBuddy_status($buddy_status)
    {
        $this->buddy_status = $buddy_status;

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
        $existing_emails = $statement->rowCount();

        //Check if the email is unique
        if ($existing_emails > 0) {
            return $error = "Email already in use";

            //Check if the email ends on student.thomasmore.be
        } elseif (!(substr($email, -22) === "@student.thomasmore.be")) {
            return $error = "Not a valid Thomas More email";
        } else {

            //If it's unique and ends on student.thomasmore.be, save the property
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
        //Encrypt the password
        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of profile_img
     */
    public function getProfile_img()
    {
        return $this->profile_img;
    }

    /**
     * Set the value of profile_img
     *
     * @return  self
     */
    public function setProfile_img($profile_img)
    {
        $this->profile_img = $profile_img;

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

    public static function getAll()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare and executestatement
        $statement = $conn->prepare("SELECT email, fullname, profile_img from users");
        $statement->execute();

        //Fetch all rows as an array indexed by column name
        $users = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the result from the query
        return $users;
    }

    //Function that inserts users into the database
    public function save()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("INSERT INTO users (active, validation_string, fullname, email, password) VALUES (0, :validation_string, :fullname, :email, :password)");

        //Bind values to parameters from prepared query
        $statement->bindValue(":validation_string", $this->getValidation_string());
        $statement->bindValue(":fullname", $this->getFullname());
        $statement->bindValue(":email", $this->getEmail());
        $statement->bindValue(":password", $this->getPassword());

        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }

    //Magic function __construct that gets called every time a new User() is made
    //Takes one argument: $email which is used to determine what user is taken from the database
    public function __construct($email)
    {

        //Select all of the user's data from the database
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_OBJ);

        //If the search returns a result, set all the objects properties to the properties taken from the database
        if (!empty($user)) {
            $this->id = $user->id;
            $this->active = $user->active;
            $this->buddy_status = $user->buddy_status;
            $this->fullname = $user->fullname;
            $this->email = $user->email;
            $this->password = $user->password;
            $this->profile_img = $user->profile_img;
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
    }

    //Function that changes the password
    public function changePassword($new_password)
    {
        $conn = Db::getConnection();

        //Encrypt the password
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        $insert = $conn->prepare("UPDATE users SET password = :new_password WHERE email = :email");
        $insert->bindValue(':email', $this->getEmail());
        $insert->bindValue(':new_password', $new_password);
        $insert->execute();
    }

    //Function that changes the email
    public function changeEmail($new_email)
    {
        $conn = Db::getConnection();

        //Make email case insensitive
        $new_email = strtolower($new_email);

        $insert = $conn->prepare("UPDATE users SET email = :new_email WHERE email = :email");
        $insert->bindValue(':email', $this->getEmail());
        $insert->bindValue(':new_email', $new_email);
        $insert->execute();

        //Set the $_SESSION['user'] to the new email, otherwise everything breaks
        $_SESSION['user'] = $new_email;
    }

    //Function that changes the buddy_status
    public function changeBuddy_status($new_status)
    {
        $conn = Db::getConnection();

        $insert = $conn->prepare("UPDATE users SET buddy_status = :new_status WHERE email = :email");
        $insert->bindValue(':email', $this->getEmail());
        $insert->bindValue(':new_status', $new_status);
        $insert->execute();
    }

    //Function that updates profile in the database
    public function completeProfile()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("UPDATE users SET bio = :bio, location = :location, games = :games, music = :music, films = :films, books = :books, study_pref = :study_pref, hobby = :hobby WHERE email = :email");

        //Bind values to parameters from prepared query
        $statement->bindValue(":bio", $this->getBio());
        $statement->bindValue(":location", $this->getLocation());
        $statement->bindValue(":games", $this->getGames());
        $statement->bindValue(":music", $this->getMusic());
        $statement->bindValue(":films", $this->getFilms());
        $statement->bindValue(":books", $this->getBooks());
        $statement->bindValue(":study_pref", $this->getStudy_pref());
        $statement->bindValue(":hobby", $this->getHobby());
        $statement->bindValue(":email", $_SESSION['user']);

        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }

    //Function to check if profile is complete
    public function checkProfileComplete()
    {
        //If nothing is empty, return true
        if (!empty($this->profile_img) && !empty($this->getBio()) && !empty($this->getLocation()) && !empty($this->getGames()) && !empty($this->getMusic()) && !empty($this->getFilms()) && !empty($this->getBooks()) && !empty($this->getStudy_pref()) && !empty($this->getHobby())) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkPassword($email, $password)
    {
        //Prepared \PDO statement that fetches the password corresponding to the inputted email
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT password FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        //Check if the password is correct
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

    //Function that searches the database based on filters
    public static function searchUsers($filters)
    {

        //The base SQL query if no filters are inputted
        $sql = "SELECT * FROM users WHERE 1=1";

        //Add each $filter that is found in the $filters array (based on $_POST values)
        foreach ($filters as $key => $filter) {
            if (!empty($filter)) {

                //Construct the parameter
                $parameter = ":" . $key;

                //Add the filter and the parameter to the SQL query string
                $sql .= " AND $key LIKE $parameter";
            }
        }

        $conn = Db::getConnection();

        //Prepare the constructed SQL string
        $statement = $conn->prepare($sql);

        //For each $filter, bind the value to the parameter
        //Can't be merged with other foreach, because this happens after the prepare(), while the string construction has to happen before the prepare()
        foreach ($filters as $key => $filter) {
            if (!empty($filter)) {
                $filter = "%" . $filter . "%";
                $parameter = ":" . $key;
                $statement->bindValue($parameter, $filter);
            }
        }

        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    //Function that fetches all users from the database except for the active user
    public function getAllExceptUser()
    {
        $conn = Db::getConnection();

        //<> is the same as !=
        $statement = $conn->prepare("SELECT * FROM users WHERE email <> :email");
        $statement->bindValue(':email', $this->getEmail());
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $users;
    }

    //Function that checks if a user matches the active user
    public function getMatch($potential_match)
    {
        $score = 0;

        //For every similar property, add to the score
        //Weight of every similarity can be changed by just adjusting the score added

        if ($this->getLocation() == $potential_match->location) {
            $score += 10;
        }

        if ($this->getGames() == $potential_match->games) {
            $score += 10;
        }

        if ($this->getMusic() == $potential_match->music) {
            $score += 10;
        }

        if ($this->getFilms() == $potential_match->films) {
            $score += 10;
        }

        if ($this->getBooks() == $potential_match->books) {
            $score += 10;
        }

        if ($this->getHobby() == $potential_match->hobby) {
            $score += 10;
        }

        if ($this->getStudy_pref() == $potential_match->study_pref) {
            $score += 15;
        }

        //If the score is above a certain number, return the potential match as an object
        //The number can be changed according to how similar the matches have to be
        if ($score >= 20) {
            return $potential_match;
        }
    }

    //Function that finds the user's buddy via his email
    public static function findBuddy($email)
    {
        $conn = Db::getConnection();

        //SQL that selects the user's buddy_id
        $statement = $conn->prepare("SELECT buddy_id FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_OBJ);

        //SQL that uses that buddy_id to select the name and image of that user's buddy
        $statement = $conn->prepare("SELECT * FROM users WHERE id = :buddy_id");
        $statement->bindValue(":buddy_id", $result->buddy_id);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_OBJ);

        return $result;
    }

    public static function totalRegistration()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare and executestatement
        $statement = $conn->prepare("SELECT id FROM users");
        $statement->execute();

        //Fetch all rows as an array indexed by column name
        $users = $statement->fetchAll(\PDO::FETCH_OBJ);

        //count all users
        $total_registration = count($users);

        //Return the result from the query
        return $total_registration;
    }

    public static function totalBuddies()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare and executestatement
        $statement = $conn->prepare("SELECT * FROM users WHERE buddy_id >= 1");
        $statement->execute();

        //Fetch all rows as an array indexed by column name
        $users = $statement->fetchAll(\PDO::FETCH_OBJ);

        $count = 0;

        foreach ($users as $user) {
            $statement = $conn->prepare("SELECT * FROM users WHERE id = :buddy_id AND buddy_id = :user_id");
            $statement->bindValue(":buddy_id", $user->buddy_id);
            $statement->bindValue(":user_id", $user->id);
            $statement->execute();
            $result = $statement->fetch();

            if (!empty($result)) {
                $count += 1;
            }
        }

        //Divide by 2 to get amount of buddy relations
        $total_buddy_relations = $count / 2;

        //Return the result from the query
        return $total_buddy_relations;
    }

    public function getActiveConversations()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM conversations WHERE (user_1 = :user_id OR user_2 = :user_id) AND active = 1");
        $statement->bindValue(":user_id", $this->getId());
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_OBJ);

        return $result;
    }

    public function updateBuddy()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE users SET buddy_id = :buddy_id WHERE email = :email");
        $statement->bindValue(":buddy_id", $_POST['buddy_id']);
        $statement->bindValue(":email", $this->getEmail());
        $update = $statement->execute();

        return $update;
    }

    public function removeBuddy()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE users SET buddy_id = 0 WHERE email = :email");
        $statement->bindValue(":email", $_POST['buddy_email']);
        $remove = $statement->execute();
        return $remove;
    }

    public function removeConversation()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE conversations SET active = 0 WHERE user_1 = :user_id OR user_2 = :user_id");
        $statement->bindValue(":user_id", $this->getId());
        $remove = $statement->execute();
        return $remove;
    }

    public function unmatch()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE users SET buddy_id = 0 WHERE email = :email OR id = :buddy_id");
        $statement->bindValue(":buddy_id", $this->getBuddy_id());
        $statement->bindValue(":email", $this->getEmail());
        $unmatch = $statement->execute();
        return $unmatch;
    }

    public function saveProfile_img()
    {
        $fileName = $_FILES['profile_img']['name'];
        $fileTmpName = $_FILES['profile_img']['tmp_name'];
        //$fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['profile_img']['error'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                $fileDestination = 'uploads/' . $fileName;
                move_uploaded_file($fileTmpName, $fileDestination);

                $conn = Db::getConnection();
                $statement = $conn->prepare("UPDATE users  SET profile_img = ('" . $_FILES['profile_img']['name'] . "') WHERE email = :email");
                $statement->bindValue(":email", $this->getEmail());
                $img = $statement->execute();
                return $img;
            }
        } else {
            throw new \Exception("Your image is too big or isn't a image!");
        }
    }

    public static function verify()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE users SET active = 1 WHERE validation_string = :validation_string");
        $statement->bindValue(":validation_string", $_GET["code"]);
        $return = $statement->execute();
        return $return;
    }

    public function joinEvent($event_id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("INSERT INTO users_events (user_id, event_id) VALUES (:user_id, :event_id)");

        $statement->bindValue(":user_id", $this->getId());
        $statement->bindValue(":event_id", $event_id);

        $result = $statement->execute();

        return $result;
    }

    public function checkJoinedEvent($event_id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM users_events WHERE user_id = :user_id AND event_id = :event_id");
        $statement->bindValue(":user_id", $this->getId());
        $statement->bindValue(":event_id", $event_id);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_OBJ);

        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUnreadMessages()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id FROM messages WHERE receiver_id = :user_id AND message_read = 0");
        $statement->bindValue(":user_id", $this->getId());
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function alreadyUpvoted($post_id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id");
        $statement->bindValue(":post_id", $post_id);
        $statement->bindValue(":user_id", $this->getId());
        $statement->execute();
        $count = $statement->rowCount();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}
