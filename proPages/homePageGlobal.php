<?php
date_default_timezone_set("Asia/Kolkata");

$errorMsg = "";
$logolink = "../index.php";
$logoUrl = "../img/familyinbrand.png";
$customCssUrl ="../css/custom.css";
$bootstrapMinCssUrl = "../css/bootstrap.min.css";
$feviconLink = "../favicon.ico";
$closeIconUrl = "../img/close_black_2048x2048.png";
$homePageUrl = "home.php";
$relativesPageUrl = "relatives.php";
$logOutPageUrl = "../proPages/logout.php";
$editPageUrl= "editProfile.php";
$myFamilyUrl= "myFamily.php";
$occasionsPageUrl = "occasions.php";

function insertPostDetails($conn,$postContent,$postImage,$id){
    if($conn->query("INSERT INTO `post_details`(`member_id`, `post_date_time`, `post_msg`, `post_img`) VALUES ($id,now(),'$postContent','$postImage')")){
        return true;
    }else{
        return false;
    }
}

?>