<!DOCTYPE html>
<html>
<head>
  <title>search page</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="search.css">
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
$keyword=htmlspecialchars($_POST['keyword'],ENT_QUOTES);
$inputword = $keyword;
$word="%";
$word.=$keyword;
$word.="%";
$keyword=$word;
?>




<div class="container" id="search-result">
<h1> Search Result For '<?php echo "$inputword"; ?>'</h1>
<hr class="m-y-md">
<ul class="list-group">
<li><h4>Artists</h4></li>
<?php
//Output related artists by artists name
$pre_sql = "select aid, aname from artist where aname LIKE ? ";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$keyword);
$pre_action ->bind_result($get_aid,$get_aname);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
    ?>
    <a href="artist.php?aid=<?php echo $get_aid; ?>">
    <li class="list-group-item">
    	<?php echo "$get_aname<br>"; ?>
    </li></a>
    <?php
}
?>
<li><h4>Tracks</h4></li>
<?php
//Output related tracks. Incude: title, artist name, genre
$pre_sql = "select tid, ttitle, aname from track natural join artist where ttitle LIKE ? or aname LIKE ? or tgenre LIKE ?";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("sss",$keyword,$keyword,$keyword);
$pre_action ->bind_result($get_tid,$get_ttitle,$get_aname);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
    ?>
    <a href="track.php?tid=<?php echo $get_tid; ?>">
    <li class="list-group-item">
    	<?php echo "$get_ttitle----$get_aname<br>"; ?>
    </li></a>
    <?php
}
?>
<li><h4>Albums</h4></li>
<?php
//Output Album with related title
$pre_sql = "select alid, altitle from album where altitle LIKE ? ";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$keyword);
$pre_action ->bind_result($get_alid, $get_altitle);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
	?>
    <a href="album.php?alid=<?php echo $get_alid; ?>">
    <li class="list-group-item">
    	<?php echo "$get_altitle<br>"; ?>
    </li></a>
    <?php 
}

?>
<li><h4>Users</h4></li>
<?php
//Output related users
$pre_sql = "select uid,uname from user where uid LIKE ? ";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$keyword);
$pre_action ->bind_result($get_uid, $get_uname);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
    ?>
    <a href="user.php?uid=<?php echo $get_uid; ?>">
        <li class="list-group-item">
            <?php echo "$get_uid"; ?>
        </li></a >
    <?php

}

?>
<li><h4>Playlists</h4></li>
<?php
//Output related Playlist title
$pre_sql = "select pid, altitle from playlist where ptitle LIKE ? ";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$keyword);
$pre_action ->bind_result($get_pid, $get_ptitle);
$pre_action ->execute();

while($row=$pre_action ->fetch()){
    ?>
    <li class="list-group-item">
    	<?php echo "$get_pid----$get_ptitle<br>"; ?>
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