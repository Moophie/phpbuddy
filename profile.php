<?php
session_start();

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Db.php");

$user = new User($_SESSION['user']);

if (!empty($_SESSION['user'])) {
    $email = $_SESSION['user'];
} else {
    header("Location: login.php");
}

if (!empty($_POST['changePassword'])) {

  $newpassword = $_POST['newpassword'];
  $oldpassword = $_POST['oldpassword'];

  if (User::checkPassword($user->getEmail(),$oldpassword)) {
    $user->changePassword($newpassword);
  } else {
    $errorPass = "We couldn't change the password.";
  }
}

if (!empty($_POST['changeEmail'])) {

  $oldpassword = $_POST['emailpassword'];
  $newemail = $_POST['newemail'];

  if (User::checkPassword($user->getEmail(),$oldpassword)) {
    $validEmail = $user->setEmail($newemail);
    if (gettype($validEmail) == "string") {
      $errorMail = $validEmail;
    } else {
      $user->changeEmail($newemail);
    }
  } else {
    $errorMail = "Wrong password";
  }
}

if (!empty($_POST['updateProfile'])) {
  $user = new User($_SESSION['user']);
  $user->setBio($_POST['bio']);
  $user->setLocation($_POST['location']);
  $user->setGames($_POST['games']);
  $user->setMusic($_POST['music']);
  $user->setFilms($_POST['films']);
  $user->setBooks($_POST['books']);
  $user->setStudy_pref($_POST['study_pref']);
  $user->setHobby($_POST['hobby']);
  $user->completeProfile();
}

if (!empty($_POST['changeStatus'])) {
  $user->changeBuddyStatus($_POST['buddyStatus']);
}

