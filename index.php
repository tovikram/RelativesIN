<?php
ob_start();
session_start(); // starting session on this page 
date_default_timezone_set("Asia/Kolkata");
	// it will never let you open index(login) page if session is set
	if ( isset($_SESSION['user'])!="" ) {
		header("Location: pages/home.php");
		exit;
	}

require_once 'proPages/indexPageGlobal.php';
// connecting the web page to server database
require_once 'proPages/connectDatabase.php'; // executing the provided page

// checking if login form's submit button is clicked or not
if( isset($_POST['loginSubmit']) ){

    $email=$_POST['InputLoginEmail']; // fetching email field data from login form 
    $loginPassword=$_POST['InputLoginPassword']; // fetching password field data
        
    require_once 'proPages/loginAuthentication.php';
}

// for sign up the php code goes here 
// checking if sing up form's submit button is clicked or not
if( isset($_POST['signupButton']) ){
// fetching all field of data from sign up form
$firstName=trim($_POST['Inputfname']);
$lastName=trim($_POST['Inputlname']);
$email=trim($_POST['InputEmail']);
$password1=trim($_POST['InputPassword1']);
$password2=trim($_POST['InputPassword2']);
if(!(empty($firstName) || empty($lastName) || empty($email) || empty($password1) || empty($password2))){
    if($password1 == $password2){
        if(strlen($password1)>=8){
            $password1 = md5($password1);
            require_once 'proPages/signUpProcess.php';
        }else{
            echo "<script>alert('Passwords length must be greater than 7 !');</script>";
        }
    }else{
        echo "<script>alert('Passwords not matched !');</script>";
    }
}else{
    echo "<script>alert('We cannot proccess with any blank field !');</script>";
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
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

</head>
<body class="bgbody"> <!-- creating page body with background image -->
<!-- navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"> 
        <!-- logo on nav bar image or text -->

      <a href="<?php echo $logolink; ?>"><img id="navbarLogo" class="navbar-brand" src="<?php echo $logoUrl; ?>" ></a>
      <ul class="navbar-nav mr-auto">
           <!-- nav tabs code goes here -->

      </ul> 
      <span><h6 class="errorMsg"><?php echo $errorMsg ; ?></h6></span>
      <!-- login form in nav bar -->
          <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input class="form-control" type="email" name="InputLoginEmail" placeholder="Email" required>
            <span style="padding-left:10px;padding-right:10px;"></span> <!-- for spacing -->
            <input class="form-control" type="password" name="InputLoginPassword" placeholder="Password" required>
            <span style="padding-left:10px;padding-right:10px;"></span>
            <button style="margin-right:10px;" class="btn btn-success " type="submit" name="loginSubmit">Login</button>
            <a href="<?php echo $forgotPasswordPageLink; ?>"> <span class="frogotPassText">Forgot Password?</span></a>
          </form>

    </nav>

<!--- Navbar closed -->
    
    <!-- Body Page Content -->     
    <div>   
        <div class="container-fluid" > 
            <div class="row">
                <div class="col-md-6 col-sm-4 col-lg-4 col-xs-12">
                    <div><br><br><br><br></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-4 col-lg-4 col-xs-12">
                    <div></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-4 col-lg-4"></div> <!-- for aligning sign up form in center -->
                <!-- sign up form column -->
                <div class="col-md-6 col-sm-4 col-lg-4 col-xs-12">   
                <!-- sign up form -->
                <!-- echo htmlspecialchars($_SERVER['PHP_SELF']); -->
                   <form id="myForm" class="form-container" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div style="border-bottom:1px solid;" class="form-group">
                            <span class="signup-header"><h3><b>Get Connected with Your loving family</b></h3>
                                <h5><br>Create New Account</h5>
                            </span>
                        </div>
                        <div class="form-group"> 
                            <input type="text" class="form-control" id="Inputfname" name="Inputfname" placeholder="First Name" onkeyup="firstName()" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="Inputlname" name="Inputlname" placeholder="Last Name" onkeyup="lastName()" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="InputEmail" name="InputEmail" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="InputPassword1" name="InputPassword1" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="InputPassword2" name="InputPassword2" placeholder="Confirm Password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" name="signupButton">Sign Up</button>
                        <span><h6 style="color:red;" id="signupError"></h6></span>
                    </form>
                </div>    
                <div class="col-md-3 col-sm-4 col-lg-4 col-xs-12"></div> <!-- for aligning sign up form in center -->
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-4 col-lg-4 col-xs-12">
                    <div><br><br><br><br></div>
                </div>
            </div>
         </div>
     </div>

<!-- footer of page goes here -->
     <div class="footer-custom">
        <div class="container">
            <br>
            <div class="row">
                <div style="border-top:2px solid;" class="col-lg-12"></div>
            </div> 
            <div class="row">
                <!-- add linking pages --> 
                <br><br><br><br>
                <div style="border-bottom:2px solid;" class="col-lg-12"><br></div>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-1 signup-header">Copy right</div>
                <div class="col-lg-1"><a href="#"><span class="signup-header">User Agreement</span></a></div>
                <div class="col-lg-1"><a href="#"><span class="signup-header">Privacy Policy</span></a></div>
                <div class="col-lg-1"><a href="#"><span class="signup-header">Community Guidelines</span></a></div>
                <div class="col-lg-1"><a href="#"><span class="signup-header">Cookie Policy</span></a></div>
                <div class="col-lg-1"><a href="#"><span class="signup-header">Copyright Policy</span></a></div>
                <div class="col-lg-1"><a href="#"><span class="signup-header">Guest Controls</span></a></div>
                <div class="col-lg-1"><a href="#"><span class="signup-header">country</span></a></div>
                <div class="col-lg-2"></div>
            </div>
        </div>   
     </div>

    <!-- Javascript files should be link at the bottom of the page -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>

    <!-- Leatest Compiled and minified js file -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

    <script type="text/javascript" src="js/custom.js"></script>
    
</body>
</html>