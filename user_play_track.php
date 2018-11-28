<!DOCTYPE html>
<html>
<head>
  <title>index page</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="user_play_track.css">
</head>
<body>


<?php include("navbar.php"); ?>

<div class="site-wrapper">
    <img class="img-circle" style="width: 500px; height: 500px;" src="img/example.jpg">
      <div class="site-wrapper-inner">

        <div class="cover-container">



          <main role="main" class="inner cover">
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
$tid=htmlspecialchars($_GET['tid'],ENT_QUOTES);
$time=date('Y-m-d H:i:s');


$pre_sql = "insert into user_play_track(uid,tid,time) values(?,?,?)";
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("sss",$userid,$tid,$time);
if(!$pre_action ->execute())
{
    echo"You failed to play this song!"."<br/><br/>";
    echo"<a href='index.html'>Go back</a>";
}
else
{
	//单曲详情
	$pre_sql = "select ttitle,aname,aid, tduration, tgenre from track natural join artist where tid = ?";//Pre operated.Set the query structure
	$pre_action = $link ->prepare($pre_sql);
	$pre_action ->bind_param("s",$tid);
	$pre_action ->bind_result($get_ttitle,$get_aname,$get_aid,$get_tduration,$get_tgenre);
	$pre_action ->execute();
	while($row=$pre_action ->fetch()){
		$min=floor($get_tduration/60);
		$sec=$get_tduration%60;
	?>
            <h1 class="cover-heading"><?php echo "$get_ttitle"; ?> <?php echo "("."$min".":"."$sec".")"; ?></h1>
            <h2 class="lead">Artist: <?php echo "$get_aname"; ?></h2>
            <p class="lead">Genre: <?php echo "$get_tgenre"; ?></p>
            <p class="lead">
              <a href="track.php?tid=<?php echo "$tid"; ?>" class="btn btn-lg btn-secondary">Back</a>
              <?php } ?>
            </p>
          </main>
        </div>
      </div>
    </div>
  <?php 
}
  
$pre_action ->free_result();
$pre_action ->close();

?>
    </body>
</html>










<?php
/*
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
$tid=htmlspecialchars($_GET['tid'],ENT_QUOTES);
$time=date('Y-m-d H:i:s');

//单曲详情
$pre_sql = "select ttitle,aname,aid, tduration, tgenre from track natural join artist where tid = ?";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$tid);
$pre_action ->bind_result($get_ttitle,$get_aname,$get_aid,$get_tduration,$get_tgenre);
$pre_action ->execute();
while($row=$pre_action ->fetch()){
	//lll
    echo "$get_ttitle---$get_aname---$get_tduration---$get_tgenre";
}

//保存记录
$pre_sql = "insert into user_play_track(uid,tid,time) values(?,?,?)";
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("sss",$userid,$tid,$time);
if(!$pre_action ->execute())
{
    echo"You failed to play this song! You had rated before"."<br/><br/>";
    echo"<a href='track.php?tid=$tid'>Go back</a>";
}
else
{
    echo"Thank you!You have played this song successfully!"."<br/><br/>";
    echo"<a href='track.php?tid=$tid'>Go back</a>";
}

$pre_action ->free_result();
$pre_action ->close();
*/
?>