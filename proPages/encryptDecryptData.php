<?php
date_default_timezone_set("Asia/Kolkata");

function encyptData($stringVar){
    $hashData = openssl_encrypt($stringVar."FamilyIn", "AES-128-ECB", "FamilyIn");
    return $hashData;
}

function decryptData($hashVar){
    $hashVar = str_replace(' ', '+', $hashVar);
    $plain = openssl_decrypt($hashVar, "AES-128-ECB", "FamilyIn");
    return substr($plain, 0,strlen($plain)-8);
}

?>