<?php
date_default_timezone_set("Asia/Kolkata");

switch($editTypeForSwitch){
    case "name":
        $updateQuery1 = "UPDATE signup_family_in SET userFirstName='".$newFirstName."',userLastName='".$newLastName."' WHERE familyinID=".$GLOBALS['id'];
        if ($conn->query($updateQuery1)){
            $msg = 'Name Updated sucecssfully';
            header("location: ../pages/updateProfileDetails.php?field=".encyptData("name")."&er=".encyptData($msg));
        }else{
            //$msg = 'Something is wrong while updating';
            //header("location: ../pages/updateProfileDetails.php?field=".encyptData("name")."&er=".encyptData($msg));
            header("Location: ../pages/errorPage.php");
        }
        break;

    case "gender":
        $updateQuery1 = "UPDATE more_details SET userGender='".$newGender."' WHERE familyinID=".$GLOBALS['id'];
        if ($conn->query($updateQuery1)){
            $msg = 'Gender Updated sucecssfully';
            header("location: ../pages/updateProfileDetails.php?field=".encyptData("gender")."&er=".encyptData($msg));
        }else{
            //$msg = 'Something is wrong while updating';
            //("location: ../pages/updateProfileDetails.php?field=".encyptData("gender")."&er=".encyptData($msg));
            header("Location: ../pages/errorPage.php");
        }
        break;

    case "password":
        if($GLOBALS['result2']['familyinPassword'] == md5($oldPass)){
            if($newPass == $reNewPass){
                if(strlen($newPass) >= 8){
                    $newPass = md5($newPass);
                    $updateQuery1 = "UPDATE signup_family_in SET familyinPassword='".$newPass."' WHERE familyinID=".$GLOBALS['id'];
                    if ($conn->query($updateQuery1)){
                        $msg = 'Password changed successfully';
                        header("location: ../pages/updateProfileDetails.php?field=".encyptData("password")."&er=".encyptData($msg));
                    }else{
                        //$msg = 'Something is wrong while password changing';
                        //header("location: ../pages/updateProfileDetails.php?field=".encyptData("password")."&er=".encyptData($msg));
                        header("Location: ../pages/errorPage.php");
                    }
                }else{
                    $msg = 'Password length should be more than 7';
                    header("location: ../pages/updateProfileDetails.php?field=".encyptData("password")."&er=".encyptData($msg));
                }
            }else{
                $msg = 'New password does not matched';
                header("location: ../pages/updateProfileDetails.php?field=".encyptData("password")."&er=".encyptData($msg));
            }
        }else{
            $msg = 'Please write correct old password';
            header("location: ../pages/updateProfileDetails.php?field=".encyptData("password")."&er=".encyptData($msg));
        }
        break;

    case "dob":
        if(strtotime(date('Y-m-d').'') < strtotime(date($newDOB).'')){
            $msg = 'You cannot select future date';
            header("location: ../pages/updateProfileDetails.php?field=".encyptData("dob")."&er=".encyptData($msg)); 
        }else{
            $updateQuery2 = "UPDATE more_details SET userDOB='".$newDOB."' WHERE familyinID=".$GLOBALS['id'];
            if ($conn->query($updateQuery2)){
                $msg = 'Date of birth updated successfully';
                header("location: ../pages/updateProfileDetails.php?field=".encyptData("dob")."&er=".encyptData($msg)); 
            }else{
                //$msg = 'Something is wrong while inserting';
                //header("location: ../pages/updateProfileDetails.php?field=".encyptData("dob")."&er=".encyptData($msg)); 
                header("Location: ../pages/errorPage.php");
            }
        }
        break;

    default:
        //echo "<script>alert('Something is wrong ! Please Try angain.');</script>";
        //header("location: ../pages/editProfile.php");
        header("Location: ../pages/errorPage.php");
        break;
}

?>