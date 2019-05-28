<?php


require_once 'encryptDecryptData.php';

date_default_timezone_set("Asia/Kolkata");

function sendCodeLinkOnMail($emailId,$id,$conn){
    
    require 'phpmailer/PHPMailerAutoload.php';
    $otpCode = mt_rand(10000, 99999);

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    //Set the hostname of the mail server
    $mail->Host = "smtp.gmail.com";
    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 25;
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication
    $mail->Username = "";//write your email address
    //Password to use for SMTP authentication
    $mail->Password = "";//write password for that email
    //Set who the message is to be sent from
    $mail->setFrom('your_email_address', 'FamilyIn');
    //Set an alternative reply-to address
    $mail->addReplyTo('your_email_address', 'FamilyIn');
    //Set who the message is to be sent to
    //$nameStr = $_COOKIE[$cookie_ufname] ." ". $_COOKIE[$cookie_ulname] ;
    //$nameStr = $tempFname ." ". $tempLname ;
    $mail->addAddress($emailId, "USER");
    //Set the subject line
    $mail->Subject = 'Reset password link for FamilyIn account';
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->isHTML(true);
    //Replace the plain text body with one created manually
    $verificationUniqueLink = "http://localhost/short%20web/pages/setNewPassword.php?d=".encyptData($id.'')."&t=".encyptData((string)date('Y-m-d H:i:s'));

    $mail->Body = 'Code : <b><h2>'.$otpCode.'</h2></b><br><h1>Or</h1><br><b>Click the following link to reset your password ! </b><br>'.$verificationUniqueLink;

    if (!$mail->send()) {
        echo "<script>alert('something is wrong on sending mail');</script>";
        return FALSE;
    } else {
        $sql = "INSERT INTO otp_details(familyinID,userEmail,userContact,otpType,otpCode,otpDateTime) values($id,'".$emailId."',NULL,'changePassword','".$otpCode."',now())";
        if ($conn->query($sql) === TRUE) {
            return TRUE;
        }else{
            echo "<script>alert('some thing is worng while inserting');</script>";
            return FALSE;
        }
    }
}

function sendCodeOnMobile($mobileNumber,$id,$conn){

    $otpCode = mt_rand(10000, 99999);

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
    CURLOPT_POSTFIELDS => "{ \"sender\": \"SOCKET\", \"route\": \"4\", \"country\": \"91\", \"sms\": [ { \"message\": \"$otpCode is Your one time code for reseting RelativesIn account password\", \"to\": [ \"$mobileNumber\" ] } ] }",
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
        echo "<script>alert('something is wrong in OTP sending');</script>";
        //echo "cURL Error #:" . $err;
        return FALSE;
    } else {
        $sql = "INSERT INTO otp_details(familyinID,userEmail,userContact,otpType,otpCode,otpDateTime) values($id,Null,'$mobileNumber','changePassword','".$otpCode."',now())";
        if ($conn->query($sql) === TRUE) {
            return TRUE;
            //header('location: ../pages/updateProfileDetails.php?field='.encyptData('contact').'&o='.encyptData('true').'&nc='.encyptData($newContact));
        }else{
            echo "<script>alert('some thing is worng while inserting');</script>";
            return FALSE;
        }
    }

}

?>