<!DOCTYPE html>
<html>
<head>
  <title>artist page</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="artist-album-playlist.css">
</head>
<body>


<?php include("navbar.php"); ?>


<?php
session_start();
$aid=htmlspecialchars($_GET['aid'],ENT_QUOTES);
$userid=$_SESSION['username'];
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
$link = mysqli_connect("localhost:8889","root","root","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}
//歌手详情
$pre_sql = "select aid, aname, adescription from artist where aid = ?";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$aid);
$pre_action ->bind_result($get_aid,$get_aname,$adescription);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
?>


<div class="main-part">
	<div class="container">
      <div class="row">
            <div class="col-md-4">
            	<div class="thumbnail">
              		<img src="img/artist.jpg">
              	</div>
            </div>
            <div class="col-md-8">
              <h1><?php echo "$get_aname  "; ?><a href="user_like_artist.php?aid=<?php echo "$get_aid"; ?>" type="button" class="btn btn-default" id="id-for-follow">+ Like</a> <a href="user_dump_artist.php?aid=<?php echo "$get_aid"; ?>" type="button" class="btn btn-default" id="id-for-unfollow">- Dump</a></h1></h1>
              <h3><?php echo "$adescription"; ?></h3>

            </div>
          </div>


<?php
}
?>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Tracks</h3>
  </div>
  <div class="panel-body">
    
		<ul class="list-group">

			<?php 
				$pre_sql = "select tid,ttitle,aname from track natural join artist where aid = ?";
					$pre_action = $link ->prepare($pre_sql);
					$pre_action ->bind_param("s",$aid);
					$pre_action ->bind_result($get_tid,$get_ttitle,$get_aname);
					$pre_action ->execute();

					while($row=$pre_action ->fetch()){
				    ?>
				    <a href="track.php?tid=<?php echo $get_tid; ?>">
				    <li class="list-group-item">
				    	<?php echo "$get_ttitle"; ?>
				    </li></a>
				    <?php
				}
				$pre_action ->free_result();
				$pre_action ->close();
				?>


		</ul>
  </div>
</div>
</div>



<?php
//rest of the code for Javascript
$pre_sql = "select aid from user_like_artist where uid = ? ";
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$userid);
$pre_action ->bind_result($get_aid);
$pre_action ->execute();
$flag = false;
while($row=$pre_action ->fetch()){
  if($aid == $get_aid){
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


<script type="text/javascript" src="artist.js"></script>
</body>
</html>