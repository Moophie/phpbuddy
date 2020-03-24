<?php


/***********WITH MYSQL 
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


/********WITHOUT MYSQL*******/

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


?>