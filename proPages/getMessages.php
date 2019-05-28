<?php
date_default_timezone_set("Asia/Kolkata");

include 'encryptDecryptData.php';

if(isset($_GET['offset']) && isset($_GET['limit'])){
    $offset = $_GET['offset'];
    $limit = $_GET['limit'];
    $myId = $_GET['myId'];
    $partnerId = decryptData($_GET['partnerId']);

    require_once 'connectDatabase.php';
    $outputData = "";

    $data = mysqli_query($conn,"SELECT * FROM message_details WHERE from_id IN ( $myId, $partnerId ) AND to_id IN ( $myId, $partnerId ) ORDER BY message_datetime desc LIMIT $limit OFFSET $offset");
    while ($row = mysqli_fetch_array($data)) {
        if($row['from_id']==$myId){
            $outputData = "
                <div style='text-align:right;padding: 5px;'>
                    <div style='width:70%;padding-right:10px;padding-left:10px;border:solid green;display: inline-block;background:#40ed93;border:solid #008c43 0.5px;border-radius:15px;'><span>".$row['message_text']."</span></div>
                </div>" . $outputData;
        }else{
            $outputData =  "
            <div style='text-align:left;padding: 5px;'>
                <div style='width:70%;padding-right:10px;padding-left:10px;display: inline-block;background:#c8cbd1;border:solid #8a8b8e 0.5px;border-radius:15px;'><span>".$row['message_text']."</span></div>
            </div>" . $outputData;
        }
    }

    echo $outputData;
}

?>