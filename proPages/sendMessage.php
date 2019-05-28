<?php
date_default_timezone_set("Asia/Kolkata");

include 'encryptDecryptData.php';


if(isset($_GET['partnerId']) && isset($_GET['message'])){
    $message = nl2br($_GET['message']);
    $myId = $_GET['myId'];
    $partnerId = decryptData($_GET['partnerId']);
    settype($partnerId,'int');

    require_once 'connectDatabase.php';
    $outputData = "";

    $sql = "INSERT INTO message_details(from_id,to_id,message_text,message_datetime) VALUES ($myId,$partnerId,'".$message."',now())";
    if ($conn->query($sql) === TRUE) {
        $outputData="<div style='text-align:right;padding: 5px;'>
            <div style='width:70%;padding-right:10px;padding-left:10px;border:solid green;display: inline-block;background:#40ed93;border:solid #008c43 0.5px;border-radius:15px;'><span>".$message."</span></div>
        </div>";
    }else{
        $outputData="";
    }

    echo $outputData;
}


?>