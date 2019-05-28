<?php
date_default_timezone_set("Asia/Kolkata");

$relationTypeListArray = array('Unknown','Father','Mother','Brother','Sister','Grand-Father','Grand-Mother');
settype($relationTypeSelectedIndex,'int');

$getMemberIdQuery = "SELECT * FROM signup_family_in WHERE userEmail ='". $addMemberEmailId ."'";
$resultGetMemberId = mysqli_query($conn,$getMemberIdQuery,MYSQLI_USE_RESULT);
$rowGetMemberId = $resultGetMemberId->fetch_assoc();

$resultGetMemberId->close();

$queryStatus = 0;

if ($rowGetMemberId['familyinID'] == NULL) {
	$outputMsg = "No Record Found With this Email Address !!";
	$queryStatus = 0;
}else{
	$memberId = $rowGetMemberId['familyinID'] ."";

	$getMyMembersQuery = "SELECT membersID FROM more_details WHERE familyinID = $id";
	$resultGetMyMembers = mysqli_query($conn,$getMyMembersQuery,MYSQLI_USE_RESULT);
	$rowGetMyMembers = $resultGetMyMembers->fetch_assoc();

	$resultGetMyMembers->close();

	if ($rowGetMyMembers['membersID'] == NULL) {
		$myNewMembersId = $memberId ."";
	}else{
		$myNewMembersId = $rowGetMyMembers['membersID'] ."-".$memberId;
	}

	$myMembersIdArray = preg_split("/-/", $rowGetMyMembers['membersID']);
	$flag =0;
	for ($i=0; $i < count($myMembersIdArray); $i++) { 
		if ($myMembersIdArray[0] == NULL) {
			$flag = 0;
			break;
		}
		if ($memberId == $myMembersIdArray[$i]) {
			$flag = 1;
			break;
		}
	}


	if ($memberId != $id) {
			if ($flag == 0) {
			$updateQuery = "UPDATE more_details SET membersID = '".$myNewMembersId."' WHERE familyinID = $id";
			mysqli_query($conn,$updateQuery,MYSQLI_USE_RESULT);
			$outputMsg = $rowGetMemberId['userFirstName'] . " ".$rowGetMemberId['userLastName']." is added into your account as ".$relationTypeSelected;
			$queryStatus = 1 ;
		}else{
			$outputMsg = "This Member is already added into your account";
		}
	}
	else{
		$outputMsg = "You can't add yourself into your account";
	}

}

if ($queryStatus == 1) {
	$membersOfQuery = "SELECT iAmMemberOf FROM more_details WHERE familyinID = $memberId";
	$resultMemberOf=mysqli_query($conn,$membersOfQuery,MYSQLI_USE_RESULT);
	$rowMemberOf = $resultMemberOf->fetch_assoc();

	$resultMemberOf->close();

	if ($rowMemberOf['iAmMemberOf'] == NULL) {
		$myNewMemberOf = $id ."";
	}else{
		$myNewMemberOf = $rowMemberOf['iAmMemberOf'] ."-".$id;
	}

	$updateQuery = "UPDATE more_details SET iAmMemberOf = '".$myNewMemberOf."' WHERE familyinID = $memberId";
	mysqli_query($conn,$updateQuery,MYSQLI_USE_RESULT);

	//adding relationdetail in table
	//$relationTypeSelected = str_replace('`','\`',$relationTypeSelected,$i);
	$updateQuery2 = "INSERT INTO relationsdetails(familyinID,relation,memberID,addDateTime) VALUES($id,'".$relationTypeSelected."',$memberId,now())";
	if ($conn->query($updateQuery2) === TRUE) {
    
    setcookie("addMemberOutputMsg", $outputMsg, time() + (86400 * 1), '/'); // 86400 = 1 day
    header("Location: ../pages/myFamily.php");
	}else{
		//die("Connection failed: ".$relationTypeSelected . $conn->connect_error);
		header("Location: ../pages/errorPage.php");
	}
}

?>