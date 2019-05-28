<?php
date_default_timezone_set("Asia/Kolkata");

function getSourceString($conn){
    $sourceString = "source: [";
    $query = "SELECT DISTINCT relationEnglish FROM relations";
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()) {
        $sourceString = $sourceString."'". str_replace('\'', '`', $row['relationEnglish']) ."',";
    }
    $sourceString = substr($sourceString,0,strlen($sourceString)-1)."], minLength: 1";
    $result->close();

    return $sourceString;
}

function isRelationFromList($conn,$relationTypeSelected){
    $relationList = getSourceString($conn);
    $reFormatedSelectedRelation = str_replace('\'', '`', $relationTypeSelected);
    if(preg_match("/\b".$relationTypeSelected."\b/",$relationList) || preg_match("/\b".$reFormatedSelectedRelation."\b/",$relationList)){
        return true;
    }
    return false;
}

function isValidRelationType($conn,$relationTypeSelected){
    if($relationTypeSelected == "" || $relationTypeSelected == null){
        return false;
    }elseif(isRelationFromList($conn,$relationTypeSelected)){
        return true;
    }else{
        return true;
    }
}


?>