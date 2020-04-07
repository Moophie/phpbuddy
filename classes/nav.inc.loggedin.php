<?php

$email = $_SESSION['user'];


?>

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

        .center {
            text-align: center;
        }

        .matches {
            max-width: 250px;
            margin: 5px 20px;
            padding: 10px;
            border: solid black 1px;
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
                        <a class="nav-link" href="chat.php">Chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="buddies.php">Buddies</a>
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
                                    echo htmlspecialchars($email);
                                    ?>
                                </a>
                                <div class="dropdown-content">
                                    <a href="search.php">Search</a>
                                    <div class="dropdown-divider"></div>
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
