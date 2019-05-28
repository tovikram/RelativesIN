<?php
date_default_timezone_set("Asia/Kolkata");

$errorMsg = "";
$logolink = "../index.php";
$logoUrl = "../img/familyinbrand.png";
$customCssUrl ="../css/custom.css";
$bootstrapMinCssUrl = "../css/bootstrap.min.css";
$feviconLink = "../favicon.ico";
$homePageUrl = "home.php";
$relativesPageUrl = "relatives.php";
$logOutPageUrl = "../proPages/logout.php";
$editPageUrl= "editProfile.php";
$myFamilyUrl= "myFamily.php";
$occasionsPageUrl = "occasions.php";
$greenDotImageUrl = "../img/green-dot.png";
$closeIconUrl = "../img/close_black_2048x2048.png";
$jqueryUILink= "../css/jquery-ui.css";

$outputMsg="";
if(!isset($_COOKIE["addMemberOutputMsg"])){
setcookie("addMemberOutputMsg", $outputMsg, time() + (86400 * 1), '/'); // 86400 = 1 day
}else{
    if($_COOKIE["addMemberOutputMsg"] != ""){
        $outputMsg=$_COOKIE["addMemberOutputMsg"];
    }
}

?>