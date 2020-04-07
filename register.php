<?php

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Db.php");

// Check if values have been sent
if (!empty($_POST)) {

	// Put $_POST variables into variables
	// Convert the email string to lowercase, case sensitivity does not matter here
	$fullname = $_POST['fullname'];
	$password = $_POST['password'];
	$email = strtolower($_POST['email']);

	// Encrypt the password
	$hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

	// If the email is unique, create a new user and save him
	// Create a session
	// Redirect user to the homepage
	$user = new User($email);
	$validEmail = $user->setEmail($email);
	$user->setFullname($fullname);
	$user->setPassword($hash);
	if (gettype($validEmail) == "string") {
		$error = $validEmail;
	} else {
		$user->save();
		session_start();
		$_SESSION['user'] = $email;
		header("Location: index.php");
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Register</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/roboto-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-5/css/fontawesome-all.min.css">
	<!-- Main Style Css -->
	<link rel="stylesheet" href="css/style_register.css" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/login.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
	<title>IMD Buddy: login</title>
</head>

<body>
<?php include_once ("./classes/nav.inc.notloggedin.php"); ?>


	<div class="page-content">
		<div class="form-v5-content">
			<form class="form-detail" action="" method="post">
				<h2>Register Account Buddy application</h2>
				<div class="form-row">
					<?php if (!empty($error)) : ?>
						<div style="background-color:#F8D7DA; padding:10px; border-radius:10px;">
							<?= $error ?>
						</div>
						<br>
					<?php endif; ?>
					<label for="fullname">Full Name</label>
					<input type="text" name="fullname" id="fullname" class="input-text" placeholder="Your Name" required>
					<i class="fas fa-user"></i>
				</div>
				<div class="form-row">
					<label for="email">Your Email</label>
					<input type="email" name="email" id="email" class="input-text" placeholder="Your Email" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" required>
					<i class="fas fa-envelope"></i>
				</div>
				<div class="form-row">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="input-text" placeholder="Your Password" required>
					<i class="fas fa-lock"></i>
				</div>
				<div class="form-row-last">
					<input type="submit" class="register" value="Register">
				</div>
			</form>
		</div>
	</div>
</body>

</html>