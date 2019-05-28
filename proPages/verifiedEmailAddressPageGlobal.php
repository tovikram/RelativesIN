<?php
date_default_timezone_set("Asia/Kolkata");

$errorMsg = "";
$logolink = "../index.php";
$logoUrl = "../img/familyinbrand.png";
$customCssUrl ="../css/custom.css";
$bootstrapMinCssUrl = "../css/bootstrap.min.css";
$feviconLink = "../favicon.ico";

function decryptData($hashVar){
    $hashVar = str_replace(' ', '+', $hashVar);
    $plain = openssl_decrypt($hashVar, "AES-128-ECB", "FamilyIn");
    return substr($plain, 0,strlen($plain)-8);
}

?>