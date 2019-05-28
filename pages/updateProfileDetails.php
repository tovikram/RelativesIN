<?php

ob_start();
session_start(); // staring session on this page
date_default_timezone_set("Asia/Kolkata");
//kChecking is there any session is avilable or not 
if ( isset($_SESSION['user'])=="" ) {
    header("Location: ../index.php");
    exit;
}

require_once '../proPages/updateProfileDetailsPageGlobal.php';

// connecting to server database via calling the connection page
require_once '../proPages/connectDatabase.php';

require_once '../proPages/getUserData.php';

require_once '../proPages/encryptDecryptData.php';
if(!isset($_POST['updateProfileSubmitButton'])){
    try{
        if(!decryptData($_GET["field"])){
            throw new Exception("Return to editProfile Page");
        }else{
            $updateTypeValue= decryptData($_GET["field"]);
            if($updateTypeValue == "contact"){
                if(!decryptData($_GET['o'])){
                    throw new Exception("Return to editProfile Page");
                }else{
                    $isOTPSent = decryptData($_GET['o']);
                    if($isOTPSent == "true"){
                        if(!decryptData($_GET['nc'])){
                            throw new Exception("Return to editProfile Page");
                        }else{
                            $newQSContact = $_GET['nc'];
                        }
                    }
                }
            }
        }
    }catch(Exception $e){
        //header('location: ../pages/home.php');
        header("Location: ../pages/errorPage.php");
    }
}

if(isset($_POST['updateProfileSubmitButton'])){
    $updateType = $_POST["updateProfileDetailType"];
    
    switch($updateType){
        case "name":
            $newFirstName = $_POST['updateProfileFirstNameBox'];
            $newLastName = $_POST['updateProfileLastNameBox'];
            if(trim($newFirstName)!= "" && trim($newLastName)!= ""){
                $editTypeForSwitch = $updateType;
                require_once "../proPages/editProfileDetailsProcess.php";
            }else{
                $msg = 'We cannot proccess with blank fields !';
                header("location: ../pages/updateProfileDetails.php?field=".encyptData("name")."&er=".encyptData($msg));
            }
            break;
        
        case "gender":
            $newGender =$_POST['gender'];
            if(trim($newGender) != ''){
                $editTypeForSwitch = $updateType;
                require_once "../proPages/editProfileDetailsProcess.php";
            }else{
                $msg = 'Please select an option';
                header("location: ../pages/updateProfileDetails.php?field=".encyptData("gender")."&er=".encyptData($msg));
            }
            break;

        case "contact":
            $newContact = $_POST['updateProfileContactBox'];
            if(trim($newContact) != '' && strlen(trim($newContact))==10){
                require_once "../proPages/updateContactSendOTP.php";
            }else{
                $msg = 'Please give your valid phone number';
                header("location: ../pages/updateProfileDetails.php?field=".encyptData("contact")."&o=".encyptData("false")."&er=".encyptData($msg));
            }
            break;

        case "updateContactOtp":
            $newContact = decryptData($_POST['newContactBox']);
            $newContactOtp = $_POST['updateContactOtpBox'];
            if(trim($newContactOtp) != ''){
                require_once "../proPages/updateContactOtpVerification.php";
            }else{
                $msg = "Please Enter OTP";
                header('location: ../pages/updateProfileDetails.php?field='.encyptData('contact').'&o='.encyptData('true').'&nc='.encyptData($newContact).'&er='.encyptData($msg));
            }
            break;

        case "password":
            $oldPass =$_POST['updateProfileOldPassBox'];
            $newPass =$_POST['updateProfileNewPassBox'];
            $reNewPass =$_POST['updateProfileReNewPassBox'];
            if(trim($oldPass) != "" && trim($newPass) != "" && trim($reNewPass) != ""){
                $editTypeForSwitch = $updateType;
                require_once "../proPages/editProfileDetailsProcess.php";
                break;
            }else{
                //echo "<script>alert('We cannot proccess with blank fields !');</script>";
                $msg = 'We cannot proccess with blank fields !';
                header("location: ../pages/updateProfileDetails.php?field=".encyptData("password")."&er=".encyptData($msg));
                break;
            }

        case "dob":
            $newDOB =$_POST['updateDobDateBox'];
            if(trim($newDOB) != ''){
                $editTypeForSwitch = $updateType;
                require_once "../proPages/editProfileDetailsProcess.php";
            }else{
                $msg = 'Please Select your date of birth';
                header("location: ../pages/updateProfileDetails.php?field=".encyptData("dob")."&er=".encyptData($msg)); 
            }
            break;

        default:
            header("location: editProfile.php");
            break;
    }
}

