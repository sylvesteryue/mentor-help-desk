<div id="header">
    <nav class="navbar navbar-expand-md navbar-fixed-top navbar-dark">
        <a class="navbar-brand" href="index.php">Mentor Helpdesk</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <?php if(!isset($_SESSION["logged-in"]) || !$_SESSION["logged-in"]) { ?>
                    <li class="nav-item dropdown"> 
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSignupLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
                        <div class="dropdown-menu" aria-lablledby="navbarDropdownSignupLink">
                            <a class="dropdown-item" href="login.php">User</a>
                            <a class="dropdown-item" href="organizer-login.php">Organizer</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown"> 
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSignupLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sign Up</a>
                        <div class="dropdown-menu" aria-lablledby="navbarDropdownSignupLink">
                            <a class="dropdown-item" href="signup.php">User</a>
                            <a class="dropdown-item" href="signup-organizer.php">Organizer</a>
                        </div>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link" href="create-ticket.php">Create Ticket</a>
                    </li>
                <?php } else { ?> 
                    <li class="nav-item"> 
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link" href="requests.php">Requests</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/fox.jpg" width="40" height="40" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Dashboard</a>
                            <a class="dropdown-item" href="#">Edit Profile</a>
                            <a class="dropdown-item" href="logout.php">Log Out</a>
                        </div>
                    </li>
                <?php } ?>
                
            </div>
        </div>
    </nav>
</div>