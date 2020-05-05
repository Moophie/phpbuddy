<?php

include_once(__DIR__ . "/bootstrap.include.php");

//Detect submit
if (!empty($_POST)) {

  //Put fields in variables
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!empty($email) && !empty($password)) {
    //If both fields are filled in, check if the login is correct

    if (classes\Buddy\User::checkPassword($email, $password)) {

      session_start();
      $user = new classes\Buddy\User($email);

      if ($_POST['captcha'] == $_SESSION['digit']) {

        if ($user->getActive() == 1) {
          $_SESSION['user'] = $email;
          header("Location: index.php");
        } else {
          $error = "Please confirm your account";
        }
      } else {
        $error = "Wrong Captcha";
      }
    } else {
      $error = "Sorry, we couldn't log you in.";
    }
  } else {

    //If one of the fields is empty, generate an error
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
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-5/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="css/login.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
  <title>IMD Buddy: login</title>
</head>

<body>

  <?php include_once("nav.include.php"); ?>

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


                  <p><img src="./captcha.php" width="120" height="30" alt="CAPTCHA"></p>
                  <p><input type="text" size="6" maxlength="5" name="captcha" value=""><br>
                    <small>copy the digits from the image into this box</small></p>

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