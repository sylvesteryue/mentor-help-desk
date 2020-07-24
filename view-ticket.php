<?php
    require 'config/config.php';

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($mysqli->connect_errno){
        echo $mysqli->connect_error;
        exit();
    }

    $sql_find_ticket = "SELECT * FROM tickets WHERE ticket_id = '" . $_GET['ticket_id'] ."';";

    $ticket_id = $_GET['ticket_id'];

    $results_find_ticket = $mysqli->query($sql_find_ticket);

    if(!$results_find_ticket)
    {
        echo $mysqli->error;
        exit();
    }

    $ticket = $results_find_ticket->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mentor Helpdesk</title>

        <!-- Stylesheets -->
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" type="text/css" href="css/view-ticket.css"/>

        <!--Bootstrap-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    </head>
    <body>
       <?php include 'nav/nav.php'; ?>

        <div id="content" class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h1><?php echo $ticket['ticket_title']; ?></h1>
                            </div>
                            <div class="card-text">
                                <p><?php echo $ticket['hacker_name']; ?>, <?php echo $ticket['date_time']; ?></p>
                            </div>
                            <div class="card">
                                <h5 class="card-header">Description</h5>
                                <div class="card-body">
                                    <div class="card-text">
                                        <p><?php echo $ticket['description']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#resolutionModal">Resolve</button>
                        </div>
                        
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <h5 class="card-header">Additional Details</h5>
                        <div class="card-body">
                            <div class="card-text">
                                <p>Topic: 
                                    <?php switch($ticket['topic_id']) {
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
                                </p>
                                <p>Mentor Assigned: 
                                    <?php if($ticket['mentor_assigned']) {
                                            echo $ticket['mentor_assigned'];
                                        } else {
                                        echo "-"; 
                                        }?>
                                </p>
                                <p>Status:
                                    <?php if($ticket['resolved']) {
                                            echo "Resolved";
                                        } else {
                                            echo "Open"; 
                                        }?>
                                </p>
                                <?php if(isset($_SESSION["organizer"]) && $_SESSION["organizer"]) { ?>
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assign</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item">Name</a>
                                        </div>
                                <?php } else { ?>
                                    <button class="btn btn-primary">Assign</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>


          <div class="card">
            <div class="card-header">
              <h6>Reply</h6>
            </div>
            <div class="card-body">
              <form>
                <div class="form-group">
                  <textarea name="post-reply" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
              </form>
              </div>
          </div>
      
          <div class="card" id="reply">
            <div class="card-header">
              <h6>Mentor Name</h6>
              <p>Date and Time</p>
            </div>
            <div class="card-body">
              <div class="card-title">
                <p>Here are some links: blah blah blah</p>
              </div>
            </div>
          </div>  
        </div>


        <!-- The Modal -->
        <div id="myModal" class="modal">

        <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Modal Header</h2>
                </div>
                <div class="modal-body">
                    <p>Some text in the Modal Body</p>
                    <p>Some other text...</p>
                </div>
                <div class="modal-footer">
                    <h3>Modal Footer</h3>
                </div>
            </div>

        </div>


        <div class="modal" id="resolutionModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Resolution</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="db/db_resolve_ticket.php?ticket_id="<?php echo $_GET['ticket_id']?> id="resolution-form">
                            <div class="form-group">
                                <textarea name="resolution" class="form-control" rows="3"></textarea>
                                <input type="submit" id="submit-resolution" style="display:none" />
                            </div>
                            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submit-resolution-button">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <?php $mysqli->close() ?>


        <script> 
            var modal = document.getElementById("myModal");

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on the button, open the modal
            btn.onclick = function() {
                modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>

        <script>

            $(document).ready(function() {
                $("#submit-resolution-button").click(function() {
                    $("#resolution-form").submit();
                });
             });
            // function ajaxGet(endpointUrl, returnFunction) {
            //     let xhr = new XMLHttpRequest();
            //     xhr.open('GET', endpointUrl, false);
            //     xhr.onreadystatechange = function() {
            //         if (xhr.readyState == XMLHttpRequest.DONE) {
            //             if (xhr.status == 200) {
            //                 returnFunction(xhr.responseText);
            //             }
            //             else {
            //                 alert('AJAX Error.');
            //                 console.log(xhr.status);
            //             }
            //         }
            //     }
            //     xhr.send();
            // }

            // $("#submit-resolution").on("click", function() {
            //     let ticket_id = "";
            //     console.log(ticket_id)
            //     let resolution = $.trim($("#post-resolution").val());
            //     console.log(resolution);    
			//     ajaxGet("db/db_resolve_ticket.php?quiz_id=" + ticket_id + "&resolution=" + resolution, function(results) {});
			//     location = "view-ticket.php?quiz_id=" + ticket_id;
            // });

        </script>


        <!--Bootstrap-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>