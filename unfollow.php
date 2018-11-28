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
$idol_name=htmlspecialchars($_GET['idol_name'],ENT_QUOTES);
$time=date('Y-m-d H:i:s');

if($userid != $idol_name){
$pre_sql = "DELETE from follow where idol_name = ? and fan_name = ?";
$pre_action =$link ->prepare($pre_sql);
$pre_action ->bind_param("ss",$idol_name,$userid);
if(!$pre_action ->execute())
{
    echo"You failed to unfollow! Please try again"."<br/><br/>";
    echo"<a href='user.php?uid=$idol_name'>Go back</a>";
}
else
{
    echo"Thank you!You have unfollowed successfully!"."<br/><br/>";
    echo"<a href='user.php?uid=$idol_name'>Go back</a>";
}
}else{
	echo"You can't unfollow yourself!"."<br/><br/>";
    echo"<a href='user.php?uid=$idol_name'>Go back</a>";
}

$pre_action ->free_result();
$pre_action ->close();

?>