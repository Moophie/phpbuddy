<?php

include_once(__DIR__ . "/classes/User.php");
$page = basename($_SERVER['PHP_SELF']);

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">IMD Buddy</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <?php if (!empty($_SESSION['user'])) : ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?php if($page == "index.php"): echo "active"; endif; ?>">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item <?php if($page == "chat.php"): echo "active"; endif; ?>">
                        <a class="nav-link" href="chat.php">Chat</a>
                    </li>
                    <li class="nav-item <?php if($page == "buddies.php"): echo "active"; endif; ?>">
                        <a class="nav-link" href="buddies.php">Buddies</a>
                    </li>
                </ul>
            <?php endif; ?>
            <span class="navbar-text">
                <?php if (!empty($_SESSION['user'])) :
                    $user = new User($_SESSION['user']);
                ?>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="dropbtn">
                                    <i class="fas fa-user"></i>
                                    <?php echo htmlspecialchars($user->getFullname()); ?>
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
                <?php else : ?>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php if($page == "login.php"): echo "active"; endif; ?>" href="login.php"><i class="fas fa-user"></i> Log in</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($page == "register.php"): echo "active"; endif; ?>" href="register.php"><i class="fas fa-user-plus"></i> Sign up</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </span>
        </div>
    </div>
</nav>