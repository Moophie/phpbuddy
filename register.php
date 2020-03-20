<?php 
    include_once(__DIR__ . "/classes/Student.php");

    if(!empty($_POST)) {
        try {
            $user = new User();
            $user->setFirstname($_POST['firstname']);
            $user->setLastname($_POST['lastname']);
            $user->setEmail($_POST['email']);

            $user->save();//active record patroon
            $success = "user saved";
        } catch (\Throwable $th) {
            $error = $th->getMessage();
        }
    }
    
    $users = User::getAll();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if(isset($error)) : ?>
    <div class="error" style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if(isset($success)) : ?>
    <div class="success" style="color: green;"><?php echo $success; ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div>
            <label for="firstname">firstname</label>
            <input type="text" name="firstname" id="firstname">
        </div>
        
        <div>
            <label for="lastnamename">lastname</label>
            <input type="text" name="lastname" id="lastname">
        </div>

        <div>
            <label for="email">email</label>
            <input type="text" name="email" id="email">
        </div>

        <div>
            <input type="submit" value="Sign me up">
        </div>
    </form>

    <?php foreach($users as $user): ?>
        <h2><?php echo $user['email']; ?></h2>
    <?php endforeach; ?>
</body>
</html>