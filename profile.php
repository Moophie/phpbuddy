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
    $succesfull_password = "Your password is succesfully changed.";
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
      $succesfull_mail = "Your email is succesfully changed.";
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
  try {
    $user->saveProfile_img();
  } catch (\Throwable $th) {
    $error = $th->getMessage();
  }
}

$locationArray = array("Antwerpen", "Henegouwen", "Limburg", "Luik", "Luxemburg", "Namen", "Oost-Vlaanderen", "Vlaams-Brabant", "Waals-Brabant", "West-Vlaanderen");
$gamesArray = array("Animal Crossing", "Apex Legends", "Black Desert Online", "CS:GO", "Dota 2", "Fortnite", "Hearthstone", "League of Legends", "Minecraft", "Overwatch", "Pokemon", "Rainbow Six", "Super Smash Bros", "World of Warcraft", "I don't game.");
$musicArray = array("Blues", "Classical", "Country", "Dance", "Disco", "Drum & Bass", "Dubstep", "Folk", "Funk", "Hip Hop", "House", "Jazz", "Metal", "Pop", "Punk", "R&B", "Rap", "Reggae", "Rock", "Techno", "Trance", "Trap");
$filmsArray = array("Action", "Adventure", "Animation", "Comedy", "Documentary", "Drama", "Fantasy", "Gangster", "Historical Drama", "Horror", "Musical", "Mystery", "Romance", "Romantic Comedy", "Science Fiction", "Superhero", "Thriller", "Western");
$booksArray = array("Action", "Adventure", "Biography", "Comics", "Crime", "Drama", "Historical Fiction", "History", "Horror", "Mystery", "Poetry", "Romance", "Satire", "Science Fiction", "Science", "Thriller");
$hobbyArray = array("Archery", "Badminton", "Birdwatching", "Board Games", "Card Games", "Collecting", "Cooking", "Cosplay", "Crafting", "Dancing", "Design", "Drawing", "Exercising", "Fashion", "Football", "Gaming", "Gardening", "Hiking", "Hockey", "Ice Skating", "Knitting", "Painting", "Photography", "Playing music", "Programming", "Running", "Sewing", "Shopping", "Swimming", "Tennis", "TTRPG", "Volleyball", "Walking", "Woodworking");

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
        <?php if (isset($error)) : ?>
          <div style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px;"><?php echo $error; ?></div>
        <?php endif; ?>
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
            <?php foreach ($locationArray as $location) : ?>
              <option <?php if ($location == $user->getLocation()) {
                        echo "selected";
                      } ?>><?php echo htmlspecialchars($location) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="games">Games</label>
          <select type="text" id="games" name="games" class="form-control">
            <?php foreach ($gamesArray as $game) : ?>
              <option <?php if ($game == $user->getGames()) {
                        echo "selected";
                      } ?>><?php echo htmlspecialchars($game) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="music">Music</label>
          <select type="text" id="music" name="music" class="form-control">
            <?php foreach ($musicArray as $music) : ?>
              <option <?php if ($music == $user->getMusic()) {
                        echo "selected";
                      } ?>><?php echo htmlspecialchars($music) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="films">Film genre</label>
          <select type="text" id="films" name="films" class="form-control">
            <?php foreach ($filmsArray as $film) : ?>
              <option <?php if ($film == $user->getFilms()) {
                        echo "selected";
                      } ?>><?php echo htmlspecialchars($film) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="books">Book genre</label>
          <select type="text" id="books" name="books" class="form-control">
            <?php foreach ($booksArray as $book) : ?>
              <option <?php if ($book == $user->getBooks()) {
                        echo "selected";
                      } ?>><?php echo htmlspecialchars($book) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="hobby">Hobby</label>
          <select type="text" id="hobby" name="hobby" class="form-control">
            <?php foreach ($hobbyArray as $hobby) : ?>
              <option <?php if ($hobby == $user->getHobby()) {
                        echo "selected";
                      } ?>><?php echo htmlspecialchars($hobby) ?></option>
            <?php endforeach; ?>
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
          <?php if (!empty($error_mail)) : ?>
            <div style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px;">
              <p><?= $error_mail ?></p>
            </div>
          <?php endif; ?>
          <?php if (isset($succesfull_mail)) : ?>
            <div style="font-size: 15px; background-color:#90EE90; padding:10px; border-radius:10px;"><?php echo $succesfull_mail; ?></div>
          <?php endif; ?>

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
              <?php if (!empty($error_password)) : ?>
                <div style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px;"><?php echo $error_password; ?></div>
              <?php endif; ?>
              <?php if (isset($succesfull_password)) : ?>
                <div style="font-size: 15px; background-color:#90EE90; padding:10px; border-radius:10px;"><?php echo $succesfull_password; ?></div>
              <?php endif; ?>
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
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.js"></script>
</body>