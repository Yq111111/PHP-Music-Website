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
$alid=htmlspecialchars($_GET['alid'],ENT_QUOTES);
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
$link = mysqli_connect("localhost:8889","root","root","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}
$pre_sql = "select altitle, aldate, playtimes from album where alid = ?";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$alid);
$pre_action ->bind_result($altitle,$aldate,$playtimes);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
?>


<div class="main-part">
	<div class="container">
      <div class="row">
            <div class="col-md-4">
            	<div class="thumbnail">
              		<img src="img/album.jpg">
              	</div>
            </div>
            <div class="col-md-8">
              <h1><?php echo "$altitle"; ?></h1>
              <h3>Released at <?php echo "$aldate"; ?></h3>
              <h3>Has been played for <?php echo "$playtimes"; ?> times</h3>
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
				$pre_sql = "select tid, ttitle from track_in_album natural join track natural join artist where alid = ?";
					$pre_action = $link ->prepare($pre_sql);
					$pre_action ->bind_param("s",$alid);
					$pre_action ->bind_result($tid,$ttitle);
					$pre_action ->execute();

					while($row=$pre_action ->fetch()){
				    ?>
				    <a href="track.php?tid=<?php echo $tid; ?>">
				    <li class="list-group-item">
				    	<?php echo "$ttitle"; ?>
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

</body>
</html>