<?php
date_default_timezone_set("Asia/Kolkata");

include "getOnlineStatusFunction.php";

$membersIdArray = array();
if($GLOBALS['rowMoreDetails']['membersID'] != NULL){
    $membersIdArray = preg_split("/-/", $GLOBALS['rowMoreDetails']['membersID']);
    $membersIdIntArray = array();
    for($i=0;$i<count($membersIdArray);$i++){
        $arrayElement = $membersIdArray[$i];
        settype($arrayElement,'int');
        $membersIdIntArray[$i] = $arrayElement;
    }

    $relationsNameArray = array();
    $relativeFirstNameArray = array();
    $relativeLastNameArray = array();
    $relativeProfileImageArray = array();
    $relativeOnlineStatusArray = array();
    $relativeIdArray = array();
    $index = 0 ;
    for($j=0;$j<count($membersIdIntArray);$j++){
        $sqlQuery = "SELECT * FROM relationsdetails WHERE familyinID=".$GLOBALS['id']." and memberID=".$membersIdIntArray[$j];
        $resultSqlQuery= mysqli_query($conn,$sqlQuery,MYSQLI_USE_RESULT);
        $rowSqlQuery = $resultSqlQuery->fetch_assoc();
        $resultSqlQuery->close();
        if(count($rowSqlQuery) != 0){
            //Code for Fetching first and last name from database
            $sqlQuery2 = "SELECT userFirstName,userLastName from signup_family_in where familyinID = $membersIdIntArray[$j]";
            $resultSqlQuery2= mysqli_query($conn,$sqlQuery2,MYSQLI_USE_RESULT);
            $rowSqlQuery2 = $resultSqlQuery2->fetch_assoc();
            $resultSqlQuery2->close();
            //Code for fetching Profile image name from database
            $sqlQuery3 = "SELECT familyinID,profile_image FROM more_details WHERE familyinID = $membersIdIntArray[$j]";
            $resultSqlQuery3= mysqli_query($conn,$sqlQuery3,MYSQLI_USE_RESULT);
            $rowSqlQuery3 = $resultSqlQuery3->fetch_assoc();
            $resultSqlQuery3->close();
            if(count($rowSqlQuery2) != 0 && count($rowSqlQuery3) != 0){
                $relativeFirstNameArray[$index] = $rowSqlQuery2['userFirstName'];
                $relativeLastNameArray[$index] = $rowSqlQuery2['userLastName'];
                $relationsNameArray[$index] = $rowSqlQuery['relation'];
                $relativeProfileImageArray[$index] = $rowSqlQuery3['profile_image'];
                $relativeIdArray[$index] = $rowSqlQuery3['familyinID'];
                $relativeOnlineStatusArray[$index] = getOnlineStatus($membersIdIntArray[$j],$conn);
                $index += 1;
            }else{
               // $errMsg = "Something Went Wrong2";
               header("Location: ../pages/errorPage.php");
            } 

        }else{
            //$errMsg = "Something Went Wrong1";
            header("Location: ../pages/errorPage.php");
        }
    }
}else{
    $membersCount = 0;
    $relationsNameArray = array();
    $relativeFirstNameArray = array();
    $relativeLastNameArray = array();
}


?>