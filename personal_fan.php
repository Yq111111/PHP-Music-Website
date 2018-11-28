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
//Connect to database
$link = mysqli_connect("localhost:8889","root","root","project");
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}
session_start();
$userid=htmlspecialchars($_GET['userid'],ENT_QUOTES);
$pre_sql = "select fan_name from follow where idol_name = ? ";//Pre operated.Set the query structure
$pre_action = $link ->prepare($pre_sql);
$pre_action ->bind_param("s",$userid);
$pre_action ->bind_result($get_fan_name);
$pre_action ->execute();
?>


<div class="container" id="search-result">
<h1> <?php echo "$userid"; ?>'s Followers</h1>
<hr class="m-y-md">
<ul class="list-group">

<?php


while($row=$pre_action ->fetch()){
    ?>
    <a href="user.php?uid=<?php echo $get_fan_name; ?>">
    <li class="list-group-item">
    	<?php echo "$get_fan_name<br>"; ?>
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