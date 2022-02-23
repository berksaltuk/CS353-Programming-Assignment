<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="style.css">
    <title>Customer Login Page</title>
</head>
<body>

    <div class="container  d-flex justify-content-center align-items-center vh-100 w-75">
            <div class="text-center rounded-left col-sm-4 h-50 d-flex flex-column justify-content-center align-items-center" id="left">
                <h2 class="text-white">Welcome!</h1>  
                <div> <h2 class="badge badge-dark">Please login to start shopping.</h2> </div>
            </div>
            <div class="p-4  col-sm-8 h-50 d-flex justify-content-center align-items-center rounded-right" id="right">
                <div class="d-flex justify-content-center ">

                    <form method="POST" action="login.php" onsubmit="return validation()">
                    <p class="incorrect">Wrong Customer Name or ID!</p>
                        <div class="form-group row"> 
                            <label for="usernameField"  class="col-sm-5 col-form-label text-light font-weight-bold">Customer Name: </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control font-italic" id="usernameField" name="username" placeholder="Enter your username...">
                                <p class="nameCheck">*This field cannot be empty!</p>
                            </div>
                        </div>
                        <div class="form-group row"> 
                            <label for="cidField"  class="text-light col-sm-5 col-form-label font-weight-bold">Customer ID:</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control font-italic" id="cidField" name="cid" placeholder="Enter your customer id...">
                                <p class="nameCheck">*This field cannot be empty!</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <input class="btn btn-warning font-weight-bold" type="submit" name="LOGIN" value="LOGIN">
                        </div>  
                    </form>
                </div>
                
            </div>    
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        function validation(){
            let flag = true;
            const el = document.getElementsByClassName("nameCheck");
            if (document.getElementById('usernameField').value == "")
            {
                el[0].style.display = 'block';
                flag = false;
            }
            else
            {
                el[0].style.display = 'none';
            }
            if (document.getElementById('cidField').value == "")
            {
                el[1].style.display = 'block';
                flag = false;
            }
            else
            {
                el[1].style.display = 'none';
            }
            return flag;
        }
    </script>

</body>
</html>

<?php
    if(isset($_GET["error"]))
    {
        echo "<style>.incorrect{display: block !important;}</style>";
    }
?>