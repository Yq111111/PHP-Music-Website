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
$pid=htmlspecialchars($_GET['pid'],ENT_QUOTES);
$tid=htmlspecialchars($_GET['tid'],ENT_QUOTES);
$uid=htmlspecialchars($_GET['uid'],ENT_QUOTES);

if($uid==$userid) {
    $pre_sql = "DELETE from track_in_playlist where  pid = ? and tid = ?";
    $pre_action = $link->prepare($pre_sql);
    $pre_action->bind_param("ss", $pid, $tid);
    if (!$pre_action->execute()) {
        echo "You failed to delete this song from your list! Please try again" . "<br/><br/>";
        echo "<a href='manage_myplaylist.php?pid=".$pid."'>Go back</a>";
    } else {
        echo "You have deleted this song from your playlist successfully!" . "<br/><br/>";
        echo "<a href='manage_myplaylist.php?pid=".$pid."'>Go back</a>";
    }
}
else{
    echo "You don't have the access to operate this!";
}
$pre_action ->free_result();
$pre_action ->close();

?>