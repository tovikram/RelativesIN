<?php
date_default_timezone_set("Asia/Kolkata");

session_start();

require_once 'connectDatabase.php';

$emailID = $_SESSION['user'];
$getQuery = "SELECT * from signup_family_in where userEmail ='". $emailID ."'";
$res2=mysqli_query($conn,$getQuery,MYSQLI_USE_RESULT);
$row2 = $res2->fetch_assoc();
$res2->close();
$id2 = $row2['familyinID'];
$updateQuery2= "UPDATE more_details SET onlineStatus='offline' WHERE familyinID=".$id2;
mysqli_query($conn,$updateQuery2,MYSQLI_USE_RESULT);

unset($_SESSION['user']);
session_unset();
session_destroy();
header("Location: ../index.php");
exit;
?>