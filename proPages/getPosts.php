<?php
date_default_timezone_set("Asia/Kolkata");

include 'encryptDecryptData.php';
function getDetailsWithQuery($conn,$query){
    $result=mysqli_query($conn,$query,MYSQLI_USE_RESULT);
    $rowResult= $result->fetch_assoc();
    $result->close();
    return $rowResult;
}

if(isset($_GET['offset']) && isset($_GET['limit'])){
    $offset = $_GET['offset'];
    $limit = $_GET['limit'];
    $displayedPost = decryptData($_GET['displayedPost']);
    $membersList = decryptData($_GET['membersList']);

    require_once 'connectDatabase.php';

    $data = mysqli_query($conn,"SELECT * FROM post_details LIMIT {$limit} OFFSET {$offset}");
    $unwantedRow = 0;
if(mysqli_num_rows($data)!=0 && $membersList !='null'){
    while ($row = mysqli_fetch_array($data)) {
      $displayedPostArray = preg_split("/-/", $displayedPost);//chek post id
      $membersListArray = preg_split("/-/", $membersList);//chek member id $row['member_id'].'-';
      $condition1 = in_array($row['post_id'].'', $displayedPostArray);
      $condition2 = in_array($row['member_id'].'', $membersListArray);
      if(!$condition1 && $condition2 ) {
           
        $displayedPost = $displayedPost."-".$row['post_id'];
        $userDetails = getDetailsWithQuery($conn,"SELECT userFirstName,userLastName FROM signup_family_in WHERE familyinID=".$row['member_id']);
        $userProfileImage = getDetailsWithQuery($conn,"SELECT profile_image FROM more_details WHERE familyinID=".$row['member_id']);
        echo "<div style='margin-top: 10px;' class='postBox'>
            <div>
                <table cellpadding='0px'>
                <tr>
                    <td rowspan='2'><img class='postAvtar' src='../img/profilepictures/".$userProfileImage['profile_image']."' alt='Avatar'></td>
                    <td><strong class='postSenderName'>".$userDetails['userFirstName']." ".$userDetails['userLastName']."</strong></td>
                </tr>
                <tr><td><span class='postTime'>".$row['post_date_time']."</span></td></tr>
                </table>
            </div>
            <div style='border-bottom: solid;border-bottom-color: grey;border-width: 1px;width: 490px;margin-left: 10px;'></div>

            <div  class='postText'>
                <span>".$row['post_msg']."</span>
            </div>";

        if($row['post_img'] != null){
            echo "<img class='postImage' src='../img/postimages/".$row['post_img']."'>";
        }

        echo "<br><br>

            <div style='border-bottom: solid;border-bottom-color: grey;border-width: 1px;'></div>

            <div>
                <button class='postLike'>Like</button>
                <input class='postComment' type='text' name='postComment' placeholder='Comment...' onfocus='commentEntered()''>
                <button style='padding-top: 0px;padding-bottom: 0px;margin-top: 0px;' class='btn-success' disabled>Send</button>
            </div>
        </div>";
     }else{
         $unwantedRow +=1;
     }

    }
}

if(mysqli_num_rows($data)==0){
    echo "no record found";
}elseif($unwantedRow >= 3){
    echo " ";
}else{
    echo "<script>document.getElementById('displayedPost').value = '".encyptData($displayedPost)."';</script>";
}

}

?>