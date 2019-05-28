<?php
ob_start();
session_start(); // starting session on this page 
date_default_timezone_set("Asia/Kolkata");
	// it will never let you open Forgot pass page page if session is set
	if ( isset($_SESSION['user'])!="" ) {
		header("Location: ../pages/home.php");
		exit;
    }
    

require_once '../proPages/resetPasswordPageGlobal.php';
require_once '../proPages/encryptDecryptData.php';
require_once '../proPages/connectDatabase.php';

$errorMsg="";
$screenNumber = "1";
$methodDetail = '';

if(isset($_POST['verifyOTPSubmit'])){
    $otp = $_POST['otpTextBox'];
    $methodDetailsRadioOtpVerify = $_POST['methodDetailsRadioOtpVerify'];
    verifyOTP($otp,$methodDetailsRadioOtpVerify,$conn);
}
elseif(isset($_POST['getCodeSubmit'])){
    $methodValue= $_POST['getCodeMethod'];
    if($methodValue == NULL){
        header("Refresh:0");
    }else{
        sendCodeforForgotPass($methodValue,$conn);  
    }
}
elseif(isset($_POST['forgotPassSubmit'])){
    $mailToSearch = trim($_POST['forgotPassEmailBox']);
    if($mailToSearch == null || $mailToSearch == ""){
        $errorMsg = "please write your email";
    }else{
        $isMemberFound= getDetailsOfLostMember($mailToSearch,$conn);
        if($isMemberFound == TRUE){
            $errorMsg = $GLOBALS['nameOfMember']." found with ".$GLOBALS['contactOfMember'];
            $screenNumber = 2;
        }else{
            $errorMsg = "This email is not registered with us";
        }
    }

}else{
    
    try{
        if(!decryptData($_GET["em"]) || !decryptData($_GET["sn"])){
            throw new Exception("");
        }else{
            if(decryptData($_GET["em"]) == "1"){
                $errorMsg = "";
                $screenNumber = decryptData($_GET["sn"]);
            }else{
                $errorMsg = decryptData($_GET["em"]);
                $screenNumber = decryptData($_GET["sn"]);
            }
            if($screenNumber == '3'){
                if(!decryptData(substr($_GET["md"],1))){
                    throw new Exception("");  
                }else{
                    $methodDetail = substr($_GET["md"],0,1).''.decryptData(substr($_GET["md"],1));
                    $methodDetailEncrypted = $_GET['md'];
                }
            }
        }
    }catch(Exception $e){
        header('location: resetPassword.php?em='.encyptData("1").'&sn='.encyptData("1"));
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> <!-- fixed-top  -->
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
        <?php 
            switch($screenNumber){
                case '1':
        ?>
                <div class="forgotPassBody">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="row">
                            <div class="col-lg-12"><span id="forgotPassDivHeading"> Let's Search Your Account</span></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><span id="forgotPassErrorMsg"><?php echo $errorMsg; ?></span></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><span id="forgotPassEmailLable"> Please enter your email</span></div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12"><input type="email" id="forgotPassEmailBox" name="forgotPassEmailBox"></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12"><input type="submit" id="forgotPassSubmit" name="forgotPassSubmit" value="Find">&nbsp
                            <input type="button" id="forgotPassCancel" value="Cancel" name="cancelButton" onclick="location.replace('../index.php');"></div>
                        </div>
                        <br>
                    </form>
                </div>
        <?php
                    break;
                case '2':
        ?>
                    <div class="forgotPassBody">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="row">
                            <div class="col-lg-12"><span id="forgotPassDivHeading"> Reset Your Password</span></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><div id="chooseMethodLable"><span ><?php echo $GLOBALS['nameOfMember']; ?> ! How do you want to receive the code to reset your password?</span></div></div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12"><input type="radio" name="getCodeMethod" class="chooseMethodRadio" value="<?php echo '1'.encyptData($GLOBALS['emailOfMember'].''.$GLOBALS['memberID'].'#'.strlen($GLOBALS['memberID'])); ?>" required><span class="methodNameLable">Send code via email</span>
                            <br><span class="getCodeEmailLable">email: <?php echo $GLOBALS['emailOfMember']; ?></span></div>
                        </div>
                        <br>
                        <?php
                        if($GLOBALS['contactOfMember'] != null){
                        ?>
                        <div class="row">
                            <div class="col-lg-12"><input type="radio" name="getCodeMethod" class="chooseMethodRadio" value="<?php echo '2'.encyptData($GLOBALS['contactOfMember'].''.$GLOBALS['memberID'].'#'.strlen($GLOBALS['memberID'])); ?>"><span class="methodNameLable">Get code on phone</span>
                            <br><span class="getCodePhoneLable">phone: <?php echo "+91 xxxxxxx".substr($GLOBALS['contactOfMember'],7,3); ?></span></div>
                        </div>
                        <br>
                        <?php } ?>
                        <div class="row">
                            <div class="col-lg-12"><input type="submit" id="getCodeSubmit" name="getCodeSubmit" value="Get Code">&nbsp
                            <input type="button" id="forgotPassCancel" value="Not <?php echo $GLOBALS['nameOfMember'].' ?'; ?>" name="cancelButton" onclick="location.replace('../pages/resetPassword.php');"></div>
                        </div>
                        <br>
                    </form>
                </div>
        <?php
                    break;
                case '3':
                ?>
                    <div class="forgotPassBody">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="row">
                            <div class="col-lg-12"><span id="forgotPassDivHeading"> Verify your account !</span></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><div id="chooseMethodLable"><span >OTP sent Successfully on <?php if(getMethodType($methodDetail) =='1') { echo 'email '.substr(getMethodType($methodDetail),1);}elseif(getMethodType($methodDetail) =='2'){echo '+91 xxxxxxx'.substr($methodDetail,8,3).' mobile number !';}else{echo '***Something went wrong***';} ?></span></div></div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12"><span class="enterOTPLable"> Enter OTP</span>
                                                    <input type="radio" name="methodDetailsRadioOtpVerify" value="<?php echo $methodDetailEncrypted; ?>" required checked hidden>
                                                    <input type="text" name="otpTextBox" class="otpTextBox" required></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12"><input type="submit" id="verifyOTPSubmit" name="verifyOTPSubmit" value="Verify Code">&nbsp
                            <input type="button" id="otpVerifyCancel" value="Cancel" name="cancelButton" onclick="location.replace('../pages/resetPassword.php');"></div>
                        </div>
                        <br>
                    </form>
                </div>
                <?php
                    break;
                default:
                    break;
            }
        ?>
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