<?php
    require 'config/config.php';

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($mysqli->connect_errno)
    {
        echo $mysqli->connect_error;
        exit();
    }

    if(isset($_POST['requester-name']) && isset($_POST['requester-email']) && isset($_POST['topic']) && isset($_POST['requester-table-num']) && isset($_POST['title']) && isset($_POST['post-description']))
    {
        if(empty($_POST['requester-name']) || empty($_POST['requester-email']) || empty($_POST['topic']) || empty($_POST['post-description']))
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

            $sql_ticket = "INSERT INTO tickets(hacker_name, hacker_email, table_number, topic_id, description, ticket_title, date_time) VALUES('" . $_POST["requester-name"] . "', '" . $_POST["requester-email"]  . "', '" . $_POST["requester-table-num"] . "', '" . $_POST["topic"] . "', '" . $description . "', '" . $_POST["title"] . "', NOW()); ";

            $results_ticket = $mysqli->query($sql_ticket);


            if(!$results_ticket)
            {
                echo $mysqli->error;
                exit();
            }

            header("Location: created-success.php");                   

            
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
            <form class="forms" action="create-ticket.php" method="POST">
                <div class="form-group">
                    <label for="requester-name">Name</label>
                    <input type="text" class="form-control" id="requester-name" name="requester-name" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label for="requester-email">Email address</label>
                    <input type="email" class="form-control" id="requester-email" name="requester-email" aria-describedby="emailHelp" placeholder="Enter email">
                </div>

                <div class="form-group">
                    <label for="requester-table">Table # (if applicable)</label>
                    <input type="number" class="form-control" name="requester-table-num" id="requester-table-num">
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title">
                </div>
                <div class="form-group">
                    <label for="topic">Category</label>
                    <select class="form-control" id="topic" name="topic">
                        <option value="" selected>-- Select Category --</option>
                        <option value="1">Web Development</option>
                        <option value="2">Mobile App Development</option>
                        <option value="3">Hardware</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="post-description">Description</label>
                    <textarea type="text" class="form-control" id="post-description" name="post-description"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Attachments</label>
                    <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1">
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