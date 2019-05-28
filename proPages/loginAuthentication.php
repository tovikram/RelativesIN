<?php
date_default_timezone_set("Asia/Kolkata");

// writing query for fetching data from database for given user    
$sql = "select * from signup_family_in where userEmail = '$email'";
//executing the query and storing result in a variable
if($res=mysqli_query($conn,$sql,MYSQLI_USE_RESULT)){
    $row = mysqli_fetch_assoc($res); // storing that result in row format 

    $res->close();
    // matching the password entered and password stored in database
    if($row['familyinPassword']==md5($loginPassword)){
        $id = $row['familyinID'];
        $updateQuery= "UPDATE more_details SET onlineStatus=now() WHERE familyinID=".$id;
        mysqli_query($conn,$updateQuery,MYSQLI_USE_RESULT);

        $_SESSION['user'] = $email; // if user verified then creating sesssion for that user
        header('Location: pages/home.php'); // redirecting user to home page of website

    }
    else{
        $errorMsg = " Invalid Email or Password !"; //if password does not match then this message diplaying to user screen
    }
    
}else {
   // echo "Error: " . $sql . "<br>" . $conn->error ; //if any problem occurs while executing query then the error is display on screen
   header("Location: ../pages/errorPage.php");
}

?>