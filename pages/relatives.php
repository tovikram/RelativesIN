<?php
ob_start();
session_start(); // staring session on this page
date_default_timezone_set("Asia/Kolkata");
//kChecking is there any session is avilable or not 
if ( isset($_SESSION['user'])=="" ) {
		header("Location: ../index.php");
		exit;
	}

require_once '../proPages/relativesPageGlobal.php';

// connecting to server database via calling the connection page
require_once '../proPages/connectDatabase.php';
require_once '../proPages/encryptDecryptData.php';

require_once '../proPages/getUserData.php';

require_once '../proPages/fetchSuggestedMembers.php';

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

      <ul  id="navbarTabUl" class="navbar-nav mr-auto">
           <!-- nav tabs code goes here -->
          <li class="nav-item">
              <a class="nav-link" href="<?php echo $homePageUrl; ?>"><span class="glyphicon glyphicon-home"></span>  Home </a>
          </li>
          <li class="nav-item"><span style="padding-right:20px;"></span></li>
          <li class="nav-item active">
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
                <div class="col-xl-12"><br><br><br></div>
            </div>
            
            <div class="row">
                <div class="col-xl-9">
                  <strong style="color: red;">You May Know these Relatives :</strong>
                  <br>
                    <?php
                    $idCount = 0;
                    for ($j=0; $j < count($arrayFinalSuggestion); $j++) { 

                        if ($arrayFinalSuggestion[0] == 0) {
                          if (count($arrayFinalSuggestion) == 1) {

                        ?>

                        <div class="row">
                          <div class="col-xl-12">
                            <center><strong style="color:grey;">No Result found !</strong></center>
                          </div>
                        </div>

                        <?php  
                          break;
                        }
                        $j++; 
                        $idCount++;
                      }
                        if($idCount < count($arrayFinalSuggestion)){
                        ?>
                      <br>
                    <div class="row">
                         <?php  
                    $i = 1;
                    while ( $i <= 3) {
                      if($idCount >= count($arrayFinalSuggestion)){
                        break;
                      }

                        $tempId = $arrayFinalSuggestion[$idCount];
                        $QueryS = "SELECT * FROM signup_family_in WHERE familyinID = $tempId";
                        $resultQueryS=mysqli_query($conn,$QueryS,MYSQLI_USE_RESULT);
                        $rowQueryS = $resultQueryS->fetch_assoc();
                        $addMemberEmailId = $rowQueryS['userEmail'];
                        $resultQueryS->close();

                        $QueryM = "SELECT * from more_details where familyinID = $tempId";
                        $resultQueryM=mysqli_query($conn,$QueryM,MYSQLI_USE_RESULT);
                        $rowQueryM = $resultQueryM->fetch_assoc();
                        $imgName = $rowQueryM['profile_image'];
                        $onlineStatus = $rowQueryM['onlineStatus'];
                        $resultQueryM->close();
                        //working here
                        //$relationType = getRelationWithUser($conn,$tempId,$GLOBALS["id"]);

                        $idCount += 1;
                        $i += 1;
                       ?>
                        <div class="col-xl-4">
                            <div class="familyMemberListCard">
                              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                  <table>
                                    <tr>
                                        <td style="width:20%;padding: 7px;" rowspan="3"><img class="relativeImage" src="../img/profilepictures/<?php echo $imgName  ?>"></td>
                                        <td><center><span class="relativeName"><?php echo $rowQueryS['userFirstName'] . " " . $rowQueryS['userLastName'] ; ?></span><br>
                                            <div class="relationTypeLable"><span>name</span></div></center>
                                        </td>
                                        <td>
                                          <img src='../img/arrow-right.png' class="suggestedProfileMore">
                                        </td>
                                    </tr>
                                  </table>
                              </form>
                              </fieldset>
                            </div>
                        </div>

                    <?php
                      }
                    
                        ?>  
                    </div>
                    <?php 
                     }else{break;}
                    }
                    ?>
                </div>
                <div class="col-xl-3">
                    <div class="card"  style="position: fixed;width: 230px;height: 450px;">
                        <div style="width: 230px;height: 450px;border:dashed;border-width: 2px;border-color:blue;">
                           <center><h6 style="color: grey;">Advertise</h6></center>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-9" style="border-top:solid;border-top-color: blue;margin-top: 20px;">
                   <!-- blue line --> 
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
    