<?php
$allow = array("jpg", "jpeg", "gif", "png");

$todir = 'uploads/';

if ( !!$_FILES['profileImg']['tmp_name'] ) // is the file uploaded yet?
{
    $info = explode('.', strtolower( $_FILES['profileImg']['name']) ); // whats the extension of the file

    if ( in_array( end($info), $allow) ) // is this file allowed
    {
        if ( move_uploaded_file( $_FILES['profileImg']['tmp_name'], $todir . basename($_FILES['profileImg']['name'] ) ) )
        {
            header('location:profile.php');

        }
    }
    else
    {
        echo "The file is not allowed";
    }
}

?>