?>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet" id="bootstrap-css">

    <!------ Include the above in your HEAD tag ---------->

    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style_profile.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
    <title>IMD Buddy</title>
    <style>
        .dropbtn {
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }
        
        .dropbtn i {
            margin-right: 5px;
        }
        
        .dropdown {
            position: relative;
            display: inline-block;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #343A40;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
        
        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        
        .dropdown-content a:hover {
            background-color: #68717a;
        }
        
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
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
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="buddy.php">Buddy</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <div class="dropdown">

                                <a class="dropbtn">
                                    <i class="fas fa-user"></i>
                                    <?php
                                    // Don't forget to htmlspecialchars() when using inputted variables in your code
                                    echo htmlspecialchars($email);
                                    ?>
                                </a>
                                <div class="dropdown-content">
                                    <a href="profile.php">Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="logout.php">Log out</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </span>
            </div>
        </div>
    </nav>

    <div class="container emp-profile">
            <div class="row">

    <div class="float-left" style="margin-left:20px;">
                            <img src="./uploads/<?= htmlspecialchars($user->getProfileImg()) ?>" width="250px;" height="250px;" />
                            

                            <form enctype="multipart/form-data" action="uploadProfileImg.php" method="POST">
                                <input type="file" name="profileImg" capture="camera" required />
                                <br>
                                <input type="submit" value="upload" name="uploadPicture" />
                            </form>
                        </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">

                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="profile-head">
                        <h5>
                                    <?= htmlspecialchars($email); ?>

                                    </h5>
                        <h6>
                                        Web Developer and Designer
                                    </h6>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <div class="float-left" style="margin-left:20; ">
                            <h1>Settings</h1>

                            <form method="POST" action="">
                                <p style="color:red">
                                    <?php if (!empty($errorMail)) {
                              echo $errorMail;
                            } ?>
                                </p>
                                <div class="form-group">
                                    <label for="emailpassword">Current password</label>
                                    <input type="password" name="emailpassword" id="emailpassword" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="newemail">New email</label>
                                    <input type="email" name="newemail" id="newemail" class="form-control">
                                </div>
                                <input type="submit" value="Save" name="changeEmail">

                                <form method="POST" action="">
                                    <div class="form-group">
                                        <p style="color:red">
                                            <?php if (!empty($errorPass)) {
                                  echo $errorPass;
                                } ?>
                                        </p>
                                        <label for="oldpassword">Current password</label>
                                        <input type="password" name="oldpassword" id="oldpassword" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="newpassword">New password</label>
                                        <input type="password" name="newpassword" id="newpassword" class="form-control">
                                    </div>
                                    <input type="submit" value="Save" name="changePassword">
                                </form>
                            </form>
                        </div>

                    </div>
                </div>
                
                
    <form action="" method="POST"  style="padding:20px; width:500px;">
                <div class="col-md-7">
       <h1> <label for="bio">Biography</label></h1>
        <textarea name="bio" id="bio" cols="10" rows="10" class="form-control"><?= htmlspecialchars($user->getBio()) ?></textarea>
      </div>
     <br> 
      <div class="form-group">
        <label for="location">Location</label>
        <input type="text" id="location" name="location" class="form-control" value="<?= htmlspecialchars($user->getLocation()) ?>">
      </div>
      <div class="form-group">
        <label for="games">Games</label>
        <input type="text" id="games" name="games" class="form-control" value="<?= htmlspecialchars($user->getGames()) ?>">
      </div>
      <div class="form-group">
        <label for="music">Music</label>
        <input type="text" id="music" name="music" class="form-control" value="<?= htmlspecialchars($user->getMusic()) ?>">
      </div>
      <div class="form-group">
        <label for="films">Films</label>
        <input type="text" id="films" name="films" class="form-control" value="<?= htmlspecialchars($user->getFilms()) ?>">
      </div>
      <div class="form-group">
        <label for="books">Books</label>
        <input type="text" id="books" name="books" class="form-control" value="<?= htmlspecialchars($user->getBooks()) ?>">
      </div>
      <div class="form-group">
        <label for="hobby">Hobby</label>
        <input type="text" id="hobby" name="hobby" class="form-control" value="<?= htmlspecialchars($user->getHobby()) ?>">
      </div>
      <div class="form-group">
        <p>Study Preference</p>
        <div class="form-check">
          <input type="radio" id="design" name="study_pref" class="form-check-input" value="Design" <?php if ($user->getStudy_pref() == "design") : ?>checked="checked" <?php endif; ?>>
          <label for="design" class="form-check-label">Design</label>
        </div>
        <div class="form-check">
          <input type="radio" id="development" name="study_pref" class="form-check-input" value="Development" <?php if ($user->getStudy_pref() == "development") : ?>checked="checked" <?php endif; ?>>
          <label for="development" class="form-check-label">Development</label>
        </div>
        <div class="form-check">
          <input type="radio" id="undecided" name="study_pref" class="form-check-input" value="Undecided" <?php if (empty($user->getStudy_pref())) : ?>checked="checked" <?php endif; ?>>
          <label for="undecided" class="form-check-label">Undecided</label>
        </div>
      </div>
      <div class="form-group">
        <input type="submit" value="Submit" name="updateProfile">
      </div>
      
    </form>
    <form action="" method="POST" class="border rounded" style="margin-left: 32%; width:500px;">
      <div class="form-group">
        <div class="form-check">
          <input type="radio" id="firstyear" name="buddyStatus" class="form-check-input" value="firstyear" <?php if ($user->getBuddyStatus() == "firstyear") : ?>checked="checked" <?php endif; ?>>
          <label for="firstyear" class="form-check-label">I'm a first year student looking for a buddy.</label>
        </div>
        <div class="form-check">
          <input type="radio" id="mentor" name="buddyStatus" class="form-check-input" value="mentor" <?php if ($user->getBuddyStatus() == "mentor") : ?>checked="checked" <?php endif; ?>>
          <label for="mentor" class="form-check-label">I'm a second or third year student looking to mentor someone.</label>
        </div>
      </div>
      <input type="submit" value="Save" name="changeStatus">
    </form>
  </div>
  </div>
  
                </div>
              </form>
            </div>
          </div>
        </div>
      </body>