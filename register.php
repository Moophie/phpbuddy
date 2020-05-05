<?php

include_once(__DIR__ . "/bootstrap.include.php");

require(__DIR__ . "/sendgrid/sendgrid-php.php");
putenv("SENDGRID_API_KEY=***REMOVED***");

//Check if values have been sent
if (!empty($_POST)) {

	//Put $_POST variables into variables
	//Convert the email string to lowercase, case sensitivity does not matter here
	$fullname = $_POST['fullname'];
	$password = $_POST['password'];
	$email = strtolower($_POST['email']);

	//Encrypt the password
	$hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

	$user = new classes\Buddy\User($email);

	//Set the user's properties
	//setEmail returns an error message if the email is not a valid email or if it's not unique
	$validEmail = $user->setEmail($email);
	$user->setFullname($fullname);
	$user->setPassword($hash);

	//If setEmail returns a string, show the error message
	if (gettype($validEmail) == "string") {
		$error = $validEmail;
	} else {

		$n = 20;
		$validation_string = bin2hex(random_bytes($n));
		$user->setValidation_string($validation_string);
		$link = "http://localhost/phpbuddy/verify.php?code=" . $validation_string;

		$sgmail = new \SendGrid\Mail\Mail();
		$sgmail->setFrom("michael.van.lierde@hotmail.com", "IMD Buddy");
		$sgmail->setSubject("Confirm registration");
		$sgmail->addTo($user->getEmail(), $user->getFullname());
		$sgmail->addContent("text/html", "<a href=" . $link . ">Click to confirm your email!</a>");

		$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
		$sendgrid->send($sgmail);

		//Save the user
		$user->save();

		//Let him know he's registered
		$error = "You have been succesfully registered! A confirmation mail has been sent to your email account.";

		$user = new classes\Buddy\User($email);

		if ($user->getActive() == 1) {
			session_start();
			$_SESSION['user'] = $email;
			header("Location: index.php");
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Register</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-5/css/fontawesome-all.min.css">
	<link rel="stylesheet" href="css/style_register.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
</head>

<body>

	<?php include_once("nav.include.php") ?>

	<div class="page-content">
		<div class="form-v5-content">
			<form class="form-detail" action="" method="post">
				<h2>Register Account Buddy application</h2>
				<?php if (!empty($error)) : ?>
					<div style="background-color:#F8D7DA; padding:10px; border-radius:10px;">
						<p><?= $error ?></p>

					</div>
				<?php endif; ?>
				<div class="form-row">
					<label for="fullname">Full Name</label>
					<input type="text" name="fullname" id="fullname" class="input-text" placeholder="Your Name" required>
					<i class="fas fa-user"></i>
				</div>
				<div class="form-row">
					<label for="email">Your Email</label>
					<input type="email" name="email" id="email" class="input-text" placeholder="Your Email" onBlur="checkemailAvailability()" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" required>
					<span id="availability"></span>

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
				<div id="result"> </div>

			</form>

		</div>
	</div>


	<script>
		$(document).ready(function() {
			$('#email').blur(function() {

				var email = $(this).val();

				$.ajax({
					url: 'emailverification.php',
					method: "POST",
					data: {
						email: email
					},
					success: function(data) {
						if (data != '0') {
							$('#availability').html('<span class="text-danger">Email niet beschikbaar</span>');
							$('#submit').attr("disabled", true);
						} else {
							$('#availability').html('<span class="text-success">Email beschikbaar</span>');
							$('#submit').attr("disabled", false);
						}
					}
				})

			});
		});
	</script>

</body>

</html>