<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hms";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($con->connect_error) {
    // Redirect to error page if connection fails
    header("Location: index.php");
    exit();
}

// Check if database exists
if (!mysqli_select_db($con, $dbname)) {
    // Redirect to error page if database selection fails
    header("Location: index.php");
    exit();
}

include ("functions.php");

date_default_timezone_set("Asia/Karachi");
$current_date = date('Y-m-d');
$current_timestamp = date('Y-m-d H:i:s');
$current_time = date('H:i:s');
?>