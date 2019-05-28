<?php
date_default_timezone_set("Asia/Kolkata");

$otpCode = mt_rand(10000, 99999);;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://api.msg91.com/api/v2/sendsms?campaign=&response=&afterminutes=&schtime=&unicode=&flash=&message=&encrypt=&authkey=&mobiles=&route=&sender=&country=91",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_PROXYPORT => 80,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{ \"sender\": \"SOCKET\", \"route\": \"4\", \"country\": \"91\", \"sms\": [ { \"message\": \"$otpCode is Your Varification code for RelativesIn\", \"to\": [ \"$newContact\" ] } ] }",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTPHEADER => array(
    "authkey: your_MS91_account_authkey",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    //$msg = 'something is wrong in OTP sending';
    //header("location: ../pages/updateProfileDetails.php?field=".encyptData("contact")."&o=".encyptData("false")."&er=".encyptData($msg));
    header("Location: ../pages/errorPage.php");
    //echo "cURL Error #:" . $err;
} else {
    $sql = "INSERT INTO otp_details(familyinID,userEmail,userContact,otpType,otpCode,otpDateTime) values(".$GLOBALS['id'].",NULL,$newContact,'updateContact','".$otpCode."',now())";
    if ($conn->query($sql) === TRUE) {
        header('location: ../pages/updateProfileDetails.php?field='.encyptData('contact').'&o='.encyptData('true').'&nc='.encyptData($newContact));
    }else{
        //$msg = 'some thing is worng while inserting';
        //header("location: ../pages/updateProfileDetails.php?field=".encyptData("contact")."&o=".encyptData("false")."&er=".encyptData($msg));
        header("Location: ../pages/errorPage.php");
    }
}


?>