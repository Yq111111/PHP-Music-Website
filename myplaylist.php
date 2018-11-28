<!DOCTYPE html>
<html>
<head>
  <title>myplaylists page</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="mylist.css">
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

$pre_sql = "select pid,ptitle,pdate, playtimes  from playlist where uid = ? ";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$userid);
$pre_action ->bind_result($get_pid,$get_ptitle,$get_pdate,$get_playtimes);
$pre_action ->execute();
?>


<div class="container" id="search-result">
<h1> <?php echo "$userid"; ?>'s Playlists</h1> <a href="bridge.html" type="button" class="btn btn-primary btn-lg">Create New Playlist</a>
<hr class="m-y-md">
<ul class="list-group">


<?php
while($row=$pre_action ->fetch()){
    ?>


    
    <li class="list-group-item">
    	<a href="playlist.php?pid=<?php echo $get_pid; ?>">
    	<?php echo "$get_ptitle<br>"; ?></a>
    	<a href="manage_myplaylist.php?pid=<?php echo $get_pid; ?>" type="button" class="btn btn-warning">manage</a>
    	<a href="delete_my_playlist.php?pid=<?php echo $get_pid; ?>" type="button" class="btn btn-danger">delete</a>
    </li>

    <?php
}
$pre_action ->free_result();
$pre_action ->close();
?>


</ul>
</div>

</body>
</html>
