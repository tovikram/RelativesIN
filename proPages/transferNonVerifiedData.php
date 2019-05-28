<?php

date_default_timezone_set("Asia/Kolkata");

// query to geting deatils about user ...is same user is exist or not     
$userCheck = "select * from temp_new_user where tempId = $idStr";
$result=mysqli_query($conn,$userCheck);
$row = mysqli_fetch_assoc($result);
$rowcount=mysqli_num_rows($result);
$result->close();

if($rowcount ==1){
    
    $firstName = $row['tempFname'];
    $lastName = $row['tempLname'];
    $mobileNumber = null;
    $email = $row['tempEmail'];
    $password1 = $row['tempPass'];
    
    $sql = "INSERT INTO signup_family_in (userFirstName,userLastName,userContact,userEmail,familyinPassword) VALUES('$firstName','$lastName',null,'$email','$password1')";

    //Checking if query is executed successfuly or not 
    if ($conn->query($sql) === TRUE) {
            
            if ($conn->query("DELETE FROM temp_new_user WHERE tempId=$idStr") === TRUE) {
                
                $getNewId = "select familyinID from signup_family_in where userEmail = '$email'";
                $resultGetNewId=mysqli_query($conn,$getNewId);
                $rowNewId = mysqli_fetch_assoc($resultGetNewId);
                $resultGetNewId->close();
                $id = $rowNewId['familyinID'];
                
                
                if ($conn->query("INSERT INTO more_details VALUES($id,'null.png',null,null,now(),null,null,null) ") === TRUE){
                    $_SESSION['user'] = $email;
                    $_SESSION['accountStatus'] = "Verified";
                    $verificationStatus = 1;
                }else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                $verificationStatus = 0;
                }
            }
                else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                $verificationStatus = 0;
            }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $verificationStatus = 0;
    }
}else{
    echo "Error: " . $userCheck . "<br>" . $conn->error;
    $verificationStatus = 0;
}

?>