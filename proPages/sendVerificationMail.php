<?php

require_once 'encryptDecryptData.php';
/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set("Asia/Kolkata");

require 'phpmailer/PHPMailerAutoload.php';

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
$mail->Password = "";//write password for that email address
//Set who the message is to be sent from
$mail->setFrom('your_email', 'FamilyIn');
//Set an alternative reply-to address
$mail->addReplyTo('your_email', 'FamilyIn');
//Set who the message is to be sent to
//$nameStr = $_COOKIE[$cookie_ufname] ." ". $_COOKIE[$cookie_ulname] ;
$nameStr = $tempFname ." ". $tempLname ;
$mail->addAddress($tempEmail, $nameStr);
//Set the subject line
$mail->Subject = 'Greetings from FamilyIn';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->isHTML(true);
//Replace the plain text body with one created manually
$verificationUniqueLink = "http://localhost/short%20web/Pages/verifiedEmailAddress.php?i=".encyptData($tempId);

$mail->Body = '<b>Thanks '. $nameStr .' For your Sign Up</b><br><br>Verification Link : '.$verificationUniqueLink;

if (!$mail->send()) {
    //echo "Mailer Error: " . $mail->ErrorInfo;
    header("Location: pages/errorPage.php");
} else {
    $_SESSION['accountStatus'] = "Not Verified";
    $locationLink = 'Location: pages/signUpSuccess.php?f='.encyptData($tempFname).'&e='.encyptData($tempEmail) ;
    header($locationLink);
}
