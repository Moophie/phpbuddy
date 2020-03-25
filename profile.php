<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");
$profileImg = User::profileImg();
//$bio = User::bio();
User::updateBio();


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
      <img src="<?php echo $profileImg; ?>"/>

    <form enctype="multipart/form-data" action="uploadProfileImg.php" method="POST">
        <input type="file" name="profileImg" capture="camera" required/><br>
        <input type="submit" value="upload" name="upload"/>
    </form>

  <!------------------------PROFIELTEKST--------------------------->
  <h1>About me</h1>

  <p><?php //echo $bio; ?></p>
  <form action="" method="post">
    <textarea name="bio" id="bio" cols="30" rows="10"></textarea>
    <input type="submit" name="submit" value="submit">
  </form>
  <!------------------------PASSWOORD EN EMAIL WIJZIGEN--------------------------->
<h1>Settings</h1>

<a href="changePassword.php">Change password</a>
<a href="changeEmail.php">Change email</a>
    
</body>
</html>