<?php
ob_start();
session_start(); // staring session on this page

date_default_timezone_set("Asia/Kolkata");
//kChecking is there any session is avilable or not 
if ( isset($_SESSION['user'])=="" ) {
		header("Location: ../index.php");
		exit;
	}

require_once '../proPages/homePageGlobal.php';

// connecting to server database via calling the connection page
require_once '../proPages/connectDatabase.php';
require_once '../proPages/encryptDecryptData.php';

require_once '../proPages/getUserData.php';

$membersList = $GLOBALS['rowMoreDetails']['membersID'];

//Calculating Total Family Members
$membersIdArray = array();
if($GLOBALS['rowMoreDetails']['membersID'] != NULL){
    $membersIdArray = preg_split("/-/", $GLOBALS['rowMoreDetails']['membersID']);
    $membersCount = count($membersIdArray);
}else{
    $membersCount = 0;
}

if(isset($_POST['postSubmit'])){
  if(trim($_POST['postContent'])!= null || trim($_POST['postContent'])!= '' ){
    $postContent = $_POST['postContent'];
    if(!empty($_FILES["postPicture"]["name"])){
        $postPicture = $_FILES["postPicture"]["name"] ;
        $tempPostPicPath = $_FILES["postPicture"]["tmp_name"];
        $postImage['name'] = str_replace('-', $id.'', date('Y-m-d-H-i-s').'') . ".jpg" ;
        $postImage['destPath'] = "../img/postimages/".$postImage['name'];
        if(move_uploaded_file($tempPostPicPath,$postImage['destPath'])){
          if(insertPostDetails($conn,$postContent,$postImage['name'],$id)){
            echo "<script>alert('Post craeted !');</script>";
          }else{
            echo "<script>alert('Post not craeted !');</script>";
          }
        }
    }else{
      $postImage['name'] = null;
      if(insertPostDetails($conn,$postContent,$postImage['name'],$id)){
        echo "<script>alert('Post craeted !');</script>";
      }else{
        echo "<script>alert('Post not craeted !');</script>";
      }
    }
  }else{
    //please write some text
    echo "<script>alert('write some text !');</script>";
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

        <a href="<?php echo $logolink; ?>"><img id="navbarLogo" class="navbar-brand" src="<?php echo $logoUrl; ?>"></a>

      <ul  id="navbarTabUl" class="navbar-nav mr-auto">
           <!-- nav tabs code goes here -->
          <li class="nav-item active">
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
    </div>
<!--- Navbar closed -->
    
<!--  body code goes here -->
        
<div class="container">
    <div class="row">
        <div class="col-lg-12"><br><br></div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-3">
            <div style="position: fixed;">
                <div class="card profileCard">
                    <br>
                    <center><img id="profileCardImg" src="../img/profilepictures/<?php echo $rowMoreDetails['profile_image']  ?>" alt="ProfilePicture" onclick="window.location.replace('editProfile.php');">
                    <br>
                    <div>
                        <h5><?php echo $name ." ". $result2["userLastName"]; ?></h5>
                        <h6 style="color:grey;" id="myStatusLable" onclick="showDialog();"><small><?php if($rowMoreDetails['myStatus'] == null){echo 'Add your current status';}else{echo ''.$rowMoreDetails['myStatus'];} ?></small></h6>
                    </div>
                    </center>
                </div>
                <div class="card profileCard" style="margin-top:7px;">
                    <center>
                    <div>
                        <h5 style="color:grey;"><b><small>Family Members : </small><span style="color:#0099ff;"><?php echo $membersCount; ?></span></b></h5> 
                    </div>
                    </center>
                </div>
                <div class="card profileCard" style="margin-top:7px;">
                    <center>
                    <div>
                        <h5 style="color:grey;"><b><small>Leatest Event : </small></b></h5> 
                        <span style="color:#0099ff;"><?php echo "Not Yet Created !"; ?></span>
                    </div>
                    </center>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="postBox" id="createPostBox">
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <h5 style="color: grey;margin-left: 5px;"> Create a Post </h5>
                <textarea name="postContent" class="postContent" cols="66" rows="3" placeholder="write your post content here.... " onFocus="highlightCreatePostBox();" onBlur="normalCreatePostBox();"></textarea>
                <br>
                <div class="upload-btn-wrapper">
                  <img src="../img/add-image.png" alt="uploadPostImage" style="width:50px;height:50px;padding:10px;">
                  <input type="file" name="postPicture" onChange="onProfileImageSelected()">
                  <span id="profileimageSelectedMessage"></span>
                </div>
                <input class="postSubmit" type="submit" value="Post" name="postSubmit">
                <br><br>
              </form>
            </div>
           <div id="postDivId">
           <br>

           </div>
        </div>
        <div class="col-lg-3" >
            <div class="card"  style="position: fixed;width: 230px;height: 450px;">
                <div style="width: 230px;height: 450px;border:dashed;border-width: 2px;border-color:blue;">
                   <center><h6 style="color: grey;">Advertise</h6></center>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<div id="blankCompareDiv"></div>
<input type="hidden" value="0" id="noOfPost">
<input type="hidden" value="<?php echo encyptData("0"); ?>" id="displayedPost">

<!--  Edit status dialog box start -->

<div id="dialogOverlay" style="display: none;"></div>
    <div id="dialogBoxContainer" style="display: none;">
      <div>
      <div class="container">
        <div class="row">
            <div class="col-lg-12">
              <img src="<?php echo $closeIconUrl ; ?>" width="20px" height="20px" align="right" onClick="dlgHide();">
              <br>
              <span style="color: #00004d;">Write your current status :</span>
              <br><br><input type="text" id="myStatusTextBox" name="addMemberEmailBox" placeholder="write here..."><br>
              <br>
              <input type="submit" name="addMemberSubmitButton"id="saveMyStatusButton" class="btn btn-danger" value="Save">
              &nbsp;&nbsp;&nbsp;<span id="responseMessageAboutStatus" style="color:red;"></span>
              <br><br>
            </div>
        </div>
      </div>
    </div>
    </div>
<!--  Edit status dialog box end -->
    
    <!-- Javascript files should be link at the bottom of the page -->
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>

    <!-- Leatest Compiled and minified js file -->
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>

    <script type="text/javascript" src="../js/custom.js"></script>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery-ui.js"></script>

    <script type="text/javascript">

    function loadPosts(flag){
      var displayedPost = document.getElementById("displayedPost").value;
      var membersId1 = "<?php if($membersList!= null || strlen(trim($membersList))!=0){echo encyptData($GLOBALS['rowMoreDetails']['membersID']).'';}else {echo encyptData('null').'';}  ?>";
      $.ajax({
        type:"GET",
        url:"../proPages/getPosts.php",
        data:{
          'offset':flag,
          'limit':3,
          'displayedPost':displayedPost,
          'membersList':membersId1
        },
        success:function(data){
            if(data != " " && data != 'no record found'){
              $('#postDivId').append(data);
              flag =parseInt(flag)+ 3;
              document.getElementById("noOfPost").value = flag+"";
            }else if(data == 'no record found'){
              //blank statement , stop loading post
              document.getElementById("noOfPost").value = flag+"";
            }else if(data == " "){
              flag =parseInt(flag)+ 3;
              loadPosts(flag);
            }else{
              //blank statement
            }
        }
      });
    }

    $(document).ready(function(){
      var flag =0;

      loadPosts(flag);

      $(window).scroll(function(){
        var diff = $(document).height()-$(window).height();
        flag = document.getElementById("noOfPost").value;
        if($(window).scrollTop() >= diff-2 ){
         loadPosts(flag);
        }
      });

      $("#saveMyStatusButton").click(function(){
        var textMessage=document.getElementById("myStatusTextBox").value;
        if(textMessage.trim()!=""){
            $.ajax({
              type:"GET",
              url:"../proPages/changeStatus.php",
              data:{
                'myId':"<?php echo encyptData($GLOBALS['id']); ?>",
                'myStatus':textMessage
              },
              success:function(data){
                  if(data == 'changed'){
                    document.location.replace('home.php');
                  }else{
                    document.getElementById("responseMessageAboutStatus").innerHTML = data;
                  }
              }
            });
        }else{
            document.getElementById("responseMessageAboutStatus").innerHTML = "Please write valid status !";
        }
      });

    });

    

    </script>

</body>
    
</html>