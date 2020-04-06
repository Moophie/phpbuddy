<?php
include_once(__DIR__ . "/classes/User.php");

session_start();
$user = new User();


function getbuddy(){
    $user = new User();

    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT id, buddy_status, fullname, profileImg FROM users");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_OBJ);

    return $result;

}


$submitbutton= $_POST['submitbutton'];

if (!empty($submitbutton)){
    function fountbuddy(){
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
    <title>Document</title>
</head>
<body>

<div id="buddy">
    <?php
            $users = getbuddy();
            foreach ($users as $user) {
                echo "<br>";
                echo $user->fullname;
                echo "<br>";
                echo $user->profileImg;
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
    
<div id="messages" style="background-color: white;  width:300px" >
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
    </div>

    <form action="" method="POST">
        <textarea name="content" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="Send message" name="sendMessage">
    </form>



</body>
</html>

