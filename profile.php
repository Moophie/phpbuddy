<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");
$profileImg = User::profileImg();
$bio = User::bio();
User::updateBio();


if(!empty($_POST)){
  $user = new User();
  $user->setLocation($_POST['location']);
  $user->setGames($_POST['games']);
  $user->setMusic($_POST['music']);
  $user->setFilms($_POST['films']);
  $user->setBooks($_POST['books']);
  $user->setStudy_pref($_POST['study_pref']);
  $user->setHobby($_POST['hobby']);
  $user->completeProfile();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/bootstrap.css">
</head>

<body>


  <!------------------------PROFIELFOTO--------------------------->
  <h1>Profile Image</h1>
  <img src="<?php echo $profileImg; ?>" />

  <form enctype="multipart/form-data" action="uploadProfileImg.php" method="POST">
    <input type="file" name="profileImg" capture="camera" required /><br>
    <input type="submit" value="upload" name="upload" />
  </form>

  <!------------------------PROFIELTEKST--------------------------->
  <h1>About me</h1>

  <p><?php echo $bio; ?></p>
  <form action="" method="post">
    <textarea name="bio" id="bio" cols="30" rows="10"></textarea>
    <input type="submit" name="submit" value="submit">
  </form>

  <!-- Update profile -->

  <form action="" method="POST" class="border rounded" style="padding:20px; width:20%">
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
        <input type="radio" id="design" name="study_pref" class="form-check-input">
        <label for="design" class="form-check-label">Design</label>
      </div>
      <div class="form-check">
        <input type="radio" id="development" name="study_pref" class="form-check-input">
        <label for="development" class="form-check-label">Development</label>
      </div>
      <div class="form-check">
        <input type="radio" id="other" name="study_pref" class="form-check-input">
        <label for="other" class="form-check-label">Undecided</label>
      </div>
    </div>
    <div class="form-group">
      <input type="submit" value="Submit">
    </div>
  </form>

  <!------------------------PASSWOORD EN EMAIL WIJZIGEN--------------------------->
  <h1>Settings</h1>

  <a href="changePassword.php">Change password</a>
  <a href="changeEmail.php">Change email</a>

</body>

</html>