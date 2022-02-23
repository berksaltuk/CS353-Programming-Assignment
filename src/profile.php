<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Welcome <?php include("config.php"); session_start(); echo $_SESSION['login_user']; ?></title>
</head>
<body>
<div class="d-flex flex-column justify-content-center align-items-center vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark justify-content-between w-100">
        <a class="navbar-brand text-light" href="#"><?php echo $_SESSION['login_user']; ?>'s Profile Page</a>
        <a href="signout.php"><span class="material-icons md-light">logout</span></a>
    </nav>
    <div class="card text-center w-100 h-100 all">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a href="#" class="nav-link active" id="firstLink">Your Balance</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="secondLink">Your Purchases</a>
            </li>
            </ul>
        </div>
        <div class="card-body p-3">
            <div id="balanceDisplay" >
                <h5>Your Current Balance is</h5>
                <h3><?php 
                $cid = $_SESSION['login_cid'];
                $query = "Select wallet From customer where cid='$cid'";
                
                $result = $mysqli->query($query);

                while( $row = $result->fetch_array(MYSQLI_NUM))
                {
                    echo $row[0];
                }
            ?></h3>
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#topMoney">Top up some money</button>
            <div class="modal fade" id="topMoney" tabindex="-1" role="dialog" aria-labelledby="topMoneyLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="topMoneyLabel">Top Money to Your Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="addMoney.php">
                <div class="form-group col">
                    <div class="modal-body">
                        <label for="amountInput">Amount:</label>
                        <input class="form-control" id="amountInput" type="number" name="amount" placeholder="Enter the Amount">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-dark" name="add">Add Money</button>
                    </div>
                </div>
                </form>
                </div>
            </div>
            </div>
            
            </div>
            <div class="makeInvisible" id="purchaseDisplay">
                <h5>Your Purchases: </h5>
                <?php
                
                    
                    $query = "Select pid, pname, quantity From customer natural join buy natural join product
                              where cid = '".$_SESSION['login_cid']."'";
                    
                    $result = $mysqli->query($query);

                    echo "<table class='table'>
                    <thead class='thead-dark'>
                    <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Product ID</th>
                    <th scope='col'>Product Name</th>
                    <th scope='col'>Quantity</th>
                    </tr>
                    </thead>
                    <tbody>";
                    $rowNo = 1;

                    while( $row = $result->fetch_array(MYSQLI_NUM))
                    {
                        echo "<tr>
                        <th scope='row'>$rowNo</th>
                        <td>$row[0]</td>
                        <td>$row[1]</td>
                        <td>$row[2]</td>
                        </tr>";
                       $rowNo = $rowNo + 1;
                    }
                    echo "</tbody> </table>"
                ?>

                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#returnProduct">Return Products</button>
                <div class="modal fade" id="returnProduct" tabindex="-1" role="dialog" aria-labelledby="returnLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnLabel">Return Products by Giving ID and Quantity</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="return.php">
                        <div class="form-group col">
                            <div class="modal-body">
                         
                            <input class="form-control" id="productid" type="text" name="pid" placeholder="Product ID">

                            <input class="form-control" id="quantity" type="number" name="qty" placeholder="Quantity">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-dark" name="return">Return</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
        
        <?php
            if(isset($_GET["error"]))
            {
                if($_GET["error"] == 'nomatchingpid'){
                    echo "<div class='alert alert-danger' role='alert'>
                            There is no matching product id in your purchases!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>";
                }
                else if($_GET["error"] == 'notposquantity'){
                    echo "<div class='alert alert-danger' role='alert'>
                            You should give a positive quantity to return products!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>";
                }
                else if($_GET["error"] == 'morethanbought'){
                    echo "<div class='alert alert-danger' role='alert'>
                            You cannot return more products than you bought!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>";
                }
                else if($_GET["error"] == 'none'){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            Products are succsessfully returned!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>";
                }
            }
            
        ?> 

        <div class="bg-dark card-footer text-muted d-flex justify-content-center">
            <a href="welcome.php" class="btn btn-light">Main Page</a>
        </div>
    </div>
    </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
    document.getElementById("secondLink").addEventListener("click", display);
    document.getElementById("firstLink").addEventListener("click", display);

    function display(){
        document.getElementById("balanceDisplay").classList.toggle("makeInvisible");
        document.getElementById("purchaseDisplay").classList.toggle("makeInvisible");
        document.getElementById("firstLink").classList.toggle("active");
        document.getElementById("secondLink").classList.toggle("active");
    }
</script>
</body>
</html>