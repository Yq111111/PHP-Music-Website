<!DOCTYPE html>
<html>
<head>
  <title>track page</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="track.css">
</head>
<body>


<?php include("navbar.php"); ?>


<?php
session_start();
$tid=htmlspecialchars($_GET['tid'],ENT_QUOTES);
$userid=$_SESSION['username'];
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
$link = mysqli_connect("localhost:8889","root","root","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}
//歌曲详情
$pre_sql = "select ttitle,aname,aid, tduration, tgenre from track natural join artist where tid = ?";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$tid);
$pre_action ->bind_result($get_ttitle,$get_aname,$get_aid,$get_tduration,$get_tgenre);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
?>

<div class="main-part">
	<div class="container">
      <div class="row">
            <div class="col-md-4">
            	<div class="thumbnail">
              		<img src="img/example.jpg">
              	</div>
            </div><!--/span-->
            <div class="col-md-8">
              <h1>
                <a href="user_play_track.php?tid=<?php echo "$tid"; ?>" type="button" class="btn btn-primary">Play</a>
              	<?php
              		echo "$get_ttitle";
              	?>
              </h1>
              <h3>Artist: <a href="artist.php?aid=<?php echo $get_aid; ?>"><?php
              		echo "$get_aname";
              	?>
              </h3></a>

<?php
}    

//这首歌的平均分
$pre_sql = "select avg(score) as avgscore from user_rate_track where tid = ?";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$tid);
$pre_action ->bind_result($get_avgscore);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
?>


              	<h3>Rate: <?php
              		echo "$get_avgscore";
}
?>


              	</h3>
              	<hr>
          <form class="form-group" method="POST" action="user_rate_track.php">
			  	<label for="rate-the-song">rate this song:</label>
				  <select class="form-control" id="rate-the-song" name="rate-result">
				    <option>1</option>
				    <option>2</option>
				    <option>3</option>
				    <option>4</option>
				    <option>5</option>
				  </select>
          <input type="hidden" value=<?php echo "$tid"; ?> name="tid">
				  <button type="submit" class="btn btn-default" id="the-btn">submit</button>
				</form>
        <hr>
<?php /////////////////////////////?>
        <form class="form-group" method="POST" action="add_track_to_mylist.php">
          <label for="rate-the-song">add this song to your playlist:</label>
          <select class="form-control" id="add-to-playlist" name="add-to-playlist">


            <?php
            $pre_sql = "select pid, ptitle from playlist where uid = ?";//Pre operated.Set the query structure
            $pre_action = $link ->prepare($pre_sql);
            $pre_action ->bind_param("s",$userid);
            $pre_action ->bind_result($get_pid,$get_ptitle);
            $pre_action ->execute();

            while($row=$pre_action ->fetch()){
            ?>
            <option><?php echo "$get_pid"." --- "."$get_ptitle"; ?></option>
            <?php
            }
            ?>
          </select>
          <input type="hidden" value=<?php echo "$tid"; ?> name="tid">
          <button type="submit" class="btn btn-default" id="the-btn">add</button>
        </form>
<?php /////////////////////////////?>
            </div>
          </div>


<hr>

        <div class="col-md-6">
        	<div class="list-group">
	            <h3> Albums:</h1>
				<hr class="m-y-md">
				<ul class="list-group">


<?php
//包含这首歌的专辑
$pre_sql = "select alid, altitle, aldate, playtimes from track_in_album natural join album where tid = ?";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$tid);
$pre_action ->bind_result($get_alid,$get_altitle,$get_aldate,$get_playtimes);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
?>

			<li class="list-group-item">
				<a href="album.php?alid=<?php echo $get_alid; ?>"><h4><?php echo "$get_altitle"; ?></h4></a>
			</li>
<?php
}
?>
          </div>
        </div>

        <div class="col-md-6">
          <div class="list-group">
            <h3> Playlists:</h1>
			<hr class="m-y-md">
			<ul class="list-group">


<?php
//包含这首歌的playlist
$pre_sql = "select pid, ptitle, uid, playtimes  from track_in_playlist natural join playlist where tid = ? and status=1";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$tid);
$pre_action ->bind_result($get_pid,$get_ptitle,$get_uid,$get_playtimes);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
?>

			<li class="list-group-item">
				<a href="playlist.php?pid=<?php echo $get_pid; ?>"><h4><?php echo "$get_ptitle"; ?></h4>
			</li>
<?php
}
?>
          </div>
        </div>
      </div>

  </div>



</body>
</html>