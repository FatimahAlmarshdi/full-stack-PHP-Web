<?php 
    $name = "localhost";
    $username = "root";
    $password = "";
    $db_name = "check";  
    $conn = new mysqli($name, $username, $password, $db_name, 3306);
    if($conn->connect_error){
        die("Connection failed".$conn->connect_error);
    }
    echo " ";
    
    ?>