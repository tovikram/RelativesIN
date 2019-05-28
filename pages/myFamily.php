<?php

ob_start();
session_start(); // staring session on this page
date_default_timezone_set("Asia/Kolkata");
//kChecking is there any session is avilable or not 
if ( isset($_SESSION['user'])=="" ) {
		header("Location: ../index.php");
		exit;
	}

require_once '../proPages/myFamilyPageGlobal.php';

// connecting to server database via calling the connection page
require_once '../proPages/connectDatabase.php';
require_once '../proPages/encryptDecryptData.php';

require_once '../proPages/getUserData.php';

require_once '../proPages/getFamilyMembersDetails.php';

include '../proPages/relationIdentifier.php';

if( isset($_POST['addMemberSubmitButton']) ){
    $addMemberEmailId = $_POST['addMemberEmailBox'];
    $relationTypeSelected = $_POST['relationTypeSelectionList'];
    if(!isValidRelationType($conn,trim($relationTypeSelected))){
        $outputMsg = "Please Select Valid Relation Type";
    }else{
        //5$relationTypeSelected = reFormatRelationName($relationTypeSelected);
        require_once '../proPages/addMemberProcess.php';
    }
}

$sendMessage="";

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
    <link rel="stylesheet" href="<?php echo $jqueryUILink; ?>" />
    
</head>
    
<body class="bodycolor"> <!-- creatin page body with background image -->

    <!-- add member alert box strat -->
    <?php if($outputMsg == ""){$addMemberBoxDisplayType = "none";}else{$addMemberBoxDisplayType = "block";} ?>
    <div id="dialogOverlay" style="display: <?php echo $addMemberBoxDisplayType ; ?>;"></div>
    <div id="dialogBoxContainer" style="display: <?php echo $addMemberBoxDisplayType ; ?>;">
      <div>
      <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <img src="<?php echo $closeIconUrl ; ?>" width="20px" height="20px" align="right" onClick="dlgHide();">
                    <br>
                    <span style="color: #00004d;">Enter Your Family Member's Email Address to Add Into Your Account :</span>
                    <input type="email" name="addMemberEmailBox" class="form-control" <?php if($outputMsg === 'Please Select Relation Type'){echo "value='$addMemberEmailId'";} ?> placeholder="e.g : example@domain.com" required=""><br>
                    <span class="relationTypeSelectionLabel">Relation :</span>
                    <input type="text" name="relationTypeSelectionList" id="relationTypeSelectionList" size="30" class="relationTypeSelectionList" placeholder="e.g: Father">
                    <br>
                    <input type="submit" name="addMemberSubmitButton" class="btn btn-danger" value="Add">
                    &nbsp;&nbsp;&nbsp;<span style="color:red;"><?php echo $outputMsg ; ?></span>
                    <br><br>
                </form>
            </div>
        </div>
      </div>
    </div>
    </div>
    <!-- add member alert box end -->
    

<!-- navigation bar -->
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"> 
            <!-- logo on nav bar image or text -->

            <a href="<?php echo $logolink; ?>"><img id="navbarLogo" class="navbar-brand" src="<?php echo $logoUrl; ?>"></a>

        <ul  id="navbarTabUl" class="navbar-nav mr-auto">
            <!-- nav tabs code goes here -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $homePageUrl; ?>">  Home </a>
            </li>
            <li class="nav-item"><span style="padding-right:20px;"></span></li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $relativesPageUrl; ?>">Relatives</a>
            </li>
            <li class="nav-item"><span style="padding-right:20px;"></span></li>
            <li class="nav-item active">
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
                <img src="../img/profilepictures/<?php echo $rowMoreDetails['profile_image'];  ?>" alt="Avatar" id="navbarAvtar"><span> Myself</span>
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
        <div class="col-lg-12"><br><br><br><br>

            <?php 
            if(count($relationsNameArray) == 0){
            ?>

            <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <center><div><strong style="color:grey;">No Family Members Are added yet !</strong></div></center>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="addMemberDivWrap">
                                <center><button class="addMemberButton" onClick="showDialog();"><span class="addMemberLabel">Add Member</span></button></center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }else{
            ?>
            <div class="row">
            <?php
                //for loop execute one more time for add button display
                for($m=0;$m<=count($relationsNameArray);$m++){
                    if($m % 4 == 0){
                        echo "</div><br><div class='row'>";            
                    }
                    //displaying addmember button
                    if($m ==count($relationsNameArray) ){
                      echo  "<div class='col-lg-3'>
                            <div class='addMemberDivWrap'>
                                <center><button class='addMemberButton' onClick='showDialog();'><span class='addMemberLabel'>Add Member</span></button></center>
                            </div>
                        </div>";
                        break;
                    }
                    $memberFullName = $relativeFirstNameArray[$m]." ".$relativeLastNameArray[$m];
                    $memberImageUrl = '../img/profilepictures/'.$relativeProfileImageArray[$m];
                    $onlickFunction =  "showChatDialog('".$memberImageUrl."','". $memberFullName."','".encyptData($relativeIdArray[$m])."');";
            ?>

                <div class="col-lg-3 memberListCardPad">
                    <div class="familyMemberListCard" onClick="<?php echo $onlickFunction; ?>">
                        <div class="familyMemberListCardContent">
                            <table class="familyMemberCardTable">
                                <tr><td class="familyProfileHeader">
                                <span><?php if($relativeOnlineStatusArray[$m]==1){ echo "<img class='familyMemberCardGreenDotImg' src='$greenDotImageUrl' >"; } ?>  &nbsp<?php echo $relationsNameArray[$m]; ?></span><br>
                                </td></tr>
                                <tr><td class="familyProfileBody">
                                <center><img src="<?php echo $memberImageUrl; ?>" class="familyProfilePicture">
                                <br>
                                <span class="familyMemberNameLabel"><?php echo $memberFullName;?></span><br>
                                </center>
                                </td></tr>
                            </table>
                        </div>
                    </div>
                </div>

            <?php 
                }
            ?>

            </div>
            
            <?php
            } 
            ?>
        </div>
    </div>
