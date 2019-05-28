<?php
ob_start();
session_start(); // starting session on this page 

	// it will never let you open Forgot pass page page if session is set
	if ( isset($_SESSION['user'])!="" ) {
		header("Location: ../pages/home.php");
		exit;
	}

include '../proPages/setNewPasswordPageGlobal.php';
require_once '../proPages/encryptDecryptData.php';
require_once '../proPages/connectDatabase.php';
date_default_timezone_set("Asia/Kolkata");

$errorMsg = '';
$isPasswordChanged = FALSE;

if(isset($_POST['newPassSubmit'])){
    $newPass = $_POST['newPass'];
    $newRePass = $_POST['newRePass'];
    try {
        if (!decryptData($_POST['d']) || $_POST['d'] ==NULL || $_POST['d']==" ") {
            throw new Exception("");
        }else{
            $idEncrypted = $_POST['d'];
        }
    } catch (Exception $e) {
        header('location: ../index.php');
    } 
    if (strlen($newPass) <8 || $newPass == NULL) {
        $errorMsg = "Password should be minimum 8 charachters long ";
        $d = $idEncrypted;
    }elseif($newPass != $newRePass){
        $errorMsg = "Password not matched";
        $d = $idEncrypted;
    }else{
        $isPasswordChanged = changePassword($idEncrypted,md5($newPass),$conn);
    }
}else {
    try {
        if(!decryptData($_GET['d']) || !decryptData($_GET['t'])){
            throw new Exception("");
        }else{
            $currentDateTime = new DateTime((string)date("Y-m-d H:i:s"));
            $linkTime = (string)decryptData($_GET['t']);
            $differenceTime = $currentDateTime->diff(new DateTime($linkTime));

            if($differenceTime->y ==0 && $differenceTime->m==0 && $differenceTime->d==0 && $differenceTime->h<=2 && $differenceTime->i <61){
                $d = $_GET['d'];
            }else{
                header('location: ../resetPassword.php');
            }
        }
    } catch (Exception $e) {
        header('location: ../index.php');
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
    <!-- navigation bar --><div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"> 
        <!-- logo on nav bar image or text -->

        <a href=""><img id="navbarLogo" class="navbar-brand" src="<?php echo $logoUrl; ?>"></a>

        <ul class="navbar-nav mr-auto">
           <!-- nav tabs code goes here -->

        </ul>
        <a href="<?php echo $logolink; ?>"><button class="forgotPageRedirectButton">Sign in</button></a>
        <span style="padding-left:10px;padding-right:10px;"></span>
        <a href="<?php echo $logolink; ?>"><button class="forgotPageRedirectButton">Join Now</button></a>
        <span style="padding-left:10px;padding-right:10px;"></span>
    </nav>
    </div>
<!--- Navbar closed -->
    
<!--  body code goes here -->
        
<div class="container">
    <div class="row">
        <div class="col-lg-12"><br><br><br><br><br></div>
    </div>
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="forgotPassBody">
                <?php if($isPasswordChanged){  ?>
                    <div class="row">
                        <div class="col-lg-12"><span id="forgotPassDivHeading"> Password Changed Successfully !</span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><span class="passwordChangedSuccessInfoLable"> Now you can login using new password</span></div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-12"><input type="button" id="redirectLoginButton" name="redirectLoginButton" value="Try Login Now" onclick="location.replace('../index.php');"></div>
                    </div><br>
                <?php }else{ ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="row">
                        <div class="col-lg-12"><span id="forgotPassDivHeading"> Account Verified! Set New Password</span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><span id="forgotPassErrorMsg"><?php echo $errorMsg; ?></span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><span class="newPassLable"> New Password </span></div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-12"><input type="password" id="newPass" name="newPass" required>
                        <input type="radio" name='d' value="<?php echo $d; ?>" required checked hidden></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12"><span class="newRePassLable"> Confirm New Password </span></div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-12"><input type="password" id="newRePass" name="newRePass" required></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12"><input type="submit" id="newPassSubmit" name="newPassSubmit" value="Change Password">&nbsp
                        <input type="button" id="newPassCancel" value="Cancel" name="cancelButton" onclick="location.replace('../index.php');"></div>
                    </div>
                    <br>
                </form>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>
</div>

    
    
    <!-- Javascript files should be link at the bottom of the page -->
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>

    <!-- Leatest Compiled and minified js file -->
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>

    <script type="text/javascript" src="../js/custom.js"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
</body>
    
</html>