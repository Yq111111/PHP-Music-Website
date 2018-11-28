<?php
header("content-type:text/html;charset=utf-8");
//Connect to database
$link = mysqli_connect("localhost:8889","root","root","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}
session_start();
$username=htmlspecialchars($_POST['username'],ENT_QUOTES);
$userpassword=htmlspecialchars($_POST['password'],ENT_QUOTES);
$_SESSION['username']=$username;
if(isset($_POST)){
    //You must enter a valid username
    if(!$_POST['username']){
        echo('You must enter a valid username');
        return;
    }
    //You must enter a valid password
    if(!$_POST['password']){
        echo('You must enter a valid password');
        return;
    }
    $pre_sql = "select uid,upassword from user where uid = BINARY ? and upassword = BINARY ? ";//Pre operated.Set the query structure
    $pre_action = $link ->prepare($pre_sql);
    $pre_action ->bind_param("ss",$username,$userpassword);
    $pre_action ->bind_result($get_username,$get_userpassword);
    $pre_action ->execute();
    $row=$pre_action ->fetch();
   /* $sql="select uid,upassword from user where uid = '{$_POST['username']}' and upassword='{$_POST['password']}'";
    $rs=mysqli_query($link,$sql); //get the result from the database
    $row=mysqli_fetch_assoc($rs);*/
    if($row) { // Ver pass；
        if ($username == $get_username && $userpassword == $get_userpassword) { //Verify the identification with ID&Password
            echo "Log in Successfully! Heading to your home page in 2 Seconds!";
            header("refresh:2;url=/homepage.php");
            echo"<a href='homepage.php'>homepage</a>";
        }
    }else{
        echo "Invalid User name or password. Please Check it again" . "<br/>";
        echo "<a href='login.html'>Return the Login Page</a>";
    }
    $pre_action ->free_result();
    $pre_action ->close();
}
?>