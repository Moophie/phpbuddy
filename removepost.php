<?php 

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Db.php");

$id = $_POST['id'];

if($id > 0){

    $conn = Db::getConnection();


  // Check record exists
  $checkRecord = mysqli_query($conn,"SELECT * FROM posts WHERE id=".$id);
  $totalrows = mysqli_num_rows($checkRecord);

  if($totalrows > 0){
    // Delete record
    $query = "DELETE FROM posts WHERE id=".$id;
    mysqli_query($conn,$query);
    echo 1;
    exit;
  }
}

echo 0;
exit;