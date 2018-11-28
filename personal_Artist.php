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
$userid=htmlspecialchars($_GET['userid'],ENT_QUOTES);
$pre_sql = "select aid, aname  from user_like_artist natural join artist where uid = ? ";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$userid);
$pre_action ->bind_result($get_aid,$get_aname);
$pre_action ->execute();

?>


<div class="container" id="search-result">
<h1> <?php echo "$userid"; ?>'s Favorite Artists</h1>
<hr class="m-y-md">
<ul class="list-group">

<?php


while($row=$pre_action ->fetch()){
    ?>
    <a href="artist.php?aid=<?php echo $get_aid; ?>">
    <li class="list-group-item">
    	<?php echo "$get_aname<br>"; ?>
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

