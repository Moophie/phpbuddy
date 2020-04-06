<?php
session_start();

include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");

$user = new User;

if (!empty($_SESSION['user'])) {
    $email = $_SESSION['user'];
} else {
    header("Location: login.php");
}

if (!empty($_POST['changePassword'])) {

  $newpassword = $_POST['newpassword'];
  $oldpassword = $_POST['oldpassword'];

  if (User::checkPassword($user->getEmail(),$oldpassword)) {
    $user->changePassword($newpassword);
  } else {
    $errorPass = "We couldn't change the password.";
  }
}

if (!empty($_POST['changeEmail'])) {

  $oldpassword = $_POST['emailpassword'];
  $newemail = $_POST['newemail'];

  if (User::checkPassword($user->getEmail(),$oldpassword)) {
    $validEmail = $user->setEmail($newemail);
    if (gettype($validEmail) == "string") {
      $errorMail = $validEmail;
    } else {
      $user->changeEmail($newemail);
    }
  } else {
    $errorMail = "Wrong password";
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
  $user->changeBuddyStatus($_POST['buddyStatus']);
}


?>

<body>
  <div class="float-left" style="margin-left:20px;">
    <form action="" method="POST" class="border rounded" style="padding:20px; width:500px;">
      <h1>About me</h1>

      
      <div class="form-group">
        <label for="bio">Biography</label>
        <textarea name="bio" id="bio" cols="30" rows="10" class="form-control"><?= htmlspecialchars($user->getBio()) ?></textarea>
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
          <input type="radio" id="design" name="study_pref" class="form-check-input" value="design" <?php if ($user->getStudy_pref() == "design") : ?>checked="checked" <?php endif; ?>>
          <label for="design" class="form-check-label">Design</label>
        </div>
        <div class="form-check">
          <input type="radio" id="development" name="study_pref" class="form-check-input" value="development" <?php if ($user->getStudy_pref() == "development") : ?>checked="checked" <?php endif; ?>>
          <label for="development" class="form-check-label">Development</label>
        </div>
        <div class="form-check">
          <input type="radio" id="undecided" name="study_pref" class="form-check-input" value="undecided" <?php if (empty($user->getStudy_pref())) : ?>checked="checked" <?php endif; ?>>
          <label for="undecided" class="form-check-label">Undecided</label>
        </div>
      </div>
      <div class="form-group">
        <input type="submit" value="Submit" name="updateProfile">
      </div>
    </form>
  </div>


    <form action="" method="POST" class="border rounded" style="padding:20px; width:500px;">
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