<!DOCTYPE html>
<html>
<head>
  <title>search page</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="user4pages.css">
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
$uid=$_SESSION['username'];
$userid=htmlspecialchars($_GET['userid'],ENT_QUOTES);
if($uid==$userid) {
    $pre_sql = "select pid, ptitle  from playlist where uid = ? ";//Pre operated.Set the query structure
    $pre_action = $link->prepare($pre_sql);
    $pre_action->bind_param("s", $userid);
    $pre_action->bind_result($get_pid, $get_ptitle);
    $pre_action->execute();
}else{
    $pre_sql = "select pid, ptitle  from playlist where uid = ? and status =1 ";//Pre operated.Set the query structure
    $pre_action = $link->prepare($pre_sql);
    $pre_action->bind_param("s", $userid);
    $pre_action->bind_result($get_pid, $get_ptitle);
    $pre_action->execute();
}
?>


<div class="container" id="search-result">
<h1> <?php echo "$userid"; ?>'s Playlists</h1>
<hr class="m-y-md">
<ul class="list-group">

<?php


while($row=$pre_action ->fetch()){
    ?>
    <a href="playlist.php?pid=<?php echo $get_pid; ?>">
    <li class="list-group-item">
    	<?php echo "$get_ptitle<br>"; ?>
    </li></a>

    <?php
}

$pre_action ->free_result();
$pre_action ->close();
?>

</ul>
</div>

</body>
</html>


