<?php
date_default_timezone_set("Asia/Kolkata");

//query for fetching the user's data for displaying
$nameQuery = "SELECT * from signup_family_in where userEmail = '".$_SESSION['user']."'";
$result=mysqli_query($conn,$nameQuery,MYSQLI_USE_RESULT);
$result2 = $result->fetch_assoc();
$name = $result2["userFirstName"]; //user name
$id = $result2['familyinID']; // user's id 
$GLOBALS["id"] = $id;
$result->close(); // closing query result

//query for fetching the user's deatils for more_details table
$queryMoreDetails = "SELECT * FROM more_details WHERE familyinID = $id ";
$resultMoreDetails=mysqli_query($conn,$queryMoreDetails,MYSQLI_USE_RESULT);
$rowMoreDetails = $resultMoreDetails->fetch_assoc();

$resultMoreDetails->close(); // closing query result

$GLOBALS["result2"]=$result2;
$GLOBALS["rowMoreDetails"]=$rowMoreDetails;

function calculateProfilePercentage(){
    $varKey = array_keys($GLOBALS["rowMoreDetails"]);
    $varValues = array_values($GLOBALS["rowMoreDetails"]);
    $var2Key = array_keys($GLOBALS["result2"]);
    $var2Values = array_values($GLOBALS["result2"]);
    $columnKeyArray = array_merge($varKey,$var2Key);
    $columnValueArray = array_merge($varValues,$var2Values);
    $notFilledCount = 0;
    $requireColumnArray = array("userFirstName","userContact","userEmail","profile_image","userGender","userDOB");
    for($i=0;$i<=count($columnValueArray) - 1 ;$i++){
        if((in_array($columnKeyArray[$i],$requireColumnArray))){
            if($columnValueArray[$i] == null){
                $notFilledCount++;
            }
            if($columnValueArray[$i] == "null.png"){
                $notFilledCount++;
            }
        }
    }
    $filledCount = count($requireColumnArray) - $notFilledCount;
    $profilePercentage = round(($filledCount/count($requireColumnArray))*100);
    return $profilePercentage;
}


?>