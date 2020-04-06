<?php
include_once(__DIR__ . "/classes/User.php");

session_start();
$user = new User();

if (!empty($_SESSION['user'])) {
    $username = $_SESSION['user'];
} else {

    // If there's no active session, redirect to login.php
    header("Location: login.php");
}


function getbuddy(){
    $user = new User();

    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT id, buddy_status, fullname, profileImg FROM users");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_OBJ);

    return $result;

}


/*$submitbutton= $_POST['submitbutton'];

if (!empty($submitbutton)){
    function foundbuddy(){
        $user = new User();

        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE users SET buddy_id = id");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
    
        return $result;

    }

}
else {

}

*/

function getMessages()
{
    $user = new User();

    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT messages.content, users.fullname FROM messages, users WHERE messages.sender_id =  users.id ORDER BY messages.id ASC");
    $statement->bindValue(":sender_id", $user->getId());
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_OBJ);

    return $result;
}

if (isset($_POST['sendMessage'])) {
    ?> 
    <script>
    alert("you got a message");
  </script>
  <?php


    $user = new User();

    $sender = $user->getId();
    $receiver = $user->getBuddy_id();
    $content = $_POST['content'];

    $conn = Db::getConnection();
    $statement = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, content) VALUES (:sender_id, :receiver_id, :content)");
    $statement->bindValue(":sender_id", $sender);
    $statement->bindValue(":receiver_id", $receiver);
    $statement->bindValue(":content", $content);
    $result = $statement->execute();

    header("Location: buddy.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
    <title>IMD Buddy</title>
    <style>
        .dropbtn {
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropbtn i {
            margin-right: 5px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #343A40;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #68717a;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">IMD Buddy</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <div class="dropdown">

                                <a class="dropbtn">
                                    <i class="fas fa-user"></i>
                                    <?php
                                    // Don't forget to htmlspecialchars() when using inputted variables in your code
                                    echo htmlspecialchars($username);
                                    ?>
                                </a>
                                <div class="dropdown-content">
                                    <a href="profile.php">Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="logout.php">Log out</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </span>
            </div>
        </div>
    </nav>


<div id="buddy" style="background-color: white; display: inline-block;margin-left: 10%">
    <?php
            $users = getbuddy();
            foreach ($users as $user) {
                echo "<br>";
                echo $user->fullname;
                echo "<br>";
                ?>   <img src=  "uploads/<?php echo $user->profileImg; ?>" alt="profileImg" style="width: 200px">  <?php
                
                echo "<br>";
                echo $user->buddy_status;
                echo "<br>";
                ?> <form action="" method="POST">
                <input type="submit" name="submitbutton" value="get buddy"/>
                </form> <?php
                echo "<br>";

            }
    ?>

</div>
    
<div id="messages" style="background-color: white;  width:300px; display: inline-block; margin-left: 30%; margin-top: 10%;" >
    <h2>Messages</h2>
    <p>
        <?php
        $messages = getMessages();
        foreach ($messages as $message) {
            echo "<br>";
            echo $message->fullname;
            echo "<br>";
            echo $message->content;

        }
        ?>
    </p>

    <form action="" method="POST">
        <textarea name="content" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="Send message" name="sendMessage">

    </form>
    </div>





</body>
</html>

