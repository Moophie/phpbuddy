<?php

include_once(__DIR__ . "/bootstrap.include.php");

//Create a new user based on the active user's email
$user = new classes\Buddy\User($_SESSION['user']);

//Detect a submit to change the password
if (!empty($_POST['changePassword'])) {
  $new_password = $_POST['new_password'];
  $old_password = $_POST['old_password'];

  //Check if the user has the correct password
  if (classes\Buddy\User::checkPassword($user->getEmail(), $old_password)) {

    //Change it to the new password
    $user->changePassword($new_password);
  } else {
    $error_password = "We couldn't change the password.";
  }
}

//Detect a submit to change the email
if (!empty($_POST['changeEmail'])) {
  $old_password = $_POST['emailpassword'];
  $new_email = $_POST['new_email'];

  //Check if the user has the correct password
  if (classes\Buddy\User::checkPassword($user->getEmail(), $old_password)) {

    //Use the setter with conditions to set the new email
    $valid_email = $user->setEmail($new_email);

    //If the setter returns an error string, show the error
    if (gettype($valid_email) == "string") {
      $error_mail = $valid_email;
    } else {

      //If the setter returns an object, change the email in the database
      $user->changeEmail($new_email);
    }
  } else {
    $error_mail = "Wrong password";
  }
}

//Detect a submit to update your profile
if (!empty($_POST['updateProfile'])) {
  $user = new classes\Buddy\User($_SESSION['user']);

  //Fill in the user's properties
  $user->setBio($_POST['bio']);
  $user->setLocation($_POST['location']);
  $user->setGames($_POST['games']);
  $user->setMusic($_POST['music']);
  $user->setFilms($_POST['films']);
  $user->setBooks($_POST['books']);
  $user->setStudy_pref($_POST['study_pref']);
  $user->setHobby($_POST['hobby']);

  //Save those properties to the database
  $user->completeProfile();
}

//Detect a submit to change your status firstyear/mentor
if (!empty($_POST['changeStatus'])) {

  //Change the user's status
  $user->changeBuddy_status($_POST['buddy_status']);
}

if (!empty($_POST['uploadPicture'])) {
  if (isset($_FILES['profile_img'])) {
    if ($_FILES['profile_img']['error'] > 0) {
      //For error messages: see http://php.net/manual/en/features.fileupload.errors.php
      switch ($_FILES['profile_img']['error']) {
        case 1:
          $msg = 'You can only upload 2MB';
          break;
        default:
          $msg = 'Sorry, uw upload kon niet worden verwerkt.';
          echo "<button onclick=\"location.href='index.php'\">Try again</button>";
      }
    } else {
      //Check MIME TYPE - http://php.net/manual/en/function.finfo-open.php
      $allowed_types = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
      $file_name = $_FILES['profile_img']['tmp_name'];
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $file_info = $finfo->file($file_name);

      if (in_array($file_info, $allowed_types)) {

        //Move uploaded file
        $new_file_name = 'uploads/' . $_FILES['profile_img']['name'];

        if (move_uploaded_file($_FILES['profile_img']['tmp_name'], $new_file_name)) {
          $user->saveProfile_img();

          header('location:profile.php');
        } else {
          $msg = 'Sorry, de upload is mislukt.';
        }
      } else {
        $msg = 'Sorry, enkel afbeeldingen zijn toegestaan.';
      }
    }
  }
}

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/phpbuddy.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap">
  <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">
  <title>IMD Buddy</title>
</head>

