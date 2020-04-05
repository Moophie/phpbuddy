<?php
include_once(__DIR__ . "/classes/User.php");

session_start();
$user = new User();

// If there's an active session, put the session variable into $username for easier access
if (!empty($_SESSION['user'])) {
    $username = $_SESSION['user'];
} else {

    // If there's no active session, redirect to login.php
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
    <title>IMD Buddy</title>
    <style>
        .dropbtn {
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropbtn i {
            margin-right: 5px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #343A40;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #68717a;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .list-group {
            width: 50%;
        }

        .listA{
            float: left;
        }

        .listB{
            float: right;
        }

    </style>

</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">IMD Buddy</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Buddies</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <div class="dropdown">

                                <a class="dropbtn">
                                    <i class="fas fa-user"></i>
                                    <?php
                                    // Don't forget to htmlspecialchars() when using inputted variables in your code
                                    echo htmlspecialchars($username);
                                    ?>
                                </a>
                                <div class="dropdown-content">
                                    <a href="profile.php">Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="logout.php">Log out</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="jumbotron">
            <h1>Buddy list</h1>
            <p>Find out who are buddies</p>
        </div>

        <ul class="list-group listA">
            <li class="list-group-item">	   
                <div class="col-md-12">
			        <div class="d-flex flex-row border rounded">
	  			        <div class="p-0 w-25">
	  				        <img src="https://randomuser.me/api/portraits/women/85.jpg" class="img-thumbnail border-0" />
	  			        </div>
	  			        <div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
	  					    <h4 class="text-primary">Marie</h4>
	  					    <h5 class="text-info">IMD 3</h5>
						<p class="text-right m-0"><a href="#" class="btn btn-primary"><i class="far fa-user"></i> View Profile</a></p>
				        </div>
			        </div>
		        </div>
        </li>
            <li class="list-group-item">
                <div class="col-md-12">
			        <div class="d-flex flex-row border rounded">
	  			        <div class="p-0 w-25">
	  				        <img src="https://randomuser.me/api/portraits/women/72.jpg" class="img-thumbnail border-0" />
	  			        </div>
	  			        <div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
	  					    <h4 class="text-primary">Evelyne</h4>
	  					    <h5 class="text-info">IMD 2</h5>
						<p class="text-right m-0"><a href="#" class="btn btn-primary"><i class="far fa-user"></i> View Profile</a></p>
				        </div>
			        </div>
		        </div>
            </li>
            <li class="list-group-item">
                <div class="col-md-12">
			        <div class="d-flex flex-row border rounded">
	  			        <div class="p-0 w-25">
	  				        <img src="https://randomuser.me/api/portraits/men/62.jpg" class="img-thumbnail border-0" />
	  			        </div>
	  			        <div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
	  					    <h4 class="text-primary">Thomas</h4>
	  					    <h5 class="text-info">IMD 3</h5>
						<p class="text-right m-0"><a href="#" class="btn btn-primary"><i class="far fa-user"></i> View Profile</a></p>
				        </div>
			        </div>
		        </div>
            </li>
        </ul>

        <ul class="list-group listB">
        <li class="list-group-item">	   
                <div class="col-md-12">
			        <div class="d-flex flex-row border rounded">
	  			        <div class="p-0 w-25">
	  				        <img src="https://randomuser.me/api/portraits/women/20.jpg" class="img-thumbnail border-0" />
	  			        </div>
	  			        <div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
	  					    <h4 class="text-primary">Evi</h4>
	  					    <h5 class="text-info">IMD 1</h5>
						<p class="text-right m-0"><a href="#" class="btn btn-primary"><i class="far fa-user"></i> View Profile</a></p>
				        </div>
			        </div>
		        </div>
        </li>
            <li class="list-group-item">
                <div class="col-md-12">
			        <div class="d-flex flex-row border rounded">
	  			        <div class="p-0 w-25">
	  				        <img src="https://randomuser.me/api/portraits/men/10.jpg" class="img-thumbnail border-0" />
	  			        </div>
	  			        <div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
	  					    <h4 class="text-primary">Ruben</h4>
	  					    <h5 class="text-info">IMD 1</h5>
						<p class="text-right m-0"><a href="#" class="btn btn-primary"><i class="far fa-user"></i> View Profile</a></p>
				        </div>
			        </div>
		        </div>
            </li>
            <li class="list-group-item">
                <div class="col-md-12">
			        <div class="d-flex flex-row border rounded">
	  			        <div class="p-0 w-25">
	  				        <img src="https://randomuser.me/api/portraits/men/42.jpg" class="img-thumbnail border-0" />
	  			        </div>
	  			        <div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
	  					    <h4 class="text-primary">Michiel</h4>
	  					    <h5 class="text-info">IMD 1</h5>
						<p class="text-right m-0"><a href="#" class="btn btn-primary"><i class="far fa-user"></i> View Profile</a></p>
				        </div>
			        </div>
		        </div>
            </li>
        </ul>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"> </script>
    <script src="../js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/2b908491a1.js" crossorigin="anonymous"></script>
</body>

</html>