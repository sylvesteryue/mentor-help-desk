<?php
    require 'config/config.php';

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($mysqli->connect_errno){
        echo $mysqli->connect_error;
        exit();
    }

    $sql = "SELECT * FROM tickets";

    $results = $mysqli->query($sql);

    if(!$results)
    {
        echo $mysqli->connect_error;
        exit();
    }
    $mysqli->close();

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mentor Helpdesk</title>

        <!-- Stylesheets -->
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" type="text/css" href="css/requests.css"/>

        <!--Bootstrap-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    </head>
    <body>
        <?php include 'nav/nav.php'; ?>


        <div id="content">
            <table id="requests" class="table">
                <tbody>
                    <tr id="table-header">
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Hacker</th>
                        <th>Table #</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Topic</th>
                        <?php if(isset($_SESSION['organizer']) && $_SESSION['organizer']) { ?>
                            <th>Delete</th>
                        <?php } ?>
                    </tr>

                    <?php while ($row = $results->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['ticket_id'];?></td>
                            <td style="cursor:pointer"><a href="view-ticket.php?ticket_id=<?php echo $row['ticket_id']?>"><?php echo $row['ticket_title'];?></a></td>
                            <td><?php echo $row['hacker_name'];?></td>
                            <td><?php echo $row['table_number'];?></td>
                            <td><?php if(is_null($row['mentor_assigned'])) { ?>
                                    <?php if(isset($_SESSION['organizer']) && $_SESSION['organizer']) { ?>
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assign</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item">Name</a>
                                        </div>
                                    <?php } else {?>
                                        <button class="btn btn-primary dropdown">Assign</button>
                                    <?php } ?>
                                <?php } else {
                                    echo $row['mentor_assigned'];
                                    }
                                ?>
                            </td>
                            <?php if ($row['resolved']) { ?>
                                <td>Resolved</td>
                            <?php } else { ?>
                                <td>Open</td>
                            <?php } ?>
                            <td><?php echo $row['date_time'];?></td>
                            <td><?php switch($row['topic_id']) {
                                        case 1:
                                            echo 'Web Development';
                                            break;
                                        case 2:
                                            echo 'Mobile App Development';
                                            break;
                                        case 3:
                                            echo 'Hardware Development';
                                            break;
                                        default:
                                            echo '-';
                                            break;  
                                    }
                                ?>
                            </td>
                            <?php if(isset($_SESSION['organizer']) && $_SESSION['organizer']) { ?>
                            <td><button class="btn btn-danger">Delete</button></td>
                            <?php } ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <!--Bootstrap-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>