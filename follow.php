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

/*$pre_sql = "select idol_name, fan_name from follow where idol_name = ? and fan_name = ?";
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("ss",$idol_name,$userid);
$pre_action ->bind_result($get_idol,$get_fan);
$pre_action ->execute();
if(!$row=$pre_action ->fetch()){*/
if($userid != $idol_name){
    $pre_sql = "insert into follow(idol_name, fan_name, time) values(?,?,?)";
    $pre_action = $link ->prepare($pre_sql);
    $pre_action ->bind_param("sss",$idol_name,$userid,$time);

    if(!$pre_action ->execute())
    {
        echo"You failed to follow! Please try again"."<br/><br/>";
        echo"<a href='user.php?uid=$idol_name'>Go back</a>";
    }
    else
    {
        echo"Thank you!You have followed successfully!"."<br/><br/>";
        echo"<a href='user.php?uid=$idol_name'>Go back</a>";
    }
}else{
    echo"You can't follow yourself!"."<br/><br/>";
    echo"<a href='user.php?uid=$idol_name'>Go back</a>";
}

$pre_action ->free_result();
$pre_action ->close();

?>