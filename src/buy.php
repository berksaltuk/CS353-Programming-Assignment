<?php
    include("config.php");
    session_start();

    function buy($mysqli)
    {   
        if( $_POST['buyAmt'] <= 0)
        {
            header("location: welcome.php?error=notposamount");
        }
        else{

        
        $pid = $_POST['pid'];
        $query1 = "SELECT * from product where pid='$pid'";
        $result1 = $mysqli->query($query1);

        $cid = $_SESSION['login_cid'];

        $query1 = "Select * from customer where cid='$cid'";
        $result2 = $mysqli->query($query1);
        $price = $_POST['price'];
        $amount = $_POST['buyAmt'];

        $tot = $amount*$price;

        if( $result1->num_rows == 1){

            $row = $result1->fetch_array(MYSQLI_NUM);
            if($row[3] < $_POST['stock'])
            {
                header("location: welcome.php?error=notenoughstock");
            }

            else
            {
                $row = $result2->fetch_array(MYSQLI_NUM);
                if($tot > $row[5]){
                    header("location: welcome.php?error=notenoughmoney");
                    
                }
                else
                {
                    
                    $query1 = "UPDATE customer set wallet=wallet-$tot where cid='$cid'";
                    $mysqli->query($query1);
                    
                    $query1 = "UPDATE product set stock=stock-$amount where pid='$pid'";
                    $mysqli->query($query1);

                    $query1 = "Select * from buy where pid='$pid' and cid='$cid'";
                    $result3 = $mysqli->query($query1);
                    if($result3->num_rows == 1)
                    {
                        $query1 = "UPDATE buy set quantity=quantity+$amount where pid='$pid' and cid='$cid'";
                        $mysqli->query($query1);
                    }
                    else
                    {
                        $query1 = "INSERT INTO buy (cid, pid, quantity) values ('$cid', '$pid', $amount)";
                        $mysqli->query($query1);
                    }
                    
                    header("location: welcome.php?error=none");  
                }
            }

        }
    }
        
    }

    if(isset($_POST['buy'])){;
        buy($mysqli);
    }
?>