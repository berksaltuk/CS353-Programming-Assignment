<?php
    include("config.php");
    session_start();

    function addMoney($mysqli)
    {
        $cid = $_SESSION['login_cid'];
        $amount = $_POST['amount'];
        $query = "UPDATE customer set wallet=wallet+$amount where cid='$cid'";

        $mysqli->query($query);
        
        header("location: profile.php");  
    
    }

    if(isset($_POST['add'])){;
        addMoney($mysqli);
    }
?>