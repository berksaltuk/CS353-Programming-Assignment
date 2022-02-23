<?php
    include("config.php");
    session_start();

    function returnProduct($mysqli)
    {   
        if( $_POST['qty'] <= 0)
        {
            header("location: profile.php?error=notposquantity");
        }
        else{

        
        $pid = $_POST['pid'];
        $cid = $_SESSION['login_cid'];
        $quantity = $_POST['qty'];

        $query1 = "Select * from buy where cid='$cid' and pid='$pid'";
        $result1 = $mysqli->query($query1);

        if( $result1->num_rows == 1){

            $row = $result1->fetch_array(MYSQLI_NUM);

            if($row[2] < $quantity)
            {
                header("location: profile.php?error=morethanbought");
            }

            else
            {
                    $query1 = "update buy set quantity=quantity-$quantity where cid='$cid' and pid='$pid'";
                    $mysqli->query($query1);
                    
                    $query1 = "select * from product where pid='$pid'";
                    $result2 = $mysqli->query($query1);
                    $row2 = $result2->fetch_array(MYSQLI_NUM);
                    
                    $query1 = "update product set stock=stock+$quantity where pid='$pid'";
                    $mysqli->query($query1);

                    $tot = $row2[2] * $quantity;

                    $query1 = "update customer set wallet=wallet+$tot where cid='$cid'";
                    $mysqli->query($query1);

                    $query1 = "Select * from buy where cid='$cid' and pid='$pid'";
                    $result1 = $mysqli->query($query1);
                    $row = $result1->fetch_array(MYSQLI_NUM);

                    if($row[2] == 0)
                    {
                        $query1 = "delete from buy where cid='$cid' and pid='$pid'";
                        $mysqli->query($query1);
                    }
                    header("location: profile.php?error=none");  
                
            }

        }
        else{
            header("location: profile.php?error=nomatchingpid");
        }
    }
        
    }

    if(isset($_POST['return'])){;
        returnProduct($mysqli);
    }
?>