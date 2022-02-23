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
<div class="vh-100 d-flex flex-column justify-content-center align-items-center">
<nav class="navbar navbar-expand-lg navbar-light bg-dark justify-content-between w-100">
    <a class="navbar-brand text-light mr-auto" href="#">Shopping Application</a>
    <span class="text-light mr-3">Balance: 
        <?php 
            $cid = $_SESSION['login_cid'];
            $query = "Select wallet From customer where cid='$cid'";
              
            $result = $mysqli->query($query);

            while( $row = $result->fetch_array(MYSQLI_NUM))
            {
                echo $row[0];
            }
        ?>
    </span>
    <a href="signout.php"><span class="material-icons md-light mt-1">logout</span></a>
</nav>

<div class="card text-center w-100 h-100 all">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a href="#" class="nav-link active" id="firstLink">Products Available</a>
            </li>
        </div>
        <div class="card-body p-3">
            <div class="justify-content-between">
                <?php

                    $query = "Select pid, pname, Price, stock From product
                              where stock>0";
                    
                    $result = $mysqli->query($query);

                    echo "<table class='table'>
                    <thead class='thead-dark'>
                    <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Product ID</th>
                    <th scope='col'>Product Name</th>
                    <th scope='col'>Price</th>
                    <th scope='col'>Amount</th>
                    <th scope='col'>Buy</th>
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
                        <form method='POST' action='buy.php' class='form-inline'>
                            <td>
                            <input class='form-control' id='amountInput' type='number' name='buyAmt' placeholder='1'>
                            <input type='hidden' name='pid' value='$row[0]'>
                            <input type='hidden' name='price' value='$row[2]'>
                            <input type='hidden' name='stock' value='$row[3]'>
                            </td>
                            <td><button type='submit' name='buy' class='btn'><span class='material-icons'>shopping_cart</span></button></td>
                        </form>
                        </tr>";
                       $rowNo = $rowNo + 1;
                    }
                    echo "</tbody> </table>";
                ?>
            </div>
            
        </div>
        <?php
            if(isset($_GET["error"]))
            {
                if($_GET["error"] == 'notenoughmoney'){
                    echo "<div class='alert alert-danger' role='alert'>
                            You do not have enough money in your wallet!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>";
                }
                else if($_GET["error"] == 'notposamount'){
                    echo "<div class='alert alert-danger' role='alert'>
                            You should give a positive amount to buy product!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>";
                }
                else if($_GET["error"] == 'notenoughstock'){
                    echo "<div class='alert alert-danger' role='alert'>
                            This product does not have that much stock!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>";
                }
                else if($_GET["error"] == 'none'){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            Products are succsessfully bought!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>";
                }
            }
            
        ?>  
        <div class="bg-dark card-footer text-muted d-flex justify-content-center w-100">
            <a href="profile.php" class="btn btn-light">My Profile</a>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>

