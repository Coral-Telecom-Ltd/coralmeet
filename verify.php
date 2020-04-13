<!DOCTYPE html>
<html>
<head>
<title>Coral-Meet</title>
<script src="./vendor/jquery/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="./css/style.css" />
</head>
<body>
    <!--Contact Form-->
<div stype='background-image: url("youtube-banner.png");'>

<script>
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}
</script>

<?php
// Check if user exists
$user_exists = false;
if (isset($_POST["username"])){
    $user = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $filename = fopen("profiles.txt","r");
    while(! feof($filename))  {
        $result = fgets($filename);
        $result = substr($result,0,strlen($result)-1);
        if (strlen($result) > 1 and strcmp($result, $user) == 0){
            $user_exists = true;
        }
    }
}

// If not got user info or user exists, ask for username and system password
if (empty($_POST["send"]) or $user_exists or (!empty($_POST["send"]) and strlen($_POST["username"]) == 0)) {
    if ($user_exists){
        $hash = hash('ripemd160', $user.date('ljFY'));
        $hash = substr($hash,0,12);
    }
    
?>

    <div id="contact-popup">
        <form class="contact-form" action="" id="contact-form"
            method="post" enctype="multipart/form-data">
            <div class="watermark"></div>
<?php
if ( $user_exists) {
?>      
            <center>
            <h2>Welcome to your collaboration room! Valid for one day and enjoy the new experience.</h2>
            <h3>Click on the link below to enter. Copy & share the link with others who you want to invite. </h3>
            </center>
<?php
}
else {
?>
            <h1>Please enter assigned user name:</h1>
     
            
            <div>
                <div>
                    <input type="text" id="username" name="username"
                        class="inputBox" />
                </div>
            </div>
            <div>
                <input type="submit" id="send" name="send" value="Generate Link"/>
            </div>
<?php
}

    if ($user_exists){
        echo "<center><a href='https://collaboration.coraltele.com/";
        echo $hash."' class='w3-btn w3-black'>https://collaboration.coraltele.com/".$hash."</a></center><br>";
        echo "<a class='cls_copy_pg_action copyAction copy-action-btn' data-value='https://collaboration.coraltele.com/".$hash."'> <i class='far fa-copy'></i><center> Copy URL <img alt='copy' src='copy.png'
         width=15' height='15'> </center></a>";
    }
?>

        </form>
    </div>

<?php
}

if (!empty($_POST["send"]) and strlen($_POST["username"]) == 0){
    echo "Username can not be empty.";
}
elseif (!empty($_POST["send"])and !$user_exists) {
    echo "Username not registered! Please contact Coral Telecom.";
}
?>

<script>
$(document).ready(function () {
    $("#contact-popup").show();
    //Contact Form validation on click event
    $("#contact-form").on("submit", function () {
        var valid = true;
        $(".info").html("");
        $("inputBox").removeClass("input-error");
        
        var username = $("#username").val();

        if (username == "") {
            $("#userName").html("required.");
            $("#username").addClass("input-error");
        }
        return valid;
    });
});
$(document).on("click", ".copy-action-btn", function() { 
      var trigger = $(this);
      $(".copy-action-btn").removeClass("text-success");
      var $tempElement = $("<input>");
        $("body").append($tempElement);
        var copyType = $(this).data("value");
        $tempElement.val(copyType).select();
        document.execCommand("Copy");
        $tempElement.remove();
        $(trigger).addClass("text-success");

  });
</script>


