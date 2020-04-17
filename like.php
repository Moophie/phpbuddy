<?php
// Here you can add code to save the values in the database
// Getting the reaction from Ajax and printing
        
$data_reaction = '<script>$(this).attr("data-reaction"); </script>';

$conn = Db::getConnection();
$statement = $conn->prepare("INSERT INTO messages (rating) VALUES (:data_reaction)");
var_dump($data_reaction);

$statement->bindValue(":data_reaction", $data_reaction);
$result = $statement->execute();


?>