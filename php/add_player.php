<?php
    require_once("classes.php");

    $name = $_POST["name"];

    // Check that string contains only letters, number or ä ö å
    if(!preg_match('/[^A-Za-z0-9äöåÄÖÅ ]/', $name)) {
        Logic::AddPlayer($name);
        if(isset($_GET["from-mobile"])) {
            header("location: ../php/success.php");
        } else{
            header("location: ../index.php");
        }
    }
    else {
        echo "Invalid value! Only letters and numbers are accepted!";
    }
?>