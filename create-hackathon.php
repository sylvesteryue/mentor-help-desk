<?php
    require 'config/config.php';

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($mysqli->connect_errno)
    {
        echo $mysqli->connect_error;
        exit();
    }

    if(isset($_POST['hackathon-name']) && isset($_POST['hackathon-start-date'])  && isset($_POST['hackathon-end-date']) && isset($_POST['hackathon-description']))
    {
        if(empty($_POST['hackathon-name']) || empty($_POST['hackathon-start-date']) || empty($_POST['hackathon-end-date']) || isset($_POST['hackathon-description']))
        {
            $createError = "Please fill in all fields.";
        }
        else
        {   
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if($mysqli->connect_errno)
            {
                echo $mysqli->connect_error;
                exit();
            }

            $open_status = 1;

            $description = $mysqli->real_escape_string($_POST['post-description']);

            $sql_hackathon = "INSERT INTO hackathon(name, description) VALUES('" . $_POST["hackathon-name"] . "', '" . $_POST["hackathon-description"]  . "'); ";

            $results_hackathon = $mysqli->query($sql_ticket);


            if(!$results_hackathon)
            {
                echo $mysqli->error;
                exit();
            }

            $hackathon = $results_hackathon->fetch_assoc();

            $sql_organizer = "SELECT * FROM organizers WHERE email = '" . $SESSION["user"] . "';";
            $result_organizer = $mysqli->query($sql_organizer);

            if(!$results_organizer)
            {
                echo $mysqli->error;
                exit();
            }

            $organizer = $result_organizer->fetch_assoc();


            $sql_add_organizer = "UPDATE organizers SET hackathon_id = '" . $hackathon["hackathon_id"] . "' WHERE user_id = '" . $organizer["organizer_id"] . "'; ";
            $result_add_organizer = $mysqli->query($sql_add_organizer);

            if(!$result_add_organizer)
            {
                echo $mysqli->error;
                exit();
            }


            header("Location: organizer-home.php");                   

            
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
        <link rel="stylesheet" type="text/css" href="css/create-ticket.css"/>

        <!--Bootstrap-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    </head>
    <body>
        <?php include 'nav/nav.php' ?>

        <div>
            <form class="forms" action="create-hackathon.php" method="POST">
                <div class="form-group">
                    <label for="requester-name">Name of Hackathon</label>
                    <input type="text" class="form-control" id="hackathon-name" name="requester-name" placeholder="Enter name">
                </div>

                <div class="form-group">
                    <label for="hackathon-start-date">Start Date</label>
                    <input type="date" class="form-control" name="hackathon-start-date" id="hackathon-start-date">
                </div>

                <div class="form-group">
                    <label for="hackathon-end-date">End Date</label>
                    <input type="date" class="form-control" name="hackathon-end-date" id="hackathon-end-date">
                </div>

                <div class="form-group">
                    <label for="post-description">Description</label>
                    <textarea type="text" class="form-control" id="post-description" name="post-description"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        

        <!--Bootstrap-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>