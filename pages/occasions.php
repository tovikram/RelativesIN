<?php

date_default_timezone_set("Asia/Kolkata");
ob_start();
session_start(); // staring session on this page

//kChecking is there any session is avilable or not 
if ( isset($_SESSION['user'])=="" ) {
		header("Location: ../index.php");
		exit;
	}

require_once '../proPages/occasionsPageGlobal.php';
// connecting to server database via calling the connection page
require_once '../proPages/connectDatabase.php';
require_once '../proPages/getUserData.php';
require_once '../proPages/encryptDecryptData.php';
require_once '../proPages/occasionsFunctionsPage.php';

if(isset($_POST['getThisCalendar'])){
  $mon = $_POST['mon'];
  $yea = $_POST['yea'];
  $dateStr = $yea."-".$mon."-10";
  header('location: occasions.php?d='.encyptData($dateStr));
}

try{
  if(!decryptData($_GET["d"])){
      throw new Exception("");
  }else{
      $date = decryptData($_GET["d"]);
  }
}catch(Exception $e){
  header('location: occasions.php?d='.encyptData(date('Y-m-d')));
}

//date('Y-m', strtotime(date('Y-m')." -1 month"))."-10"
$calendarArray = getCurrentMonthDetails('getMonthDates',$date);
$calendarCellClassArray = getCurrentMonthDetails('getClassNames',$date);

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
          <li class="nav-item active">
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
    </div>
<!--- Navbar closed -->
    
<!--  body code goes here -->

<br><br><br><br><br>

<div>
<a href="<?php echo "occasions.php?d='".encyptData(getLinkDate($date,"Previous")); ?>" style="text-decoration:none;">
  <div class="previousMonthDiv"><span><center> <?php echo getMonthYearString($date,"Previous");  ?></center></span></div>
</a>
</div>
<br>
<table class="currentCalendarTable" cellspacing="10">
    <tr>
        <td colspan=7><div class="calendarMonthNameDiv"><span><center><?php echo getMonthYearString($date,"Current");  ?></center></span></div></td>
    </tr>

    <tr>
    <td width="14%"><div class="calendarDayNameDiv sunday"><span><center>Sunday</center></span></div></td>
    <td width="14%"><div class="calendarDayNameDiv monday"><span><center>Monday</center></span></div></td>
    <td width="14%"><div class="calendarDayNameDiv tuesday"><span><center>Tuesday</center></span></div></td>
    <td width="14%"><div class="calendarDayNameDiv wednesday"><span><center>Wednesday</center></span></div></td>
    <td width="14%"><div class="calendarDayNameDiv thursday"><span><center>Thursday</center></span></div></td>
    <td width="14%"><div class="calendarDayNameDiv friday"><span><center>Friday</center></span></div></td>
    <td width="14%"><div class="calendarDayNameDiv saturday"><span><center>Saturday</center></span></div></td>
    </tr>
<?php
   $rowNumber = $calendarArray[0];
   $arrayIndex = 1;
   for($i=1;$i<=$rowNumber;$i++){
     for($j=1;$j<=7;$j++){
        if($j == 1){
          echo "<tr>";
        }
        if($calendarCellClassArray[$arrayIndex]=='A'){
          $divClassName =  'calendarDayActiveDiv';
          $spanClassName = 'calendarActiveDayLable';
          $eventDivclassName = 'eventActiveDivclass';
          $fulldate = getFullDateString($date,$calendarArray[$arrayIndex],"Current");
        }elseif ($calendarCellClassArray[$arrayIndex]=='NA') {
          $divClassName =  'calendarDayNonActiveDiv';
          $spanClassName = 'calendarNonActiveDayLable';
          $eventDivclassName = 'eventNonActiveDivclass';
          if($arrayIndex > 27){
            $fulldate = getFullDateString($date,$calendarArray[$arrayIndex],"Next");
          }else {
            $fulldate = getFullDateString($date,$calendarArray[$arrayIndex],"Previous");
          }
        }elseif ($calendarCellClassArray[$arrayIndex]=='TODAY') {
          $divClassName =  'calendarTodayDiv';
          $spanClassName = 'calendarActiveDayLable';
          $eventDivclassName = 'eventActiveDivclass';
          $fulldate = getFullDateString($date,$calendarArray[$arrayIndex],"Current");
        }else{
          $divClassName =  'noClass';
          $spanClassName = 'noClass';
          $eventDivclassName = 'noClass';
        }
        echo "<td width='14%'><div class='".$divClassName."'><span class='".$spanClassName."'>".$calendarArray[$arrayIndex]."</span>";
        if(getEventName($conn,$fulldate)!=NULL){
          echo "<br><div class='".$eventDivclassName."'><span>".substr(getEventName($conn,$fulldate),0,9).'...'."</span></div>";
        }
        echo "</div></td>";
        $arrayIndex++;
      } 
      echo "</tr>";
    }

?>

</table>

<br>
<div>
<a href="<?php echo "occasions.php?d='".encyptData(getLinkDate($date,"Next")); ?>" style="text-decoration:none;">
  <div class="nextMonthDiv"><span><center><?php echo getMonthYearString($date,"Next");  ?></center></span></div>
</a>
</div>

<br>

  <!-- Javascript files should be link at the bottom of the page -->
  <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>

<!-- Leatest Compiled and minified js file -->
<script type="text/javascript" src="../js/bootstrap.min.js"></script>

<script type="text/javascript" src="../js/custom.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.js"></script>
</body>

</html>