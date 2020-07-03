<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "goal";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    echo "Error: Unable to connect to MySQL Server.". mysqli_connect_error();
}
else {
    $db = mysqli_select_db($conn, $database);

    if (!$db) {
        echo "Error: Unable to connect to ".$database;
    }
    else {
        // Only for debbug
        //echo "Success!";
    }
}