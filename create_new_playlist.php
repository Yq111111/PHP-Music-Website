
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
$ptitle=htmlspecialchars($_GET['ptitle'],ENT_QUOTES);
$k=htmlspecialchars($_GET['status'],ENT_QUOTES);
$status = -1;
if($k == "private"){
	$status = 0;
}else if($k == 'public'){
	$status = 1;
}


if($status == -1 || $ptitle == null){
	echo "Not valid input</br>";
	echo"<a href='myplaylist.php'>Go back</a>";
}else{
	$time=date('Y-m-d H:i:s');
	/*$userid='yaoqi';
	$ptitle='yaoqi playlist';
	$status=1;*/

	$pre_sql = "insert into playlist(pid,ptitle, pdate, playtimes, uid, status) values(null,?,?,0,?,?)";
	$pre_action = $link ->prepare($pre_sql);
	$pre_action ->bind_param("ssss",$ptitle,$time,$userid,$status);
	if(!$pre_action ->execute())
	{
	    echo"You failed to create a new playlist. Please try again"."<br/><br/>";
	    echo"<a href='myplaylist.php'>Go back</a>";
	}
	else
	{
	    echo"Thank you!You have created a new playlist successfully!"."<br/><br/>";
	    echo"<a href='myplaylist.php'>Go back</a>";
	}
	$pre_action ->free_result();
	$pre_action ->close();


}
?>	

