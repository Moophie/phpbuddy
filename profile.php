<?php

include_once(__DIR__ . "/bootstrap.include.php");

//If there's no active session, redirect to login.php
if (empty($_SESSION['user'])) {
  header("Location: login.php");
}

//Create a new user based on the active user's email
$user = new classes\Buddy\User($_SESSION['user']);

//Detect a submit to change the password
if (!empty($_POST['changePassword'])) {

  $newpassword = $_POST['newpassword'];
  $oldpassword = $_POST['oldpassword'];

  //Check if the user has the correct password
  if (classes\Buddy\User::checkPassword($user->getEmail(), $oldpassword)) {

    //Change it to the new password
    $user->changePassword($newpassword);
  } else {
    $errorPass = "We couldn't change the password.";
  }
}

//Detect a submit to change the email
if (!empty($_POST['changeEmail'])) {

  $oldpassword = $_POST['emailpassword'];
  $newemail = $_POST['newemail'];

  //Check if the user has the correct password
  if (classes\Buddy\User::checkPassword($user->getEmail(), $oldpassword)) {

    //Use the setter with conditions to set the new email
    $validEmail = $user->setEmail($newemail);

    //If the setter returns an error string, show the error
    if (gettype($validEmail) == "string") {
      $errorMail = $validEmail;
    } else {

      //If the setter returns an object, change the email in the database
      $user->changeEmail($newemail);
    }
  } else {
    $errorMail = "Wrong password";
  }
}

//Detect a submit to update your profile
if (!empty($_POST['updateProfile'])) {
  $user = new classes\Buddy\User($_SESSION['user']);

  //Fill in the user's properties
  $user->setBio($_POST['bio']);
  $user->setLocation($_POST['location']);
  $user->setGames($_POST['games']);
  $user->setMusic($_POST['music']);
  $user->setFilms($_POST['films']);
  $user->setBooks($_POST['books']);
  $user->setStudy_pref($_POST['study_pref']);
  $user->setHobby($_POST['hobby']);

  //Save those properties to the database
  $user->completeProfile();
}

//Detect a submit to change your status firstyear/mentor
if (!empty($_POST['changeStatus'])) {

  //Change the user's status
  $user->changeBuddyStatus($_POST['buddyStatus']);
}

if (!empty($_POST['uploadPicture'])) {
  if (isset($_FILES['profileImg'])) {
    if ($_FILES['profileImg']['error'] > 0) {
      //For error messages: see http://php.net/manual/en/features.fileupload.errors.php
      switch ($_FILES['profileImg']['error']) {
        case 1:
          $msg = 'You can only upload 2MB';
          break;
        default:
          $msg = 'Sorry, uw upload kon niet worden verwerkt.';
          echo "<button onclick=\"location.href='index.php'\">Try again</button>";
      }
    } else {
      //Check MIME TYPE - http://php.net/manual/en/function.finfo-open.php
      $allowedtypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
      $filename = $_FILES['profileImg']['tmp_name'];
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $fileinfo = $finfo->file($filename);

      if (in_array($fileinfo, $allowedtypes)) {

        //Move uploaded file
        $newfilename = 'uploads/' . $_FILES['profileImg']['name'];

        if (move_uploaded_file($_FILES['profileImg']['tmp_name'], $newfilename)) {
          $user->profileImg();

          header('location:profile.php');
        } else {
          $msg = 'Sorry, de upload is mislukt.';
        }
      } else {
        $msg = 'Sorry, enkel afbeeldingen zijn toegestaan.';
      }
    }
  }
}

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/phpbuddy.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap">
  <title>IMD Buddy</title>
</head>

