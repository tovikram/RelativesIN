<?php
    
    ob_start();
    session_start(); // staring session on this page
    date_default_timezone_set("Asia/Kolkata");
    require_once "../proPages/connectDatabase.php";

    require_once '../proPages/verifiedEmailAddressPageGlobal.php';
    
    $idStr = decryptData($_GET['i']);
    settype($idStr,'int');

    $verificationStatus = 0;

    require_once '../proPages/transferNonVerifiedData.php';

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
    <div class="row">
        <div class="col-lg-12"><br><br><br><br><br><br><br><br><br>
            <?php 
            
                if($verificationStatus ==1){
                ?> 
                <center>  
                    <div style="border:solid green;border-radius:10px;padding:30px;width:500px;"> 
                        <span style="color:green;font-weigth:bold;font-size:30px;">Your Account Verified Successfully</span>
                    </div>
                </center>
                <?php    
                }else{
                ?>
                    <center>  
                        <div style="border:solid red;border-radius:10px;padding:30px;width:500px;"> 
                            <span style="color:red;font-weigth:bold;font-size:30px;">Verification Failed</span>
                        </div>
                    </center>
                <?php
                }
            
            ?>
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