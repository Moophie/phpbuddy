<?php

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Db.php");

//Function that checks if a string ends with a specific text
function endsWith($string, $endString)
{
	$len = strlen($endString);

	if ($len == 0) {
		return true;
	}

	return (substr($string, -$len) === $endString);
}

//Check if values have been sent
if (!empty($_POST)) {

	//Put $_POST variables into variables
	//Convert the email string to lowercase, case sensitivity does not matter here
	$fullname = $_POST['fullname'];
	$password = $_POST['password'];
	$email = strtolower($_POST['email']);

	//Encrypt the password
	$hash = password_hash($_POST['password'], PASSWORD_BCRYPT);


	//SQL to check if the email address is already in the database
	//Returns the amount of similar emails in the database
	$conn = Db::getConnection();
	$statement = $conn->prepare("SELECT id FROM users WHERE email = :email");
	$statement->bindValue(":email", $email);
	$statement->execute();
	$existingEmails = $statement->rowCount();

	if ($existingEmails > 0) {
		//Give an error if there is already a similar email in the database
		$error = "Email already in use";

	} elseif (!endsWith($email, "student.thomasmore.be")) {
		//Give another error if the email does not end on student.thomasmore.be
		$error = "Not a valid Thomas More email.";

	} else {
		//If the email is unique, create a new user and save him
		//Create a session
		//Redirect user to the homepage
		$user = new User();
		$user->setEmail($email);
		$user->setFullname($fullname);
		$user->setPassword($hash);
		$user->save();

		session_start();
		$_SESSION['user'] = $fullname;
		header("Location: indexLoggedIn.php");
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
</head>

<body class="form-v5">
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