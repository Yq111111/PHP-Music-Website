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
$aid=htmlspecialchars($_GET['aid'],ENT_QUOTES);
$time=date('Y-m-d H:i:s');

$pre_sql = "insert into user_like_artist(uid,aid,time) values(?,?,?)";
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("sss",$userid,$aid,$time);
if(!$pre_action ->execute())
{
    echo"You failed to like this artist! You had liked him/her before"."<br/><br/>";
    echo"<a href='artist.php?aid=$aid'>Go back</a>";
}
else
{
    echo"Thank you!You have liked this artist successfully!"."<br/><br/>";
    echo"<a href='artist.php?aid=$aid'>Go back</a>";
}
$pre_action ->free_result();
$pre_action ->close();

?>