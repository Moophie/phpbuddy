<?php
include_once(__DIR__ . "/classes/User.php");
$profileImg = User::profileImg();

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
  <?php foreach ($profileImg as $p): ?>
      <img src="<?php echo $p['profileImg']; ?>"/>
  <?php endforeach; ?>

    <form enctype="multipart/form-data" action="uploadProfileImg.php" method="POST">
        <input type="file" name="profileImg" capture="camera" required/><br>
        <input type="submit" value="upload" name="upload"/>
    </form>

  <!------------------------PROFIELTEKST--------------------------->
  <h1>Bio</h1>
  <!------------------------PASSWOORD EN EMAIL WIJZIGEN--------------------------->
<h1>Settings</h1>

<a href="changePassword.php">Change password</a>
<a href="changeEmail.php">Change email</a>
    
</body>
</html>