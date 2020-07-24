<?php
    require 'config/config.php';

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->connect_errno) {
        echo $myslqi->connect_error;
        exit();
    }

    $sql_update_status = "UPDATE tickets SET open_status = '". $resolved . "' WHERE ticket_id = " . $_GET['ticket_id'] .";";

    $result_update_status = $mysqli->query($sql_update_status);
    if(!$sql_update_status)
    {
        $mysqli->error;
        exit();
    }

    $mysqli->close();
?>