<?php
session_start();

include_once(__DIR__ . "/bootstrap.include.php");


//If there's no active session, redirect to login.php
if (empty($_SESSION['user'])) {
    header("Location: login.php");
}

$email = $_SESSION['user'];
$user = new classes\Buddy\User($email);

//Connect to database
$conn = classes\Buddy\Db::getConnection();

if (isset($_FILES['profileImg'])) {
    if ($_FILES['profileImg']['error'] > 0) {
        //For error messages: see http://php.net/manual/en/features.fileupload.errors.php
        switch ($_FILES['profileImg']['error']) {
            case 1:
                $msg = 'You can only upload 2MB';
                break;
            default:
                $msg = 'Sorry, uw upload kon niet worden verwerkt.';
                echo "<button onclick=\"location.href='index.php'\">Try again</button>";
        }
    } else {
        //Check MIME TYPE - http://php.net/manual/en/function.finfo-open.php
        $allowedtypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
        $filename = $_FILES['profileImg']['tmp_name'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $fileinfo = $finfo->file($filename);

        if (in_array($fileinfo, $allowedtypes)) {

            //Move uploaded file
            $newfilename = 'uploads/' . $_FILES['profileImg']['name'];

            if (move_uploaded_file($_FILES['profileImg']['tmp_name'], $newfilename)) {
                $user->profileImg();

                header('location:profile.php');
            } else {
                $msg = 'Sorry, de upload is mislukt.';
            }
        } else {
            $msg = 'Sorry, enkel afbeeldingen zijn toegestaan.';
        }
    }
}
