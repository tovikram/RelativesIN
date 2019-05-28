<?php
date_default_timezone_set("Asia/Kolkata");

require_once "encryptDecryptData.php";

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
$updateProfileNameLink = "updateProfileDetails.php?field=".encyptData("name");
$updateProfileGenderLink = "updateProfileDetails.php?field=".encyptData("gender");
$updateProfileContactLink = "updateProfileDetails.php?field=".encyptData("contact")."&o=".encyptData("false");
$updateProfilePasswordLink = "updateProfileDetails.php?field=".encyptData("password");
$updateProfileDob = "updateProfileDetails.php?field=".encyptData("dob");
$conn = "";
$isImageSelected = FALSE;

$isPictureUploaded = 0;
?>