<?php

ob_start();
session_start(); // staring session on this page
date_default_timezone_set("Asia/Kolkata");
//kChecking is there any session is avilable or not 
if ( isset($_SESSION['user'])=="" ) {
		header("Location: ../index.php");
		exit;
	}

require_once '../proPages/editProfilePageGlobal.php';

// connecting to server database via calling the connection page
require_once '../proPages/connectDatabase.php';
require_once '../proPages/encryptDecryptData.php';

require_once '../proPages/getUserData.php';
$profileImageSelectedMsg="";
//checking if image upload submit button is clicked or not 
if( isset($_POST['imgUploadButton']) ){
    if(!empty($_FILES["profilePicture"]["name"])){
        $profilePicture = $_FILES["profilePicture"]["name"] ;
        $tempPathName = $_FILES["profilePicture"]["tmp_name"];
        
        require_once '../proPages/uploadProfileImgProcess.php';
    }else{
        $profileImageSelectedMsg = "Please Select an image !";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Family In</title>

	<!-- We link the CND css  files here -->
	<!-- Leatest compiled and minified css -->
	<link rel="stylesheet" type="text/css" href="<?php echo $bootstrapMinCssUrl; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $customCssUrl; ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $feviconLink; ?>" />
  
</head>
    
<body class="bodycolor"> <!-- creatin page body with background image -->
<!-- navigation bar -->
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"> 
            <!-- logo on nav bar image or text -->

            <a href="<?php echo $logolink; ?>"><img id="navbarLogo" class="navbar-brand" src="<?php echo $logoUrl; ?>"></a>

        <ul  id="navbarTabUl" class="navbar-nav mr-auto">
            <!-- nav tabs code goes here -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $homePageUrl; ?>"><span class="glyphicon glyphicon-home"></span>  Home </a>
            </li>
            <li class="nav-item"><span style="padding-right:20px;"></span></li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $relativesPageUrl; ?>">Relatives</a>
            </li>
            <li class="nav-item"><span style="padding-right:20px;"></span></li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $myFamilyUrl; ?>">My Family</a>
            </li>
            <li class="nav-item"><span style="padding-right:20px;"></span></li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $occasionsPageUrl.'?d='.encyptData(date('Y-m-d')); ?>"">Occasions</a>
            </li>
            <li class="nav-item"><span style="padding-right:20px;"></span></li>
            <li class="nav-item">
                <a class="nav-link" href="#">More..</a>
            </li>
        </ul>     	


            <span>
                <h6 id="userWelcomeText"> hello <?php echo $name ; ?> </h6>
            </span>

            <span class="dropdown">
                <a class="dropdown-toggle" href="index.php" id="navbarDropdown" role="button" data-toggle="dropdown">
                <img src="../img/profilepictures/<?php echo $rowMoreDetails['profile_image']  ?>" alt="Avatar" id="navbarAvtar"><span> Myself</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="<?php echo $editPageUrl; ?>">Edit Profile</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo $logOutPageUrl; ?>">Log out</a>
                </div>
            </span>
            <span style="padding-right:130px;"></span>
            
        </nav>
    </div>
<!--- Navbar closed -->
    
<!--  body code goes here -->
        
<div class="container">
    <div class="row">
        <div class="col-lg-12"><br><br><br><br><br>
            <center>
                <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                    <div class="upload-btn-wrapper">
                      <img src="../img/profilepictures/<?php echo $rowMoreDetails['profile_image']  ?>" alt="ProfilePicture" style="width:110px;height:110px;border-radius:50%;border:solid;border-color:lightgray;">
                      <img class="changePro" src="../img/edit.png" width="20px" height="20px">
                      <input type="file" name="profilePicture" onChange="onProfileImageSelected()">
                      <br><span id="profileimageSelectedMessage"><?php echo $profileImageSelectedMsg;  ?></span>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="imgUploadButton">Upload</button>
                </form>
            </center>
            <br><br>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div>
            <div id="progressBox">
                <div id="progressBar" style="width:<?php echo calculateProfilePercentage()."%" ?>;"><center><?php echo calculateProfilePercentage()." % Completed !"; ?></center></div>
            </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-lg-12"><br><center><span id="editProfileMainHeading">Personal Details</span>
                        <br>
                        <span>Your details, that help your relatives to get more info about you</span></center></div>
                </div>
            </div>
            <br>
            <div id="editProileDiv">
                <div class="row">
                    <div class="col-lg-12"><br><span id="editProfileDivHeading">Profile</span></div>
                </div>
                <a href="<?php echo $updateProfileNameLink; ?>" id="editProfileRowLink">
                <div class="row" id="editProfileDisplayRow1" onMouseover="highlightEditRow('1');" onMouseout="UnhighlightEditRow('1');">
                    <div class="col-lg-3">
                        <span id="editProfileHeadingName">Name</span>
                    </div>
                    <div class="col-lg-8">
                        <span id="editProfileHeadingValue"><?php echo $result2["userFirstName"]." ".$result2["userLastName"]; ?></span>
                    </div>
                    <div class="col-lg-1">
                        <img src="../img/arrow-right.png" id="editProfileArrow">
                    </div>
                </div>
                </a>
                <a href="<?php echo $updateProfileDob; ?>" id="editProfileRowLink">
                <div class="row" id="editProfileDisplayRow2" onMouseover="highlightEditRow('2');" onMouseout="UnhighlightEditRow('2');">
                    <div class="col-lg-3">
                        <span id="editProfileHeadingName">Birthday</span>
                    </div>
                    <div class="col-lg-8">
                        <span id="editProfileHeadingValue"><?php echo  $rowMoreDetails["userDOB"]; ?></span>
                    </div>
                    <div class="col-lg-1">
                        <img src="../img/arrow-right.png" id="editProfileArrow">
                    </div>
                </div>
                </a>
                <a href="<?php echo $updateProfileGenderLink; ?>" id="editProfileRowLink">
                <div class="row" id="editProfileDisplayRow3" onMouseover="highlightEditRow('3');" onMouseout="UnhighlightEditRow('3');">
                    <div class="col-lg-3">
                        <span id="editProfileHeadingName">Gender</span>
                    </div>
                    <div class="col-lg-8"> 
                        <span id="editProfileHeadingValue"><?php echo $rowMoreDetails["userGender"]; ?></span>
                    </div>
                    <div class="col-lg-1">
                        <img src="../img/arrow-right.png" id="editProfileArrow">
                    </div>
                </div>
                </a>
                <a href="<?php echo $updateProfilePasswordLink; ?>" id="editProfileRowLink">
                <div class="row" id="editProfileDisplayRow4" onMouseover="highlightEditRow('4');" onMouseout="UnhighlightEditRow('4');">
                    <div class="col-lg-3">
                        <span id="editProfileHeadingName">Password</span>
                    </div>
                    <div class="col-lg-8"> 
                        <span id="editProfileHeadingValue"><b><?php echo "* * * * * * * *"; ?></b></span>
                    </div>
                    <div class="col-lg-1">
                        <img src="../img/arrow-right.png" id="editProfileArrow">
                    </div>
                </div>
                </a>
            </div>
            
            <br>
            <div id="editProileDiv">
                <div class="row">
                    <div class="col-lg-12"><br><span id="editProfileDivHeading">Contact info</span></div>
                </div>
                <a href="#" id="editProfileRowLink">
                <div class="row" id="editProfileDisplayRow5" onMouseover="highlightEditRow('5');" onMouseout="UnhighlightEditRow('5');">
                    <div class="col-lg-3">
                        <span id="editProfileHeadingName">Email</span>
                    </div>
                    <div class="col-lg-8">
                        <span id="editProfileHeadingValue"><?php echo $result2["userEmail"]; ?></span>
                    </div>
                    <div class="col-lg-1">
                        <img src="../img/arrow-right.png" id="editProfileArrow">
                    </div>
                </div>
                </a>
                <a href="<?php echo $updateProfileContactLink; ?>" id="editProfileRowLink">
                <div class="row" id="editProfileDisplayRow6" onMouseover="highlightEditRow('6');" onMouseout="UnhighlightEditRow('6');">
                    <div class="col-lg-3">
                        <span id="editProfileHeadingName">Phone</span>
                    </div>
                    <div class="col-lg-8">
                        <span id="editProfileHeadingValue"><?php echo $result2["userContact"]; ?></span>
                    </div>
                    <div class="col-lg-1">
                        <img src="../img/arrow-right.png" id="editProfileArrow">
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>

    <div class="row">
        <div class="col-lg-12"><br><br></div>
    </div>
</div>

    
    
    <!-- Javascript files should be link at the bottom of the page -->
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>

    <!-- Leatest Compiled and minified js file -->
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>

    <script type="text/javascript" src="../js/custom.js"></script>
</body>
    
</html>