</div>


    <!-- chat alert box strat -->
    <?php if($sendMessage == ""){$chatDisplayType = "none";}else{$chatDisplayType = "block";} ?>
    <div id="chatDialogOverlay" style="display: <?php echo $chatDisplayType ; ?>;"></div>
    <div id="chatDialogBoxContainer" style="display: <?php echo $chatDisplayType ; ?>;">
     
        <div class="messageDivContainer">
            <div class="messageDiv">
                <div class="messageDivHeader">
                    <table>
                        <td width="100%">
                            <div style="text-align:left;">
                                <img src="../img/profilepictures/null.png" id="messagePartnerImage" class="messagePartnerImage">
                                <span id="messagePartnerName" class="messagePartnerName">Undefined</span>
                            </div>
                        </td>
                        <td>
                            <div style="text-align:right;">
                                <img src="../img/refresh.png" class="messageBoxRefreshImage">
                            </div>
                        </td>
                        <td>
                            <div style="text-align:right;">
                                <img src="../img/close_black_2048x2048.png" class="messageBoxCloseImage" onClick="chatDlgHide();">
                            </div>
                        </td>
                    </table>
                </div>
                <div class="messageDivBody" id="messageDivBody">
                    <div id="messageContents">

                    </div>
                    <!-- messages will append here --> 
                </div>
                <div class="messageDivFooter">
                    <table>
                        <td width="100%">
                            <textarea class="messageTextBox" id="messageTextBox" name="postContent" cols="33" rows="1" placeholder="send a message"></textarea>
                            <!-- <input type="text" width="100%" height="100%" style="border:none;"> -->
                        </td>
                        <td>
                            <img src="../img/send-button.png" class="messageSendImageButton" >
                            <input type="hidden" value="" id="memberDetailNumber">
                        </td>
                    </table>
                </div>
            </div>
        </div>

    </div>
    </div>
    <!-- chat alert box end -->

    
    <!-- Javascript files should be link at the bottom of the page -->
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>

    <!-- Leatest Compiled and minified js file -->
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>

    <script type="text/javascript" src="../js/custom.js"></script>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
    
    <script>
var flag =0;

    function loadMessages(flag,limit){
        var partnerId = document.getElementById("memberDetailNumber").value;
        $.ajax({
            type:"GET",
            url:"../proPages/getMessages.php",
            data:{
            'offset':flag,
            'limit':limit,
            'myId':<?php echo $GLOBALS['id']; ?>,
            'partnerId':partnerId
            },
            success:function(data){
                $('#messageContents').prepend(data);
            }
        });
    }

    function sendMessage(message){
        var partnerId = document.getElementById("memberDetailNumber").value;
        $.ajax({
            type:"GET",
            url:"../proPages/sendMessage.php",
            data:{
            'myId':<?php echo $GLOBALS['id']; ?>,
            'partnerId':partnerId,
            'message':message
            },
            success:function(data){
                document.getElementById("messageTextBox").value='';
                if(data != ""){
                    $('#messageContents').append(data);
                }else{
                    var errorMsg = "<center><div style='width:90%;padding-right:10px;padding-left:10px;border:solid red;display: inline-block;background:#ff8282;border:solid #008c43 0.5px;border-radius:15px;'><span>Messsage Not Sned !</span></div></center>";
                    $('#messageContents').append(errorMsg);
                }
                $("#messageDivBody").animate({ scrollTop:999999999 }, "fast");
            }
        });
        
    }
    
    $(document).ready(function() {

        $("#relationTypeSelectionList").autocomplete({
            <?php
            echo getSourceString($conn);
            ?>
        });

        $(".familyMemberListCard").click(function(){
            document.getElementById("messageContents").innerHTML="";
            flag=0;
            loadMessages(flag,15);
            flag += 15;

            $("#messageDivBody").animate({ scrollTop:999999999 }, "fast");
        });

        $("#messageDivBody").scroll(function(){
            if($('#messageDivBody').scrollTop() <= 0 ){
                loadMessages(flag,5);
                flag += 5;
            }
        });

        $(".messageSendImageButton").click(function(){
            var textMessage=document.getElementById("messageTextBox").value;
            if(textMessage.trim()!=""){
                sendMessage(textMessage+'');
                flag = 15;
            }else{
                
            }
        });

        $(".messageBoxRefreshImage").click(function(){
            document.getElementById("messageContents").innerHTML="";
            loadMessages(0,15);
            flag = 15;
            $("#messageDivBody").animate({ scrollTop:999999999 }, "fast");
        });

    });


    </script>
</body>
    
</html>