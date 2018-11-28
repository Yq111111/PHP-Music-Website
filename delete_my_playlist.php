<?php
header("content-type:text/html;charset=utf-8");
date_default_timezone_set('America/New_York');
//Connect to the database
$link = mysqli_connect("localhost:8889","root","root","project");
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}
session_start();
$userid=$_SESSION['username'];
$pid=htmlspecialchars($_GET['pid'],ENT_QUOTES);
$time=date('Y-m-d H:i:s');

$pre_sql = "DELETE from track_in_playlist where pid = ?";
$pre_action =$link ->prepare($pre_sql);
$pre_action ->bind_param("s",$pid);
if(!$pre_action ->execute())
{
    echo"You failed to delete this playlist! Please try again"."<br/><br/>";
    echo"<a href='myplaylist.php'>Go back</a>";
}


$pre_sql = "DELETE from playlist where uid = ? and pid = ?";
$pre_action =$link ->prepare($pre_sql);
$pre_action ->bind_param("ss",$userid,$pid);
if(!$pre_action ->execute())
{
    echo"You failed to delete this playlist! Please try again"."<br/><br/>";
    echo"<a href='myplaylist.php'>Go back</a>";
}
else
{
    echo"Thank you!You have deleted this playlist successfully!"."<br/><br/>";
    echo"<a href='myplaylist.php'>Go back</a>";
}

$pre_action ->free_result();
$pre_action ->close();

?>