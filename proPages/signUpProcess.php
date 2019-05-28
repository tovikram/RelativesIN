<?php
date_default_timezone_set("Asia/Kolkata");

// query to geting deatils about user ...is same user is exist or not     
$userCheck = "select familyinID from signup_family_in where userEmail = '$email'";
$result=mysqli_query($conn,$userCheck); 
$rowcount=mysqli_num_rows($result);
$result->close();

if($rowcount >=1){
    // if user exist execute this block
    echo "<script> alert('Already a member');</script>";
}else{
    // if not exist then create database details for the user
    // query for Inserting new user details into the database
    $sql = "INSERT INTO temp_new_user(tempFname, tempLname, tempContact, tempEmail, tempPass, accountStatus) VALUES('$firstName','$lastName',null,'$email','$password1',0)";

    //Checking if query is executed successfuly or not 
    if ($conn->query($sql) === TRUE) {
                $tempFname = $firstName;
                $tempLname = $lastName;
                $tempEmail = $email;
            
                $getTempIdQuery = "SELECT tempId FROM temp_new_user WHERE tempEmail='$email' ORDER BY tempId desc LIMIT 1";
                $getTempIdQueryResult=mysqli_query($conn,$getTempIdQuery);
                $rowgetTempId = $getTempIdQueryResult->fetch_assoc();
                $getTempIdQueryResult->close();
                $tempId = $rowgetTempId['tempId'];
                require_once 'sendVerificationMail.php';
                //header('Location: pages/home.php');
            
    } else {
       // echo "Error: " . $sql . "<br>" . $conn->error;
       header("Location: ../pages/errorPage.php");
    }
}

?>