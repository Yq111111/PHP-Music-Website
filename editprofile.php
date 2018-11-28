<?php
header("content-type:text/html;charset=utf-8");
//Connect to the database
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
$link = mysqli_connect("localhost:8889","root","root","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}
session_start();
$userid=$_SESSION['username'];
$username=htmlspecialchars($_POST['username'],ENT_QUOTES);
$useremail=htmlspecialchars($_POST['useremail'],ENT_QUOTES);
$usercity=htmlspecialchars($_POST['usercity'],ENT_QUOTES);

        $pre_sql = "update user set uname=?,uemail=?,ucity=? Where uid=?";
        $pre_action = $link ->prepare($pre_sql);
        $pre_action ->bind_param("ssss",$username,$useremail,$usercity,$userid);
        if(!$pre_action ->execute())
        {
            echo"You failed to update your information! Please Try again"."<br/><br/>";
            echo"<a href='register.html'>Go back</a>";
        }
        else
        {
            echo"You have update your account information successfully!"."<br/><br/>";
            echo"<a href='login.html'>Go back to log in</a>";
        }
        $pre_action ->free_result();
        $pre_action ->close();

?>