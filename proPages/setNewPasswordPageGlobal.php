<?php 

$errorMsg = "";
$logolink = "../index.php";
$logoUrl = "../img/familyinbrand.png";
$customCssUrl ="../css/custom.css";
$bootstrapMinCssUrl = "../css/bootstrap.min.css";
$feviconLink = "../favicon.ico";

date_default_timezone_set("Asia/Kolkata");

function changePassword($idEncrypted,$newPass,$conn){
    $id = decryptData($idEncrypted);
    $query = "UPDATE signup_family_in SET familyinPassword='".$newPass."' WHERE familyinID=".$id;
    if ($conn->query($query)){
        return TRUE;
    }else{
        return FALSE;
    }
}

?>