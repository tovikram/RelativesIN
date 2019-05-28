<?php
ob_start();
session_start(); // staring session on this page

date_default_timezone_set("Asia/Kolkata");

include "connectDatabase.php";


$getIdQuery = "SELECT familyinID from signup_family_in where userEmail = '".$_SESSION['user']."'";
$resultGetId=mysqli_query($conn,$getIdQuery,MYSQLI_USE_RESULT);
$rowGetiId = $resultGetId->fetch_assoc();
$resultGetId->close();
$id = $rowGetiId['familyinID']; // user's id 
$GLOBALS["id"] = $id;

$statusUpdateQuery= "UPDATE more_details SET onlineStatus=now() WHERE familyinID=".$GLOBALS['id'];

if($conn->query($statusUpdateQuery)){
    return true;
}else{
    return false;
}

?>