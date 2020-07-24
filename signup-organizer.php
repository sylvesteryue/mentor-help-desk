<?php
    require 'config/config.php';

    if(isset($_POST['signup-full-name']) && isset($_POST['signup-email']) && isset($_POST['signup-password']) && isset($_POST['signup-cpassword']))
    {
        if(empty($_POST['signup-full-name']) || empty($_POST['signup-email']) || empty($_POST['signup-password']) || empty($_POST['signup-cpassword']))
        {
            $signupError = "Please fill in all fields.";
        }
        else
        {   
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if($mysqli->connect_errno)
            {
                echo $mysqli->connect_error;
                exit();
            }

            $sql = "SELECT * FROM organizers WHERE email = '" . $_POST["signup-email"] . "'; ";

            $result = $mysqli->query($sql);

            if(!$result)
            {
                echo $mysqli->error;
                exit();
            }

            if($result->num_rows > 0) {
                $signupError = "Email already in use.";
            }
            else
            {
               if($_POST['signup-password'] == $_POST['signup-cpassword'])
               {
                   $password = hash("sha256", $_POST["signup-password"]);
                   $sql_signup = "INSERT INTO organizers(email, password, full_name) VALUES('" . $_POST["signup-email"] . "', '" . $password . "', '" . $_POST["signup-full-name"] . "'); ";

                   $results_signup = $mysqli->query($sql_signup);
                   if(!$results_signup)
                   {
                       echo $mysqli->error;
                       exit();
                   }

                   $_SESSION["user"] = $_POST["login-email"];
                   $_SESSION["logged-in"] = true;
                   $_SESSION["organizer"] = true;

                   header("Location: home.php");                   
               }
               else
               {
                    $signupError = "Passwords don't match";
               }
            }

            
        }

        $mysqli->close();
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
        <link rel="stylesheet" type="text/css" href="css/signup.css"/>

        <!--Bootstrap-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    </head>
    <body>

        <form action="signup-organizer.php" method="POST" class="form-signup">
            <h1 class="h3 mb-3 font-weight-normal">Sign up!</h1>
            <label for="signup-full-name" class="sr-only">Full Name</label>
            <input type="text" id="signup-full-name" name="signup-full-name" class="form-control" placeholder="Full Name">
            <label for="signup-email" class="sr-only">Email address</label>
            <input type="email" id="signup-email" name="signup-email" class="form-control" placeholder="Email address" required="" autofocus="">
            <label for="signup-password" class="sr-only">Password</label>
            <input type="password" id="signup-password" name="signup-password" class="form-control" placeholder="Password" required="">
            <label for="signup-cpassword" class="sr-only">Confirm Password</label>
            <input type="password" id="signup-cpassword" name="signup-cpassword" class="form-control" placeholder="Confirm Password" required="">
            
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>

            <div id="create-error" class="text-danger font-italic">
                <?php 
                    if(isset($signupError) && !empty($signupError)){
                        echo $signupError;
                    }    
                ?>
            </div>
        </form>

        <!--Bootstrap-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>