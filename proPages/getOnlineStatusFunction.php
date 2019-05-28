<?php
date_default_timezone_set("Asia/Kolkata");

function getOnlineStatus($id,$conn){
    $query = "SELECT onlineStatus FROM more_details WHERE familyinID = $id";
    $resultQuery= mysqli_query($conn,$query,MYSQLI_USE_RESULT);
    $rowQuery = $resultQuery->fetch_assoc();
    $resultQuery->close();

    $currentDateTime = new DateTime((string)date("Y-m-d H:i:s"));
    $lastOnlineTime = (string)$rowQuery['onlineStatus'];
    $differenceTime = $currentDateTime->diff(new DateTime($lastOnlineTime));

    if($differenceTime->y ==0 && $differenceTime->m==0 && $differenceTime->d==0 && $differenceTime->h==0 && $differenceTime->i <3){
        return 1;
    }else{
        return 0;
    }
}

?>