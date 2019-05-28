<?php

require_once "encryptDecryptData.php";
require_once "sendMailAndOTPMethods.php";

date_default_timezone_set("Asia/Kolkata");

$errorMsg = "";
$logolink = "../index.php";
$logoUrl = "../img/familyinbrand.png";
$customCssUrl ="../css/custom.css";
$bootstrapMinCssUrl = "../css/bootstrap.min.css";
$feviconLink = "../favicon.ico";

function getDetailsOfLostMember($mailToSearch,$conn){
    $sqlQuery = "SELECT familyinID,userFirstName,userLastName,userContact FROM signup_family_in WHERE userEmail='".$mailToSearch."'";
    $resultSqlQuery= mysqli_query($conn,$sqlQuery,MYSQLI_USE_RESULT);
    $rowSqlQuery = $resultSqlQuery->fetch_assoc();
    $resultSqlQuery->close();

    if(count($rowSqlQuery) != 0){
        $GLOBALS['nameOfMember'] = $rowSqlQuery['userFirstName']." ".$rowSqlQuery['userLastName'];
        $GLOBALS['memberID'] = $rowSqlQuery['familyinID'];
        $GLOBALS['emailOfMember'] = $mailToSearch;
        if($rowSqlQuery['userContact']==null || trim($rowSqlQuery['userContact'])==""){
            $GLOBALS['contactOfMember'] = null;
        }else{
            $GLOBALS['contactOfMember'] = $rowSqlQuery['userContact'];
        }
        return TRUE;
    }else{
        return FALSE;
    }
}

function sendCodeforForgotPass($methodValue,$conn){
    $methodType = substr($methodValue,0,1);
    $methodConvertedValue = decryptData(substr($methodValue,1));
    $findLenArray = preg_split("/#/", $methodConvertedValue);
    $idLen = $findLenArray[1];
    settype($idLen,'int');
    $id =substr($findLenArray[0],strlen($findLenArray[0])-$idLen,$idLen);
    switch($methodType){
        case '1'://sending on email
            $emailId = substr($findLenArray[0],0,strlen($findLenArray[0])-$idLen);
            $status = sendCodeLinkOnMail($emailId,$id,$conn);
            if($status){
                header('location: resetPassword.php?em='.encyptData("1").'&sn='.encyptData("3").'&md='.$methodValue);
            }else{
                //echo "<script>alert('Something Wrong !');</script>";
                header("Location: ../pages/errorPage.php");
            }
            break;
        
        case '2'://sending on mobile
            $mobileNumber = substr($methodConvertedValue,0,10);
            $status = sendCodeOnMobile($mobileNumber,$id,$conn);
            if($status){
                header('location: resetPassword.php?em='.encyptData("1").'&sn='.encyptData("3").'&md='.$methodValue);
            }else{
                //echo "<script>alert('Something Wrong !');</script>";
                header("Location: ../pages/errorPage.php");
            }
            break;
        
        default:
            //echo "<script>alert('Something Wrong !');</script>";
            header("Location: ../pages/errorPage.php");
            break;
    }
    
}

function getMethodType($methodValueDecrypted){
    $methodType = substr($methodValueDecrypted,0,1);
    return $methodType;
}

function getFromMethodDetails($methodDetails,$requirement){
    $methodConvertedValue = decryptData(substr($methodDetails,1));
    $findLenArray = preg_split("/#/", $methodConvertedValue);
    $idLen = $findLenArray[1];
    settype($idLen,'int');
    $id =substr($findLenArray[0],strlen($findLenArray[0])-$idLen,$idLen);
    settype($id,'int');
    $methodValue = substr($findLenArray[0],0,strlen($findLenArray[0])-$idLen);
    switch ($requirement) {
        case 'id':
            return $id;
            break;
            
        case 'value':
            return $methodValue;
            break;
        
        default:
            return NULL;
            break;
    }
}

function verifyOTP($otp,$methodDetails,$conn){
    $id = getFromMethodDetails($methodDetails,'id');
    $sql = "select * from otp_details where familyinID=$id and otpType='changePassword' ORDER BY otpDateTime DESC LIMIT 0 , 1";
    $otpRow = mysqli_query($conn,$sql,MYSQLI_USE_RESULT);
    $otpRowArray =$otpRow->fetch_assoc();
    $otpRow->close();
    $methodType = substr($methodDetails,0,1);
    switch ($methodType) {
        case '1':
            if (getFromMethodDetails($methodDetails,'value')==$otpRowArray['userEmail'] && $otp==$otpRowArray['otpCode']) {
                header('location: setNewPassword.php?d='.encyptData($id).'&t='.encyptData((string)date("Y-m-d H:i:s")));
            }
            break;

        case '2':
            if (getFromMethodDetails($methodDetails,'value')==$otpRowArray['userContact'] && $otp==$otpRowArray['otpCode']) {
                header('location: setNewPassword.php?d='.encyptData($id).'&t='.encyptData((string)date("Y-m-d H:i:s")));
            }
            break;
        
        default:
            header('location: resetPassword.php');
            break;
    }
    
}

?>