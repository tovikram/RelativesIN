<?php
date_default_timezone_set("Asia/Kolkata");

$imageName = $id . ".jpg" ;
$profilePicturePath = "../img/profilepictures/".$imageName;
    if(move_uploaded_file($tempPathName,$profilePicturePath)){
        $updateQuery = "UPDATE more_details SET profile_image = '$imageName' WHERE familyinID =$id ";
        $updateQueryResult=mysqli_query($conn,$updateQuery,MYSQLI_USE_RESULT);
        if($updateQueryResult){
           $isPictureUploaded = 1 ;
           header("Location: editProfile.php");
        }else{
            //echo "Error: " . $updateQuery . "<br>" . $conn->error ;
            header("Location: ../pages/errorPage.php");
        }
    }else{
       // echo "Error: " . $updateQuery . "<br>" . $conn->error ;
       header("Location: ../pages/errorPage.php");
    }



?>