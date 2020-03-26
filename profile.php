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

  <form action="" method="POST">
    <label for="location">Location</label>
    <input type="text" id="location" name="location">
    <br>
    <label for="games">Games</label>
    <input type="text" id="games" name="games">
    <br>
    <label for="music">Music</label>
    <input type="text" id="music" name="music">
    <br>
    <label for="films">Films</label>
    <input type="text" id="films" name="films">
    <br>
    <label for="books">Books</label>
    <input type="text" id="books" name="books">
    <br>
    <label for="study_pref">Study Preference</label>
    <input type="text" id="study_pref" name="study_pref">
    <br>
    <label for="hobby">Hobby</label>
    <input type="text" id="hobby" name="hobby">
    <br>
    <input type="submit" value="Submit">
  </form>

  <!------------------------PASSWOORD EN EMAIL WIJZIGEN--------------------------->
  <h1>Settings</h1>

  <a href="changePassword.php">Change password</a>
  <a href="changeEmail.php">Change email</a>

</body>

</html>