<!DOCTYPE html>
<html>
<head>
  <title>personal profile</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="personalprofile.css">
</head>
<body>


<?php include("navbar.php"); ?>


<?php
header("content-type:text/html;charset=utf-8");
//Connect to database
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
$link = mysqli_connect("localhost:8889","root","root","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}
session_start();
$userid=$_SESSION['username'];
$count = 0;
$pre_sql = "select uid, uname, uemail, ucity  from user where uid = ? ";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$userid);
$pre_action ->bind_result($get_uid,$get_uname,$get_uemail, $get_ucity);
$pre_action ->execute();
/*
while($row=$pre_action ->fetch()){
    echo "$get_uname----$get_uemail----$get_ucity<br>";
}
*/
while($row=$pre_action ->fetch()){
?>




<div class="container">
	<div class="content">
<div class="span">
          <img class="img-circle" style="width: 200px; height: 200px;" src="portrait.jpeg">
          <a href="user.php?uid=<?php echo $userid; ?>"><h2><?php echo "$get_uid"; ?>  </h2></a>
          <p>name: <?php echo "$get_uname"; ?></p>
          <p>email: <?php echo "$get_uemail"; ?></p>
          <p>Come from <?php echo "$get_ucity"; ?></p>
<?php } ?>
          <p><a href="editprofile.html" type="button" class="btn btn-default">Edit Your Profile</a></p>
          <a href="myplaylist.php" type="button" class="btn btn-default">Manage Your Playlists</a>
        </div>
    </div>


<div class="played">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Recently Played Tracks</h3>
  </div>
  <div class="panel-body">
    <div class="row">

<?php
$sql="select tid,ttitle, time from user_play_track natural join track where uid ='$userid' order by time desc";
$rs=mysqli_query($link,$sql); //get the result from the database
while($row=mysqli_fetch_assoc($rs)){
    $tid=$row['tid'];
    $ttitle=$row['ttitle'];
    $time=$row['time'];
      ?>


        <div class="col-sm-6 col-md-4 col-md-3">
          <div class="thumbnail">
            <img src="example.jpg">
            <div class="caption">
                <a href="track.php?tid=<?php echo $tid; ?>"><h3>
                <?php
                echo "\t\t<td>$ttitle</td>\n <br>";
                ?>
                </h3></a>
                <?php
                echo "played at \t\t<td>$time</td>\n<br>";
                ?>
            </div>
          </div>
        </div>
          
      <?php
            $count++;
    if($count == 16) break;
}
?>
    </div>
  </div>
</div>
</div>

</div>

</body>
</html>