<?php
session_start();
session_destroy(); //清空以创建的所有SESSION
setcookie(session_name(),'',time()-1);
$_SESSION = array();

echo "Log out Successfully! Heading to First Page in 2 Seconds!";
header("refresh:2;url=./index.html");
echo"<a href='index.html'>Go back</a>";
?>