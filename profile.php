<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");
$profileImg = User::profileImg();
$bio = User::bio();
$email = strtolower($_SESSION['user']);

function endsWith($string, $endString)
{
  $len = strlen($endString);
  if ($len == 0) {
    return true;
  }
  return (substr($string, -$len) === $endString);
}

if (!empty($_POST['changePassword'])) {

  $newpassword = $_POST['newpassword'];
  $oldpassword = $_POST['oldpassword'];

  if (User::checkPassword($email, $oldpassword)) {
    User::changePassword($newpassword);
    echo "Password changed succesfully!";
  } else {
    echo "We couldn't change the password.";
  }
}

if (!empty($_POST['changeEmail'])) {

  $oldpassword = $_POST['emailpassword'];
  $newemail = $_POST['newemail'];

  if (User::checkPassword($email, $oldpassword)) {
    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $statement->bindValue(":email", $newemail);
    $statement->execute();
    $existingEmails = $statement->rowCount();
    var_dump($existingEmails);

    if ($existingEmails > 0) {
      // Give an error if there is already a similar email in the database
      echo "Email already in use";
    } elseif (!endsWith($email, "student.thomasmore.be")) {
      echo "Not a valid Thomas More email";
    } else {
      User::changeEmail($newemail);
      echo "Email changed succesfully!";
    }
  } else {
    echo "We couldn't change the email.";
  }
}

if (!empty($_POST['updateProfile'])) {
  $user = new User();
  $user->setBio($_POST['bio']);
  $user->setLocation($_POST['location']);
  $user->setGames($_POST['games']);
  $user->setMusic($_POST['music']);
  $user->setFilms($_POST['films']);
  $user->setBooks($_POST['books']);
  $user->setStudy_pref($_POST['study_pref']);
  $user->setHobby($_POST['hobby']);
  $user->completeProfile();
}

if (!empty($_POST['changeStatus'])) {
  User::changeBuddyStatus($_POST['buddyStatus']);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="css/bootstrap.css">
</head>

<body>
  <div class="float-left" style="margin-left:20px;">
    <form action="" method="POST" class="border rounded" style="padding:20px; width:500px;">
      <h1>About me</h1>
      <div class="form-group">
        <label for="bio">Biography</label>
        <textarea name="bio" id="bio" cols="30" rows="10" class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="location">Location</label>
        <input type="text" id="location" name="location" class="form-control">
      </div>
      <div class="form-group">
        <label for="games">Games</label>
        <input type="text" id="games" name="games" class="form-control">
      </div>
      <div class="form-group">
        <label for="music">Music</label>
        <input type="text" id="music" name="music" class="form-control">
      </div>
      <div class="form-group">
        <label for="films">Films</label>
        <input type="text" id="films" name="films" class="form-control">
      </div>
      <div class="form-group">
        <label for="books">Books</label>
        <input type="text" id="books" name="books" class="form-control">
      </div>
      <div class="form-group">
        <label for="hobby">Hobby</label>
        <input type="text" id="hobby" name="hobby" class="form-control">
      </div>
      <div class="form-group">
        <p>Study Preference</p>
        <div class="form-check">
          <input type="radio" id="design" name="study_pref" class="form-check-input" value="design">
          <label for="design" class="form-check-label">Design</label>
        </div>
        <div class="form-check">
          <input type="radio" id="development" name="study_pref" class="form-check-input" value="development">
          <label for="development" class="form-check-label">Development</label>
        </div>
        <div class="form-check">
          <input type="radio" id="undecided" name="study_pref" class="form-check-input" value="undecided" checked>
          <label for="undecided" class="form-check-label">Undecided</label>
        </div>
      </div>
      <div class="form-group">
        <input type="submit" value="Submit" name="updateProfile">
      </div>
    </form>
  </div>

  <div class="float-left" style="margin-left:20px;">
    <h1>Profile Image</h1>
    <img src="uploads/<?php echo $profileImg; ?>" width="500px;" />

    <form enctype="multipart/form-data" action="uploadProfileImg.php" method="POST">
      <input type="file" name="profileImg" capture="camera" required /><br>
      <input type="submit" value="upload" name="uploadPicture" />
    </form>

    <form action="" method="POST" class="border rounded" style="padding:20px; width:500px;">
      <div class="form-group">
        <div class="form-check">
          <input type="radio" id="firstyear" name="buddyStatus" class="form-check-input" value="firstyear">
          <label for="firstyear" class="form-check-label">I'm a first year student looking for a buddy.</label>
        </div>
        <div class="form-check">
          <input type="radio" id="mentor" name="buddyStatus" class="form-check-input" value="mentor">
          <label for="mentor" class="form-check-label">I'm a second or third year student looking to mentor someone.</label>
        </div>
      </div>
      <input type="submit" value="Save" name="changeStatus">
    </form>
  </div>

  <div class="float-left" style="margin-left:20px;">
    <h1>Settings</h1>

    <form method="POST" action="">
      <div class="form-group">
        <label for=emailpassword">Current password</label>
        <input type="password" name="emailpassword" id="emailpassword" class="form-control">
      </div>
      <div class="form-group">
        <label for="newemail">New email</label>
        <input type="email" name="newemail" id="newemail" class="form-control">
      </div>
      <input type="submit" value="Save" name="changeEmail">

      <form method="POST" action="">
        <div class="form-group">
          <label for="oldpassword">Current password</label>
          <input type="password" name="oldpassword" id="oldpassword" class="form-control">
        </div>
        <div class="form-group">
          <label for="newpassword">New password</label>
          <input type="password" name="newpassword" id="newpassword" class="form-control">
        </div>
        <input type="submit" value="Save" name="changePassword">
      </form>
    </form>
  </div>
  <div class="float-left" style="margin-left:20px;">
    <a href="index.php">Back to Home</a>
  </div>

</body>

</html>