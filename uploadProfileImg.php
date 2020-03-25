<?php
session_start();

include_once(__DIR__ . "../classes/Db.php");


// connectie met de databank
$conn = Db::getConnection();

if (isset($_FILES['profileImg'])) {
    if ($_FILES['profileImg']['error'] > 0) {
        //for error messages: see http://php.net/manual/en/features.fileupload.errors.php
        switch ($_FILES['profileImg']['error']) {
        case 1:
        $msg = 'You can only upload 2MB';
        break;
        default:
        $msg = 'Sorry, uw upload kon niet worden verwerkt.';
            echo "<button onclick=\"location.href='index.php'\">Try again</button>";
        }
    } else {
        //check MIME TYPE - http://php.net/manual/en/function.finfo-open.php
        $allowedtypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
        $filename = $_FILES['profileImg']['tmp_name'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $fileinfo = $finfo->file($filename);

        if (in_array($fileinfo, $allowedtypes)) {
            //move uploaded file
            $newfilename = 'uploads/'.$_FILES['profileImg']['name'];

            if (move_uploaded_file($_FILES['profileImg']['tmp_name'], $newfilename)) {
                $insert = $conn->prepare("UPDATE users  SET profileImg = ('".$_FILES['profileImg']['name']."') WHERE email = :email");
                $email = $_SESSION['user'];
                $insert->bindValue(":email", $email);
                $insert->execute();

                echo "gelukt";

            } else {
                $msg = 'Sorry, de upload is mislukt.';
            }
        } else {
            $msg = 'Sorry, enkel afbeeldingen zijn toegestaan.';
        }
    }
}


?>