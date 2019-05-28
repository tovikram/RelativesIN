<?php  
date_default_timezone_set("Asia/Kolkata");

require_once "../proPages/encryptDecryptData.php";

$sql = "select * from otp_details where familyinID=".$GLOBALS['id']." and otpType='updateContact' ORDER BY otpDateTime DESC LIMIT 0 , 1";
$otpRow = mysqli_query($conn,$sql,MYSQLI_USE_RESULT);
$otpRowArray =$otpRow->fetch_assoc();
$otpRow->close();



if($newContactOtp == $otpRowArray['otpCode']){
    $query = "UPDATE signup_family_in SET userContact='".$newContact."' WHERE familyinID=".$GLOBALS['id'];
    if ($conn->query($query)){
        $msg = 'OTP verified ! Number Updated Successfully.';
        header("location: ../pages/updateProfileDetails.php?field=".encyptData("contact")."&o=".encyptData("false")."&er=".encyptData($msg));
    }else{
        //$msg = 'Something is wrong in updating';
        //header("location: ../pages/updateProfileDetails.php?field=".encyptData("contact")."&o=".encyptData("false")."&er=".encyptData($msg));
        header("Location: ../pages/errorPage.php");
    }
}
else{
    $msg = 'OTP Not verified ! Not valid OTP';
    header("location: ../pages/updateProfileDetails.php?field=".encyptData("contact")."&o=".encyptData("false")."&er=".encyptData($msg));
}

?>