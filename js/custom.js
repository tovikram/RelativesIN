function nameValidation(tagId) {
    var boxValue = document.getElementById(tagId).value;
    
    var asciiOfLast = boxValue.charCodeAt(boxValue.length -1);
    
    var asciiSymbol = [33,34,35,36,37,38,40,41,42,43,44,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,91,92,93,94,95,96,123,124,125,126]; 
    
    var i=0;
    for(i=0; i < asciiSymbol.length; i++){
        if(asciiOfLast == asciiSymbol[i]){
            
            if(boxValue.length == 1){
                document.getElementById(tagId).value = "";
                boxValue = ""
            }else{
                document.getElementById(tagId).value = boxValue.substring(0, boxValue.length -1);
            }
        }
    }
    
    if(boxValue.length == 1){
        document.getElementById(tagId).value = boxValue.toUpperCase();
        
    }
}


function lastName(){
    var id = "Inputlname";
    nameValidation(id);
}

function firstName(){
    var id = "Inputfname";
    nameValidation(id);
}

function mobileMax(){
    var boxValue = document.getElementById("InputMobile").value;
    if(boxValue.length > 10){
        document.getElementById("InputMobile").value=boxValue.substring(0,10);
    }
}

function dlgHide(){
    var whitebg = document.getElementById("dialogOverlay");
    var dlg = document.getElementById("dialogBoxContainer");
    whitebg.style.display = "none";
    dlg.style.display = "none";
    document.cookie = "addMemberOutputMsg=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

function showDialog(){
    var whitebg = document.getElementById("dialogOverlay");
    var dlg = document.getElementById("dialogBoxContainer");
    whitebg.style.display = "block";
    dlg.style.display = "block";
    var winWidth = window.innerWidth;
    dlg.style.left = "30%";
    dlg.style.top = "150px";
    //alert("clicked");
}

function chatDlgHide(){
    var whitebg = document.getElementById("chatDialogOverlay");
    var dlg = document.getElementById("chatDialogBoxContainer");
    whitebg.style.display = "none";
    dlg.style.display = "none";
}

function showChatDialog(imageUrl,name,memberId){
    var whitebg = document.getElementById("chatDialogOverlay");
    var dlg = document.getElementById("chatDialogBoxContainer");
    document.getElementById("messagePartnerImage").src = imageUrl+"";
    document.getElementById("messagePartnerName").innerHTML = name.slice(0,17)+"";
    document.getElementById("memberDetailNumber").value = memberId+"";
    whitebg.style.display = "block";
    dlg.style.display = "block";
    var winWidth = window.innerWidth;
    dlg.style.left = "40%";
    dlg.style.top = "80px";
    //alert("clicked");
}

function highlightCreatePostBox(){
    var createPostBox = document.getElementById("createPostBox");
    createPostBox.style.boxShadow = " -2px 4px 39px 0px rgba(0,0,0,0.75)";
    createPostBox.style.border= "1px solid black";
}
function normalCreatePostBox(){
   var createPostBox = document.getElementById("createPostBox");
    createPostBox.style.boxShadow = "none";
    createPostBox.style.border = "1px solid grey";
}

function highlightEditRow(indexStr){
    var strId = "editProfileDisplayRow" + indexStr;
    document.getElementById(strId).style.backgroundColor = "#d8d8d8";
}


function UnhighlightEditRow(indexStr){
    var strId = "editProfileDisplayRow" + indexStr;
    document.getElementById(strId).style.backgroundColor = "Transparent";
}

function onProfileImageSelected(){
    document.getElementById("profileimageSelectedMessage").innerHTML = "<br>1 Image Selected, Please Upload ! <br>";
}

function updateProfileSubmitButtonOver(){
    document.getElementById("updateProfileSubmitButton").style.background = "rgb(165, 227, 255)";
}

function updateProfileSubmitButtonOut(){
    document.getElementById("updateProfileSubmitButton").style.background = "transparent";
}

window.onclick = function(){
    $.post('../proPages/updateOnlineStatus.php?status=on',null,function(info){});
}

window.onbeforeunload = function(){
    $.post('../proPages/updateOnlineStatus.php?status=off',null,function(info){});
}
