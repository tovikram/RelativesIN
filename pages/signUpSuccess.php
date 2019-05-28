<?php
    
    ob_start();
    session_start(); // staring session on this page
    date_default_timezone_set("Asia/Kolkata");
    require_once '../proPages/signUpSuccessPageGlobal.php';
    require_once '../proPages/encryptDecryptData.php';
    
    $userName = decryptData($_GET['f']);
    $userEmail = decryptData($_GET['e']);
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

        <a href="<?php echo $logolink; ?>"><img id="navbarLogo" class="navbar-brand" src="<?php echo $logoUrl; ?>"></a>

    </nav>
    </div>
<!--- Navbar closed -->
    
<!--  body code goes here -->
        
<div class="container">
                <br><br><br><br><br>
    <div id="editProileDiv">
        <div class="row">
            <div class="col-lg-12">
                <center>
                    <br>
                <span id="successGreetingMsg1">Thanks for your registration, <?php echo $userName; ?> !
                    <br></span>
                    <span id="successGreetingMsg2">
                    Verify your E-mail address (i.e <?php echo $userEmail; ?>) for using our features.</span>
                    <br><br>
                </center>
            </div>
        </div>
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