<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'project';
    $port = 3307;

    $con = mysqli_connect($host, $user, $pass, $db, $port);

    if (!$con) {
        die("Connection Failed: " . mysqli_connect_error());
    }
?>
