<!DOCTYPE html>
<html>
<head>
  <title>homepage</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="homepage.css">
</head>
<body>

<?php include("navbar.php"); ?>






<?php
session_start();
$userid=$_SESSION['username'];
$count = 0;
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
$link = mysqli_connect("localhost:8889","root","root","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}
?>


<div class="container">

<div class="content">
  <div class="jumbotron">
  <h1 class="display-3">Hi, 
    <?php 
        echo "$userid";
    ?>
  <hr class="m-y-md">
  <p class="lead">DaLao Music, best music for you.</p>
  <a id="thelink" href="/personalprofile.php">Enter Your Personal Profile</a>
  
</div>
</div>







<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Tracks by Favourite Artists</h3>
  </div>
  <div class="panel-body">
    <div class="row">

<?php
$sql="select tid,ttitle, aname from track natural join artist  where aid in (select aid from user_like_artist where uid='$userid')";
$rs=mysqli_query($link,$sql); //get the result from the database
while($row=mysqli_fetch_assoc($rs)){

    $tid=$row['tid'];
    $ttitle=$row['ttitle'];
    $aname=$row['aname'];
      ?>

        <div class="col-sm-6 col-md-4 col-md-3">
          <div class="thumbnail">
            <img src="img/example.jpg">
            <div class="caption">
                <a href="track.php?tid=<?php echo $tid; ?>"><h3>
                <?php
                echo "\t\t<td>$ttitle</td>\n <br>";
                ?>
              </h3></a>
                <?php
                echo "\t\t<td>$aname</td>\n<br>";
                ?>
            </div>
          </div>
        </div>
          
      <?php
      $count++;
    if($count == 8) break;
}
?>
    </div>
  </div>
</div>



<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Following Users' Playlists</h3>
  </div>
  <div class="panel-body">
    <div class="row">

<?php
$sql="select pid,ptitle, uid from playlist where status=1 and uid in (select idol_name from follow where fan_name='$userid') order by pdate desc";
$rs=mysqli_query($link,$sql); //get the result from the database
$count = 0;
while($row=mysqli_fetch_assoc($rs)){
    $pid=$row['pid'];
    $ptitle=$row['ptitle'];
    $uid=$row['uid'];
      ?>
      <div class="col-sm-6 col-md-4 col-md-3">
        <div class="thumbnail">
          <img src="img/playlist.jpg">
          <div class="caption">
            <a href="playlist.php?pid=<?php echo $pid; ?>"><h3>
      <?php
        echo "\t\t<td>$ptitle</td>\n<br>";
      ?>
            </h3></a>
            <a href="user.php?uid=<?php echo $uid; ?>">
              <?php
              echo "\t\t<td>$uid</td>\n<br>";
              ?>
            </a>
        </div>
      </div>
    </div>
    <?php
    $count++;
    if($count == 8) break;
}

?>
    </div>
  </div>
</div>



<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Favourite Artists</h3>
  </div>
  <div class="panel-body">
    <div class="row">

<?php
$sql="select aid,aname, adescription from artist where aid in (select aid from user_like_artist where uid='$userid')";
$rs=mysqli_query($link,$sql); //get the result from the database
$count = 0;
while($row=mysqli_fetch_assoc($rs)){
    $aid=$row['aid'];
    $aname=$row['aname'];
    $adescription=$row['adescription'];
      ?>
      <div class="col-sm-6 col-md-4 col-md-3">
        <div class="thumbnail">
          <img src="img/artist.jpg">
          <div class="caption">
            <a href="artist.php?aid=<?php echo $aid; ?>"><h3>

      <?php
        echo "\t\t<td>$aname</td>\n <br>";
      ?>
        </h3></a>
              <?php
              echo "\t\t<td>$adescription</td>\n <br>";
              ?>
        </div>
      </div>
    </div>


      <?php
      $count++;
    if($count == 8) break;

}
?>





</body>
</html>