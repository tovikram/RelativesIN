<?php
date_default_timezone_set("Asia/Kolkata");

include 'encryptDecryptData.php';

if(isset($_GET['myId']) && isset($_GET['myStatus'])){
    $myId = decryptData($_GET['myId']);
    $myStatus = $_GET['myStatus'];
    settype($myId,'int');
    require_once 'connectDatabase.php';
    $outputData = "";

    $sql = "UPDATE more_details SET myStatus='".$myStatus."' WHERE familyinID =$myId";
    if ($conn->query($sql) === TRUE) {
        $outputData="changed";
    }else{
        //$outputData="something is wrong";
        header("Location: ../pages/errorPage.php");
    }

    echo $outputData;
}

?>