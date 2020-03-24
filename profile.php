
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

  <!------------------------PROFIELFOTO--------------------------->
  

    <form enctype="multipart/form-data" action="uploadProfileImg.php" method="POST">
        <input type="file" name="profileImg" capture="camera" required/><br>
        <input type="submit" value="upload" name="upload"/>
    </form>
    
</body>
</html>