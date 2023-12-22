<?php
session_start();

include 'connect.php';

$name = '';
$email = '';
$phone = '';
$password = '';
$address = '';
$error = '';
$date = '';

if(isset($_POST["register"])){
    $fullname = $_POST["fullname"];
    $email =$_POST["email"];
    $password = $_POST["password"];
    $cpassword =$_POST["cpassword"];

    $select = mysqli_query($link, "SELECT * FROM `customer` WHERE email ='$email'") or die('query failed');

    $register_date = date("Y-m-d");

    if($name=='' & $email=='' & $phone==''& $password=='' & $address=='' & $date==''){
        echo '<div class="alert-message">
        Fill All The Fields
        <span class="close-button">&times;</span>
      </div>      
      ';
    }
    else {
        if(mysqli_num_rows($select) > 0){
            echo '<div class="alert-message"><div class="alert-message">
            user already registered
            <span class="close-button">&times;</span>
          </div>
          </div>';
          }
          if(filter_var($email,FILTER_VALIDATE_EMAIL)==true){
            if(strlen($password)>=8 ){
                $sql = 'INSERT INTO customer (fullname, email, password, register_date) VALUES("'.$fullname.'", "'.$email.'", "'.$password.'", "'.$register_date.'")';
                $_SESSION['fullname'] = $fullname;
                $_SESSION['email'] = $email;
                $resultInsert = mysqli_query($link, $sql);
        
                $sql = 'select user_id from customer where email="'.$email.'"';
                $result = mysqli_query($link, $sql);
                $row = mysqli_fetch_assoc($result);
                $_SESSION['user_id'] = $row['user_id'];
                header('Location: ./index.php');
          }
                else{
                    echo '<div class="alert-message">
                    Password Must be of 8 Character
                    <span class="close-button">&times;</span>
                  </div>
                  ';
                }
        }
        else{
            echo '<div class="alert-message">
            Email Address is Not Valid
            <span class="close-button">&times;</span>
          </div>
          ';
        }
    }    
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cloth Rental</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>

<body id="LoginForm">
<div class="container">
    <div class="login-form">
        <div class="main-div">
            <div class="panel">
                <h3>Register</h3>
            </div>
            <br>
                <form method="POST">
                    <div class="form-group">
                        <input type="text" name="fullname" class="form-control" placeholder="Enter FullName">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control"  placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                        <input type="password" name="cpassword" class="form-control"  placeholder="Confirm Password">
                    </div>
                    <button type="submit" name="register" class="btn btn-primary">Register</button>
                    <div class="reg">
                    <br>
                    <span style="font-size:15px">want to login?</span><a href="./login.php" style="color:red; font-size: 15px"> Login</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
  const closeButton = document.querySelector(".close-button");
  const alertMessage = document.querySelector(".alert-message");

  closeButton.addEventListener("click", function() {
    alertMessage.style.display = "none";
  });
});

</script>
</body>
</html>