<?php

include_once(__DIR__ . "/classes/Db.php");

function canLogin($email, $password)
{
  // Prepared PDO statement that fetches the password corresponding to the inputted email
  $conn = Db::getConnection();
  $statement = $conn->prepare("SELECT password FROM users WHERE email = :email");
  $statement->bindValue(":email", $email);
  $statement->execute();
  $result = $statement->fetch(PDO::FETCH_ASSOC);

  // Check if the password is correct
  if (password_verify($password, $result['password'])) {
    return true;
  } else {
    return false;
  }
}

// Detect submit
if (!empty($_POST)) {

  // Put fields in variables
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!empty($email) && !empty($password)) {
    // If both fields are filled in, check if the login is correct

    if (canLogin($email, $password)) {

      // Fetches the user's full name to use as user
      $conn = Db::getConnection();
      $statement = $conn->prepare("SELECT fullname FROM users WHERE email = :email");
      $statement->bindValue(":email", $email);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);

      // Start the session, fill in session variables
      // Redirect to the logged in page
      session_start();
      $_SESSION["user"] = $result['fullname'];
      header("Location: indexLoggedIn.php");

    } else {
      $error = "Sorry, we couldn't log you in.";
    }
  } else {

    // If one of the fields is empty, generate an error
    $error = "Email and password are required.";
    
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/login.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
  <title>IMD Buddy: login</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">IMD Buddy</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Information</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
        <span class="navbar-text">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link active" href="login.php"><i class="fas fa-user"></i> Log in</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-user-plus"></i> Sign up</a>
            </li>
          </ul>
        </span>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row no-gutter">
      <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
      <div class="col-md-8 col-lg-6">
        <div class="login d-flex align-items-center py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-9 col-lg-8 mx-auto">
                <h3 class="login-heading mb-4">Welcome back!</h3>


                <?php if (isset($error)) : ?>
                  <div class="col-md-9 col-lg-8 mx-auto">
                    <h3 class="login-heading mb-4" style="font-size: 1rem;color: red; text-align: center;"><?php echo $error; ?></h3>
                  </div>
                <?php endif; ?>

                <form action="" method="post">
                  <div class="form-label-group">
                    <input type="text" name="email" id="email" class="form-control" autofocus>
                    <label for="inputEmail">Thomas More Email</label>
                  </div>

                  <div class="form-label-group">
                    <input type="password" name="password" id="password" class="form-control">
                    <label for="inputPassword">Password</label>
                  </div>

                  <input type="submit" value="LOGIN" class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2">
                  <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Remember password</label>
                  </div>
                  <div class="text-center">
                    <a class="small" href="#">Forgot password?</a></div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>