if(isset($_GET['er'])){
    $errorMsg = decryptData($_GET['er']);
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
    
<body class="bodycolor"> <!-- creating page body with background image -->
    <!-- navigation bar --><div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
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
            <a class="nav-link" href="<?php echo $occasionsPageUrl.'?d='.encyptData(date('Y-m-d')); ?>">Occasions</a>
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
    
<!--- Navbar closed -->
    
<!--  body code goes here -->
<?php 

switch ($updateTypeValue) {
    case 'name':
    ?>
        <br>
        <div id="updateProfileDetailsDiv">
            <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div>
                    <a href="<?php echo $editPageUrl;?>"><img src="<?php echo $backArrowUrl; ?>" id="backButtonArrow"></a>
                    <span id="updateProfileDivHeading">Name</span>
                    <input type="text" name="updateProfileDetailType" value="<?php echo $updateTypeValue; ?>" hidden>
                    <hr>
                </div>    
                <div>
                <span id="forgotPassErrorMsg"><?php echo $errorMsg; ?></span><br>
                    <span id="firstLable">First</span><span id="lastLable">Last</span>
                </div>
                <div>
                    <input type="text" name="updateProfileFirstNameBox" id="updateProfileFirstNameBox" value="<?php echo $GLOBALS["result2"]["userFirstName"]; ?>">
                    <input type="text" name="updateProfileLastNameBox" id="updateProfileLastNameBox" value="<?php echo $GLOBALS["result2"]["userLastName"]; ?>">
                    <hr>
                </div>
                <div>
                    <input type="submit" id="updateProfileSubmitButton" value="Submit" name="updateProfileSubmitButton" onMouseover="updateProfileSubmitButtonOver();" onMouseout="updateProfileSubmitButtonOut();">
                </div>
            </form>
        </div>

    <?php
        break;

    case 'gender':
    ?>
        <br>
        <div id="updateProfileDetailsDiv">
            <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div>
                    <a href="<?php echo $editPageUrl;?>"><img src="<?php echo $backArrowUrl; ?>" id="backButtonArrow"></a>
                    <span id="updateProfileDivHeading">Gender</span>
                    <input type="text" name="updateProfileDetailType" value="<?php echo $updateTypeValue; ?>" hidden>
                    <hr>
                </div>    
                <div>
                <span id="forgotPassErrorMsg"><?php echo $errorMsg; ?></span><br>
                    <span id="genderLabel">Select Your Gender</span>
                </div>
                <br>
                <div>
                    <input type="radio" id="updateProfileMaleBox" name="gender" value="Male" <?php if($GLOBALS['rowMoreDetails']['userGender']=='Male'){echo "checked='checked' checked";} ?>>&nbsp &nbsp Male
                    <input type="radio" id="updateProfileFemaleBox" name="gender" value="Female" <?php if($GLOBALS['rowMoreDetails']['userGender']=='Female'){echo "checked='checked' checked";} ?>>&nbsp &nbsp Female
                    <hr>
                </div>
                <div>
                    <input type="submit" id="updateProfileSubmitButton" value="Submit" name="updateProfileSubmitButton" onMouseover="updateProfileSubmitButtonOver();" onMouseout="updateProfileSubmitButtonOut();">
                </div>
            </form>
        </div>

    <?php
        break;

    case 'contact':
    ?>
        <br>
        <div id="updateProfileDetailsDiv">
            <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div>
                    <a href="<?php echo $editPageUrl;?>"><img src="<?php echo $backArrowUrl; ?>" id="backButtonArrow"></a>
                    <span id="updateProfileDivHeading">Phone</span>
                    <input type="text" name="updateProfileDetailType" value="<?php if($isOTPSent == "true"){echo "updateContactOtp";}else{ echo $updateTypeValue;} ?>" hidden>
                    <hr>
                </div>    
                <div>
                <span id="forgotPassErrorMsg"><?php echo $errorMsg; ?></span><br>
                    <span id="contactLable">Contact Number</span>
                    <input type="text" id="updateProfileContactBox" value="<?php if($isOTPSent == "true"){ echo decryptData($newQSContact);}else{ echo $GLOBALS["result2"]["userContact"];} ?>" name="updateProfileContactBox"  <?php if($isOTPSent == "true"){echo "disabled";} ?>>
                    <hr>
                </div>
                <?php
                    if($isOTPSent == "true"){
                ?>
                <div>
                    <input type="text" name="newContactBox" value="<?php echo $_GET['nc']; ?>" hidden>
                    <span id="otpLable">OTP </span>
                    <input Type="text" id="updateContactOtpBox" name="updateContactOtpBox">
                    <hr>
                </div>
                <?php
                    }
                ?>
                <div>
                    <input type="submit" id="updateProfileSubmitButton" value="<?php if($isOTPSent == "true"){echo "Verify OTP";}else{echo "Send OTP";} ?>" name="updateProfileSubmitButton" onMouseover="updateProfileSubmitButtonOver();" onMouseout="updateProfileSubmitButtonOut();">
                </div>
            </form>
        </div>

    <?php
        break;
    
    case 'password':
    ?>
        <br>
        <div id="updateProfileDetailsDiv">
            <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div>
                    <a href="<?php echo $editPageUrl;?>"><img src="<?php echo $backArrowUrl; ?>" id="backButtonArrow"></a>
                    <span id="updateProfileDivHeading">Password</span>
                    <input type="text" name="updateProfileDetailType" value="<?php echo $updateTypeValue; ?>" hidden>
                    <hr>
                </div>    
                <div>
                 <span id="forgotPassErrorMsg"><?php echo $errorMsg; ?></span><br>
                    <table width=100%>
                        <tr>
                            <td><span id="oldPasswordLable">Old Password:</span></td>
                            <td><input type="password" id="updateProfileOldPassBox" name="updateProfileOldPassBox"></td>
                        </tr>
                        <tr>
                            <td><span id="newPasswordLable">New Password:</span></td>
                            <td><input type="password" id="updateProfileNewPassBox" name="updateProfileNewPassBox"></td>
                        </tr>
                        <tr>
                            <td><span id="reNewPasswordLable">Re-Type New Password:</span></td>
                            <td><input type="password" id="updateProfileReNewPassBox" name="updateProfileReNewPassBox"></td>
                        </tr>
                    </table>
                    <hr>
                </div>
                <div>
                    <input type="submit" id="updateProfileSubmitButton" value="Submit" name="updateProfileSubmitButton" onMouseover="updateProfileSubmitButtonOver();" onMouseout="updateProfileSubmitButtonOut();">
                </div>
            </form>
        </div>

    <?php
        break;

    case 'dob':
    ?>
        <br>
        <div id="updateProfileDetailsDiv">
            <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div>
                    <a href="<?php echo $editPageUrl;?>"><img src="<?php echo $backArrowUrl; ?>" id="backButtonArrow"></a>
                    <span id="updateProfileDivHeading">Birth Date</span>
                    <input type="text" name="updateProfileDetailType" value="<?php echo $updateTypeValue; ?>" hidden>
                    <hr>
                </div>    
                <div>
                <span id="forgotPassErrorMsg"><?php echo $errorMsg; ?></span><br>
                    <table width=100%>
                        <tr>
                            <td width=30%><span id="dobSelectLable">Select Date:</span></td>
                            <td>
                                <input type="date" id="updateDobDateBox" name="updateDobDateBox" value="<?php if($GLOBALS['rowMoreDetails']['userDOB']){echo $GLOBALS['rowMoreDetails']['userDOB'];}?>">
                            </td>
                        </tr>
                    </table>
                    <hr>
                </div>
                <div>
                    <input type="submit" id="updateProfileSubmitButton" value="Submit" name="updateProfileSubmitButton" onMouseover="updateProfileSubmitButtonOver();" onMouseout="updateProfileSubmitButtonOut();">
                </div>
            </form>
        </div>
    
    <?php
        break;
    default:
        # code...
        break;
}
?>
        
    
    <!-- Javascript files should be link at the bottom of the page -->
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>

    <!-- Leatest Compiled and minified js file -->
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>

    <script type="text/javascript" src="../js/custom.js"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
</body>
    
</html>