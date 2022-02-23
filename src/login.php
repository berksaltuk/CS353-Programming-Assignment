<?php
include("config.php");
session_start();

function login($mysqli)
{
   $customername = $_POST['username'];
   $cid = $_POST['cid'];
   $query = "select * from customer where cname='$customername' and cid='$cid'";

   if( $result = $mysqli->query($query))
   {
       if( $result->num_rows == 1)
       {
           $_SESSION['login_user'] = $customername;
           $_SESSION['login_cid'] = $cid;
           header("location: welcome.php");
       }
       else
       {
           header("location: index.php?error=credentialsdontmatch");
           exit();
       }
   }
   else
   {
      header("location: index.php?error=credentialsdontmatch");  
      exit();
   }
}
if(isset($_POST['LOGIN'])){
    echo "Successful login";
    login($mysqli);
}
?>