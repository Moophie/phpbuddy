<?php
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
                $insert = $conn->query("INSERT INTO users (profileImg) VALUES ('".$_FILES['profileImg']['name']."')");

                echo "gelukt";

            } else {
                $msg = 'Sorry, de upload is mislukt.';
            }
        } else {
            $msg = 'Sorry, enkel afbeeldingen zijn toegestaan.';
        }
    }
}


/***********WITH MYSQL 2.0
 * 
 * 
include_once(__DIR__ . "../classes/Db.php");

$conn = Db::getConnection();

$msg="";

//als ik upload knop gedrukt is
if(isset($_POST['upload'])){

    //halen we de profileimg naam
    $filename = $_FILES['profileImg']['name'];

    //we steken het in deze map
    $target = 'uploads/' . $filename;

    if(move_uploaded_file($_FILES['profileImg']['tmp_name'], $target)){
        
        $sql = $conn->prepare("INSERT INTO users (profileImg)");
        $result = $sql->execute();

        echo "Image uploaded succesfully";
        header ('location:profile.php');
    }else{
        echo "Failed to upload image";
    }
}

********/


/********WITHOUT MYSQL

$allow = array("jpg", "jpeg", "gif", "png");

$todir = 'uploads/';

if ( !!$_FILES['profileImg']['tmp_name'] ) // is the file uploaded yet?
{
    $info = explode('.', strtolower( $_FILES['profileImg']['name']) ); // whats the extension of the file

    if ( in_array( end($info), $allow) ) // is this file allowed
    {
        if ( move_uploaded_file( $_FILES['profileImg']['tmp_name'], $todir . basename($_FILES['profileImg']['name'] ) ) )
        {
            $image = $_FILES['profileImg']['name'];
            $img ="uploads/" . $image;
            echo '<img src="'.$img.'">';
        }
    }
    else
    {
        echo "The file is not allowed";
    }
}
**/


?>