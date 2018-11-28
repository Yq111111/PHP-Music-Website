<?php
header("content-type:text/html;charset=utf-8");
//Connect to the database
$link = mysqli_connect("localhost:8889","root","root","project");
//$link = mysqli_connect("localhost:3306","root","yaoqisy884","project");
if (!$link) {
    die("Connect Fail: " . mysqli_connect_error());
}

$userid=htmlspecialchars($_POST['userid'],ENT_QUOTES);
$username=htmlspecialchars($_POST['username'],ENT_QUOTES);
$useremail=htmlspecialchars($_POST['useremail'],ENT_QUOTES);
$usercity=htmlspecialchars($_POST['usercity'],ENT_QUOTES);
$password=htmlspecialchars($_POST['password'],ENT_QUOTES);
$pwd_again=htmlspecialchars($_POST['pwd_again'],ENT_QUOTES);

if($username == "" || $password == "" || $pwd_again == "")
{
    echo "Please Check Your Information";
}else{
    if($password!=$pwd_again)
    {
        echo"The passwords are different! Please Check again"."<br/><br/>";
        echo"<a href='register.html'>Renter</a>";
    }
    else
    {
        $pre_sql = "insert into user(uid,uname,uemail,ucity,upassword) values(?,?,?,?,?)";
        $pre_action = $link ->prepare($pre_sql);
        $pre_action ->bind_param("sssss",$userid,$username,$useremail,$usercity,$password);
        /*$sql="insert into user(uid,uname,uemail,ucity,upassword) values('$userid','$username','$useremail','$usercity','$password')";
        $result=mysqli_query($link,$sql);*/
        if(!$pre_action ->execute())
        {
            echo"You failed to set up an account! Please Try again"."<br/><br/>";
            echo"<a href='register.html'>Go back</a>";
        }
        else
        {
            echo"You have set up an account successfully!"."<br/><br/>";
            echo"<a href='login.html'>Go back to log in</a>";
        }
        $pre_action ->free_result();
        $pre_action ->close();
    }
}
?>