<body>

  <?php include_once("nav.include.php"); ?>

  <div class="container">
    <div class="jumbotron" style=" height:400px; margin:20px;">
      <div class="float-left" style=" margin-left:50px;">
        <img src="./uploads/<?= htmlspecialchars($user->getProfileImg()) ?>" width="250px;" height="250px;" />
        <form enctype="multipart/form-data" action="" method="POST" style="margin-top:10px;">
          <input type="file" name="profileImg" capture="camera" required />
          <br>
          <input type="submit" value="upload" name="uploadPicture" />
        </form>
      </div>
      <div>
        <h2><?= htmlspecialchars($user->getFullname()); ?></h2>
        <h6> Web Developer and Designer </h6>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="jumbotron float-left" style="width:50%; height:950px; margin:20px;">

      <form action="" method="POST">

        <!-- Fill in the input fields with the data from the database -->
        <br>
        <div class="form-group">
          <label for="bio">Biography</label>
          <textarea name="bio" id="bio" class="form-control"><?= htmlspecialchars($user->getBio()) ?></textarea>
        </div>
        <div class="form-group">
          <label for="location">Location</label>
          <input type="text" id="location" name="location" class="form-control" value="<?= htmlspecialchars($user->getLocation()) ?>">
        </div>
        <div class="form-group">
          <label for="games">Games</label>
          <input type="text" id="games" name="games" class="form-control" value="<?= htmlspecialchars($user->getGames()) ?>">
        </div>
        <div class="form-group">
          <label for="music">Music</label>
          <input type="text" id="music" name="music" class="form-control" value="<?= htmlspecialchars($user->getMusic()) ?>">
        </div>
        <div class="form-group">
          <label for="films">Films</label>
          <input type="text" id="films" name="films" class="form-control" value="<?= htmlspecialchars($user->getFilms()) ?>">
        </div>
        <div class="form-group">
          <label for="books">Books</label>
          <input type="text" id="books" name="books" class="form-control" value="<?= htmlspecialchars($user->getBooks()) ?>">
        </div>
        <div class="form-group">
          <label for="hobby">Hobby</label>
          <input type="text" id="hobby" name="hobby" class="form-control" value="<?= htmlspecialchars($user->getHobby()) ?>">
        </div>
        <div class="form-group">
          <p>Study Preference</p>
          <div class="form-check">
            <input type="radio" id="design" name="study_pref" class="form-check-input" value="Design" <?php if ($user->getStudy_pref() == "Design") : echo "checked";
                                                                                                      endif; ?>>
            <label for="design" class="form-check-label">Design</label>
          </div>
          <div class="form-check">
            <input type="radio" id="development" name="study_pref" class="form-check-input" value="Development" <?php if ($user->getStudy_pref() == "Development") : echo "checked";
                                                                                                                endif; ?>>
            <label for="development" class="form-check-label">Development</label>
          </div>
          <div class="form-check">
            <input type="radio" id="undecided" name="study_pref" class="form-check-input" value="Undecided" <?php if (empty($user->getStudy_pref()) || $user->getStudy_pref() == "Undecided") : echo "checked";
                                                                                                            endif; ?>>
            <label for="undecided" class="form-check-label">Undecided</label>
          </div>
        </div>
        <div class="form-group">
          <input type="submit" value="Submit" name="updateProfile">
        </div>
    </div>
  </div>

  <div class="container">
    <div class="jumbotron float-right" style="width:40%; height:600px; margin:20px;">
      <form method="POST" action="">
        <p style="color:red">
          <?php if (!empty($errorMail)) :
            echo $errorMail;
          endif; ?>
        </p>
        <div class="form-group">
          <label for="emailpassword">Current password</label>
          <input type="password" name="emailpassword" id="emailpassword" class="form-control">
        </div>
        <div class="form-group">
          <label for="newemail">New email</label>
          <input type="email" name="newemail" id="newemail" class="form-control">
        </div>
        <input type="submit" value="Save" name="changeEmail" style="margin-bottom:20px;">

        <form method="POST" action="">
          <div class="form-group">
            <p style="color:red">
              <?php if (!empty($errorPass)) :
                echo $errorPass;
              endif; ?>
            </p>
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
  </div>

  <div class="container">
    <div class="jumbotron float-right" style="width:40%; height:200px; margin:20px; margin-bottom:50px;">
      <form action="" method="POST">
        <div class="form-group">
          <div class="form-check">
            <input type="radio" id="firstyear" name="buddyStatus" class="form-check-input" value="firstyear" <?php if ($user->getBuddyStatus() == "firstyear") : ?>checked="checked" <?php endif; ?>>
            <label for="firstyear" class="form-check-label">I'm a first year student looking for a buddy.</label>
          </div>
          <div class="form-check">
            <input type="radio" id="mentor" name="buddyStatus" class="form-check-input" value="mentor" <?php if ($user->getBuddyStatus() == "mentor") : ?>checked="checked" <?php endif; ?>>
            <label for="mentor" class="form-check-label">I'm a second or third year student looking to mentor someone.</label>
          </div>
        </div>
        <input type="submit" value="Save" name="changeStatus">
      </form>
    </div>
  </div>

</body>