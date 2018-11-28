<!DOCTYPE html>
<html>
<head>
  <title>user page</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="user.css">
</head>
<body>


<?php include("navbar.php"); ?>



<?php

session_start();
$uid=htmlspecialchars($_GET['uid'],ENT_QUOTES);
$userid=$_SESSION['username'];
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
$link = mysqli_connect("localhost:8889","root","root","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}
//用户详情
$pre_sql = "select uid, uname, uemail, ucity  from user where uid = ? ";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$uid);
$pre_action ->bind_result($get_uid,$get_uname,$get_uemail, $get_ucity);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
?>




<div class="container">
	<div class="content">
<div class="span">
          <img class="img-circle" style="width: 200px; height: 200px;" src="img/portrait.jpeg">
          <h1><?php echo "$get_uid"; ?>  
          
          <a href="follow.php?idol_name=<?php echo "$get_uid"; ?>" type="button" class="btn btn-default" id="id-for-follow">+ Follow</a> <a href="unfollow.php?idol_name=<?php echo "$get_uid"; ?>" type="button" class="btn btn-default" id="id-for-unfollow">- Unfollow</a></h1>

          <h4>name: <?php echo "$get_uname"; ?></h4>
          <h4>email: <?php echo "$get_uemail"; ?></h4>
          <h4>Come from <?php echo "$get_ucity"; ?></h4>
<?php } ?>
          <hr>
        <div class="btn-group" role="group" aria-label="...">
			  <a href="personal_following.php?userid=<?php echo "$uid"; ?>" type="button" class="btn btn-default">Following</a>
        <a href="personal_fan.php?userid=<?php echo "$uid"; ?>" type="button" class="btn btn-default">Followers</a>
			  <a href="personal_Artist.php?userid=<?php echo "$uid"; ?>" type="button" class="btn btn-default">Favorite Artists</a>
			  <a href="personalplaylist.php?userid=<?php echo "$uid"; ?>" type="button" class="btn btn-default">Created Playlists</a>
		  </div>
        </div>
    </div>
</div>

<?php
//rest of the code for Javascript
$pre_sql = "select fan_name from follow where idol_name = ? ";
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$uid);
$pre_action ->bind_result($fan_name);
$pre_action ->execute();
$flag = false;
while($row=$pre_action ->fetch()){
  if($fan_name == $userid){
    $flag = true;
  }
}

?>



<div id="dom-target-follow" style="display: none;">
<?php
if($flag){
  echo "1";
}else{
  echo "2";
}
?>
</div>


<div id="dom-target-uid"  style="display:none;">
  <?php
    echo htmlspecialchars($uid);
  ?>
</div>
<div id="dom-target-userid"  style="display:none;">
  <?php
    echo htmlspecialchars($userid);
  ?>
</div>



<script type="text/javascript" src="user.js"></script>

</body>
</html>

