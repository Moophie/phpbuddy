<?php
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Db.php");


if (isset($_POST['register'])) {


	$user = new User();
	$user->setFullname($_POST['fullname']);

	$conn = mysqli_connect("localhost", "root", "", "phpbuddy");


	$email = $_POST['email'];


	function endsWith($string, $endString)
	{
		$len = strlen($endString);
		if ($len == 0) {
			return true;
		}
		return (substr($string, -$len) === $endString);
	}


	$sql = "SELECT id FROM users WHERE email = '$email'";
	$results = mysqli_query($conn, $sql);
	$row = mysqli_num_rows($results);
	if ($row > 0) {
		echo "Error: email already exists";
	} elseif (!endsWith($email, "student.thomasmore.be")) {
		
		var_dump($email);

		echo "email does not end with student.thomasmore.be";
	} else {


		$user->setEmail($_POST['email']);
	}









	$hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

	$user->setPassword($hash);

	$user->save(); //active record patroon
	$success = "user saved";



	$users = User::getAll();
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
				<h2>Register Account Byddy application</h2>
				<div class="form-row">
					<label for="fullname">Full Name</label>
					<input type="text" name="fullname" id="fullname" class="input-text" placeholder="Your Name" required>
					<i class="fas fa-user"></i>
				</div>
				<div class="form-row">
					<label for="email">Your Email</label>
					<input type="text" name="email" id="email" class="input-text" placeholder="Your Email" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
					<i class="fas fa-envelope"></i>
				</div>
				<div class="form-row">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="input-text" placeholder="Your Password" required>
					<i class="fas fa-lock"></i>
				</div>
				<div class="form-row-last">
					<input type="submit" name="register" class="register" value="Register">
				</div>
			</form>
		</div>
	</div>
</body>

</html>