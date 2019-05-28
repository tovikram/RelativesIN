<?php
date_default_timezone_set("Asia/Kolkata");

$arrayFinalSuggestion = array();

$moreDetailsQuery = "SELECT * FROM more_details WHERE familyinID = $id";
$resultMoreDetails=mysqli_query($conn,$moreDetailsQuery,MYSQLI_USE_RESULT);
$rowMoreDetails = $resultMoreDetails->fetch_assoc();
$resultMoreDetails->close();

if($rowMoreDetails['iAmMemberOf'] != NULL){
    $tempTotalSuggetionMembers = $rowMoreDetails['iAmMemberOf'] . "";
}
else{
    $tempTotalSuggetionMembers = "" ;
}

if($rowMoreDetails['membersID'] == NULL){
    if($tempTotalSuggetionMembers != ""){
        $tempArray = preg_split("/-/", $tempTotalSuggetionMembers);
        for($i = 0;$i < count($tempArray) ; $i++){
            $substringInInteger = $tempArray[$i];
            settype($substringInInteger,'int');
            $arrayFinalSuggestion[$i] = $substringInInteger ;
            //$index +=1;
        }
    }else{
        $arrayFinalSuggestion[0] = 0;
    }
}
else{
    $arrayMembersId = array();
    $arrayTemp1 = array();
    $arrayTemp1 = preg_split("/-/", $rowMoreDetails['membersID']);
    for($j=0 ; $j < count($arrayTemp1); $j++){
        $varTemp = $arrayTemp1[$j];
        settype($varTemp,'int');
        $arrayMembersId[$j] = $varTemp;
    }

    for($i = 0 ;$i < count($arrayMembersId) ;$i++){
        if ($arrayMembersId[$i] != NULL) {
            $aMemberId = $arrayMembersId[$i] ;
            $fetchMembersQuery = "SELECT membersID FROM more_details WHERE familyinID = $aMemberId";
            $resultMembersQuery = mysqli_query($conn,$fetchMembersQuery,MYSQLI_USE_RESULT);
            $rowMemberQuery = $resultMembersQuery->fetch_assoc();
            if($rowMemberQuery['membersID'] != NULL){
                if($tempTotalSuggetionMembers == ""){
                    $tempTotalSuggetionMembers =  $rowMemberQuery['membersID'];
                }else{
                    $tempTotalSuggetionMembers = $tempTotalSuggetionMembers ."-".  $rowMemberQuery['membersID'];
                }
            }
            $resultMembersQuery->close();
        }
    }
    
    $arrayTotalMembers = array();
    $arrayTemp2 = array();
    $arrayTemp2 = preg_split("/-/", $tempTotalSuggetionMembers);
    for($j=0 ; $j < count($arrayTemp2); $j++){
        $varTemp = $arrayTemp2[$j];
        settype($varTemp,'int');
        $arrayTotalMembers[$j] = $varTemp;
    }
    
    //filtering ids
    $index = 0;
    for($k = 0; $k < count($arrayTotalMembers); $k++){
        if($arrayTotalMembers[$k] != $id){
            $flag = 0;
            for($m=0; $m < count($arrayMembersId);$m++){
                if($arrayMembersId[$m] == $arrayTotalMembers[$k]){
                    $flag = 1;
                    break;
                }
            }
            if($flag == 0){
                $arrayFinalSuggestion[$index] = $arrayTotalMembers[$k];
                $index += 1 ;
            }
        }
    }
    
    if($index <= 0){
        $arrayFinalSuggestion[0] = 0;
    }
    //echo "<script>alert('". $tempTotalSuggetionMembers ."');</script>"; 
}

?>