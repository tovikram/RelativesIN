<?php
date_default_timezone_set("Asia/Kolkata");

$servername = "localhost";  // server name or address wich is hosting the website
$username = "root"; // user id of that server 
$password = ""; // password for the given id 
$dbname = "familyin"; // data base name created for the website 

// Create connection to database with the help of given details
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection if connection is success or not ...if not then throw an error 
if ($conn->connect_error) {
    //die("Connection failed: " . $conn->connect_error);
    header("Location: ../pages/errorPage.php");
} 
?>