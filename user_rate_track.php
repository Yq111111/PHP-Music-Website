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
$score=htmlspecialchars($_POST['rate-result'],ENT_QUOTES);
$tid=htmlspecialchars($_POST['tid'],ENT_QUOTES);
$time=date('Y-m-d H:i:s');
$pre_sql = "insert into user_rate_track(uid,tid,score,time) values(?,?,?,?)";
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("ssss",$userid,$tid,$score,$time);
if(!$pre_action ->execute())
{
    echo"You failed to rate this song! You had rated before"."<br/><br/>";
    echo"<a href='track.php?tid=$tid'>Go back</a>";
}
else
{
    echo"Thank you!You have rated this song successfully!"."<br/><br/>";
    echo"<a href='track.php?tid=$tid'>Go back</a>";
}
$pre_action ->free_result();
$pre_action ->close();

?>