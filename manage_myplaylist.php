<!DOCTYPE html>
<html>
<head>
  <title>manage playlist page</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="mylist.css">
</head>
<body>


<?php include("navbar.php"); ?>



 <?php
header("content-type:text/html;charset=utf-8");
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
$link = mysqli_connect("localhost:8889","root","root","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}

session_start();
$userid=$_SESSION['username'];
$pid=htmlspecialchars($_GET['pid'],ENT_QUOTES);
$pre_sql = "select ttitle, tid from track_in_playlist natural join track natural join playlist where pid = ? and uid = ?";
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("ss",$pid,$userid);
$pre_action ->bind_result($ttitle,$tid);
$pre_action ->execute();

?>


<div class="container" id="search-result">
<h1> <?php echo "$userid"; ?>'s Playlist</h1>
<hr class="m-y-md">
<ul class="list-group">

<?php


while($row=$pre_action ->fetch()){
    ?>
    
    <li class="list-group-item">
    	<a href="track.php?tid=<?php echo $tid; ?>">
    	<?php echo "$ttitle<br>"; ?></a>
    	<a href="delete_track_from_myplaylist.php?pid=<?php echo $pid; ?>&tid=<?php echo $tid; ?>&uid=<?php echo $userid; ?>" type="button" class="btn btn-danger">delete</a>
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