<body>

  <?php include_once("nav.include.php"); ?>

  <div class="container">
    <div class="jumbotron" style=" height:400px; margin:20px;">
      <div class="float-left" style=" margin-left:50px;">
        <img src="./uploads/<?= htmlspecialchars($user->getProfile_img()) ?>" width="250px;" height="250px;" />
        <form enctype="multipart/form-data" action="" method="POST" style="margin-top:20px;">
          <div class="form-group">
            <input type="file" id="profile_img" name="profile_img" capture="camera" required />
          </div>
          <div class="form-group">
            <input type="submit" value="Upload" name="uploadPicture" />
          </div>
        </form>
      </div>
      <div>
        <h2><?= htmlspecialchars($user->getFullname()); ?></h2>
        <h6> Web Developer and Designer </h6>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="jumbotron float-left" style="width:50%; height:900px; margin:20px;">

      <form action="" method="POST">

        <!-- Fill in the input fields with the data from the database -->
        <br>
        <div class="form-group">
          <label for="bio">Biography</label>
          <textarea name="bio" id="bio" class="form-control" rows="3" cols="50"><?= htmlspecialchars($user->getBio()) ?></textarea>
        </div>
        <div class="form-group">
          <label for="location">Location</label>
          <select type="text" id="location" name="location" class="form-control">
            <option disabled selected><?= htmlspecialchars($user->getLocation()) ?></option>
            <option>Antwerpen</option>
            <option>Henegouwen</option>
            <option>Limburg</option>
            <option>Luik</option>
            <option>Luxemburg</option>
            <option>Namen</option>
            <option>Oost-Vlaanderen</option>
            <option>Vlaams-Brabant</option>
            <option>Waals-Brabant</option>
            <option>West-Vlaanderen</option>
          </select>
        </div>
        <div class="form-group">
          <label for="games">Games</label>
          <select type="text" id="games" name="games" class="form-control">
            <option disabled selected><?= htmlspecialchars($user->getGames()) ?></option>
            <option>Animal Crossing</option>
            <option>Apex Legends</option>
            <option>Black Desert Online</option>
            <option>CS:GO</option>
            <option>Dota 2</option>
            <option>Fortnite</option>
            <option>Hearthstone</option>
            <option>League of Legends</option>
            <option>Minecraft</option>
            <option>Overwatch</option>
            <option>Pokemon</option>
            <option>Rainbow Six</option>
            <option>Super Smash Bros</option>
            <option>World of Warcraft</option>
            <option>I don't game</option>
          </select>
        </div>
        <div class="form-group">
          <label for="music">Music</label>
          <select type="text" id="music" name="music" class="form-control">
            <option disabled selected><?= htmlspecialchars($user->getMusic()) ?></option>
            <option>Blues</option>
            <option>Classical</option>
            <option>Country</option>
            <option>Dance</option>
            <option>Disco</option>
            <option>Drum & Bass</option>
            <option>Dubstep</option>
            <option>Folk</option>
            <option>Funk</option>
            <option>Hip Hop</option>
            <option>House</option>
            <option>Jazz</option>
            <option>Metal</option>
            <option>Pop</option>
            <option>Punk</option>
            <option>R&B</option>
            <option>Rap</option>
            <option>Reggae</option>
            <option>Rock</option>
            <option>Techno</option>
            <option>Trance</option>
            <option>Trap</option>
          </select>
        </div>
        <div class="form-group">
          <label for="films">Film genre</label>
          <select type="text" id="films" name="films" class="form-control">
            <option disabled selected><?= htmlspecialchars($user->getFilms()) ?></option>
            <option>Action</option>
            <option>Adventure</option>
            <option>Animation</option>
            <option>Comedy</option>
            <option>Documentary</option>
            <option>Drama</option>
            <option>Fantasy</option>
            <option>Gangster</option>
            <option>Historical Drama</option>
            <option>Horror</option>
            <option>Musical</option>
            <option>Mystery</option>
            <option>Romance</option>
            <option>Romantic Comedy</option>
            <option>Science Fiction</option>
            <option>Superhero</option>
            <option>Thriller</option>
            <option>Western</option>
          </select>
        </div>
        <div class="form-group">
          <label for="books">Book genre</label>
          <select type="text" id="books" name="books" class="form-control">
            <option disabled selected><?= htmlspecialchars($user->getBooks()) ?></option>
            <option>Action</option>
            <option>Adventure</option>
            <option>Biography</option>
            <option>Comics</option>
            <option>Crime</option>
            <option>Drama</option>
            <option>Historical Fiction</option>
            <option>History</option>
            <option>Horror</option>
            <option>Mystery</option>
            <option>Poetry</option>
            <option>Romance</option>
            <option>Satire</option>
            <option>Science Fiction</option>
            <option>Science</option>
            <option>Thriller</option>
          </select>
        </div>
        <div class="form-group">
          <label for="hobby">Hobby</label>
          <select type="text" id="hobby" name="hobby" class="form-control">
            <option disabled selected><?= htmlspecialchars($user->getHobby()) ?></option>
            <option>Archery</option>
            <option>Badminton</option>
            <option>Birdwatching</option>
            <option>Board Games</option>
            <option>Card Games</option>
            <option>Collecting</option>
            <option>Cooking</option>
            <option>Cosplay</option>
            <option>Crafting</option>
            <option>Dancing</option>
            <option>Design</option>
            <option>Drawing</option>
            <option>Exercising</option>
            <option>Fashion</option>
            <option>Football</option>
            <option>Gaming</option>
            <option>Gardening</option>
            <option>Hiking</option>
            <option>Hockey</option>
            <option>Ice Skating</option>
            <option>Knitting</option>
            <option>Painting</option>
            <option>Photography</option>
            <option>Playing music</option>
            <option>Programming</option>
            <option>Running</option>
            <option>Sewing</option>
            <option>Shopping</option>
            <option>Swimming</option>
            <option>Tennis</option>
            <option>TTRPG (D&D, Pathfinder, etc...)</option>
            <option>Volleyball</option>
            <option>Walking</option>
            <option>Woodworking</option>
          </select>
        </div>
        <div class="form-group">
          <p>Study Preference</p>
          <div class="form-check">
            <input type="radio" id="design" name="study_pref" class="form-check-input" value="Design" <?php if ($user->getStudy_pref() == "Design") : echo "checked";
                                                                                                      endif; ?>>
            <label for="design" class="form-check-label">Design</label>
          </div>
          <div class="form-check">
            <input type="radio" id="development" name="study_pref" class="form-check-input" value="Development" <?php if ($user->getStudy_pref() == "Development") : echo "checked";
                                                                                                                endif; ?>>
            <label for="development" class="form-check-label">Development</label>
          </div>
          <div class="form-check">
            <input type="radio" id="undecided" name="study_pref" class="form-check-input" value="Undecided" <?php if (empty($user->getStudy_pref()) || $user->getStudy_pref() == "Undecided") : echo "checked";
                                                                                                            endif; ?>>
            <label for="undecided" class="form-check-label">Undecided</label>
          </div>
        </div>
        <div class="form-group">
          <input type="submit" value="Submit" name="updateProfile">
        </div>
    </div>
  </div>

  <div class="container">
    <div class="jumbotron float-right" style="width:40%; height:600px; margin:20px;">
      <form method="POST" action="">
        <p style="color:red">
          <?php if (!empty($error_mail)) :
            echo $error_mail;
          endif; ?>
        </p>
        <div class="form-group">
          <label for="emailpassword">Current password</label>
          <input type="password" name="emailpassword" id="emailpassword" class="form-control">
        </div>
        <div class="form-group">
          <label for="new_email">New email</label>
          <input type="email" name="new_email" id="new_email" class="form-control">
        </div>
        <input type="submit" value="Save" name="changeEmail" style="margin-bottom:20px;">

        <form method="POST" action="">
          <div class="form-group">
            <p style="color:red">
              <?php if (!empty($error_password)) :
                echo $error_password;
              endif; ?>
            </p>
            <label for="old_password">Current password</label>
            <input type="password" name="old_password" id="old_password" class="form-control">
          </div>
          <div class="form-group">
            <label for="new_password">New password</label>
            <input type="password" name="new_password" id="new_password" class="form-control">
          </div>
          <input type="submit" value="Save" name="changePassword">
        </form>
      </form>
    </div>
  </div>

  <div class="container">
    <div class="jumbotron float-right" style="width:40%; height:200px; margin:20px; margin-bottom:50px;">
      <form action="" method="POST">
        <div class="form-group">
          <div class="form-check">
            <input type="radio" id="firstyear" name="buddy_status" class="form-check-input" value="firstyear" <?php if ($user->getBuddy_status() == "firstyear") : ?>checked="checked" <?php endif; ?>>
            <label for="firstyear" class="form-check-label">I'm a first year student looking for a buddy.</label>
          </div>
          <div class="form-check">
            <input type="radio" id="mentor" name="buddy_status" class="form-check-input" value="mentor" <?php if ($user->getBuddy_status() == "mentor") : ?>checked="checked" <?php endif; ?>>
            <label for="mentor" class="form-check-label">I'm a second or third year student looking to mentor someone.</label>
          </div>
        </div>
        <input type="submit" value="Save" name="changeStatus">
      </form>
    </div>
  </div>
</body>