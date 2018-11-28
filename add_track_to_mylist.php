<?php
header("content-type:text/html;charset=utf-8");
//Connect to the database
$link = mysqli_connect("localhost:8889","root","root","project");
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}
session_start();
$userid=$_SESSION['username'];
$pdata=htmlspecialchars($_POST['add-to-playlist'],ENT_QUOTES);
$tid=htmlspecialchars($_POST['tid'],ENT_QUOTES);
echo $pdata; 

$p = "/.{3}/";
preg_match($p, $pdata, $match);

$pid = $match[0];



/*$userid='yaoqi';
$ptitle='yaoqi playlist';
$status=1;*/

$pre_sql = "insert into track_in_playlist(pid,tid) values(?,?)";
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("ss",$pid,$tid);
if(!$pre_action ->execute())
{
    echo"You failed to add this song to the playlist. Please try again"."<br/><br/>";
    echo"<a href='track.php?tid=".$tid."'>Go back</a>";
}
else
{
    echo"Thank you!You have add this song to your playlist successfully!"."<br/><br/>";
    echo"<a href='track.php?tid=".$tid."'>Go back</a>";
    //echo"<a href='homepage.php'>Go back</a>";
}
$pre_action ->free_result();
$pre_action ->close();

?>