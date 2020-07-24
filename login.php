<?php
    require 'config/config.php';

    if(!isset($_SESSION["logged-in"]) || !$_SESSION["logged-in"])
    {
        if(isset($_POST["login-email"]) && isset($_POST["login-password"]))
        {
            if(empty($_POST['login-email']) || empty($_POST['login-password']))
            {
                $loginError = "Please enter your email and password.";
            }
            else
            {
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if($mysqli->connect_errno)
                {
                    echo $mysqli->connect_error;
                    exit();
                }

                $passwordInput = hash("sha256", $_POST["login-password"]);

                $sql = "SELECT * FROM users WHERE email = '" . $_POST["login-email"] . "' AND password = '" . $passwordInput . "'; ";

                $result = $mysqli->query($sql);

                if(!$result)
                {
                    echo $mysqli->error;
                    exit();
                }

                if($result->num_rows > 0) {
                    $_SESSION["user"] = $_POST["login-email"];
                    $_SESSION["logged-in"] = true;
                    $_SESSION["organizer"] = false;

                    header("Location: home.php");
                }
                else
                {
                    $loginError = "Invalid email or password.";
                }

                $mysqli->close();
                   
            }
        }
    }
    else
    {
        header("Location: home.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mentor Helpdesk</title>

        <!-- Stylesheets -->
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" type="text/css" href="css/login.css"/>

        <!--Bootstrap-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    </head>
    <body>
            <form class="form-signin" method="POST" action="login.php">
                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                <label for="login-email" class="sr-only">Email address</label>
                <input type="email" id="login-email" name="login-email" class="form-control" placeholder="Email address" required="" autofocus="">
                <label for="login-password" class="sr-only">Password</label>
                <input type="password" id="login-password" name="login-password" class="form-control" placeholder="Password" required="">
                <div class="checkbox mb-3">
                  <label>
                    <input type="checkbox" value="remember-me"> Remember me
                  </label>
                </div>
                <div id="create-error" class="text-danger font-italic">
                <?php 
                    if(isset($loginError) && !empty($loginError)){
                        echo $loginError;
                    }    
                ?>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>
   

        <!--Bootstrap-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>