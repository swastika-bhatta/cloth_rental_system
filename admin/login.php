<?php
session_start();
include '../connect.php';

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($email == '' || $password == '') {
        echo '<div class="alert-message">
                Fill All The Fields
                <span class="close-button">&times;</span>
              </div>';
    } else {
        $sql = 'SELECT * FROM admin WHERE email="' . $email . '" AND password="' . $password . '"';
        
        $result = mysqli_query($link, $sql);
        $noOfData = mysqli_num_rows($result);

        if ($noOfData > 0) {
            // Login successful, fetch user_id from the query result
            $row = mysqli_fetch_assoc($result);
            $admin_id = $row['admin_id'];
            $username = $row['username'];

            // Store user_id and email in session variables
            $_SESSION['admin_email'] = $email;
            $_SESSION['admin_name'] = $username;
            $_SESSION['admin_id'] = $admin_id;
            
            header('Location: index.php');
            exit(); // Always use exit() after header() to prevent further execution of the script
        } else {
            echo '<div class="alert-message">
                    Email or Password Not Valid
                    <span class="close-button">&times;</span>
                  </div>';
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
                <h3>Login</h3>
            </div>
            <br>
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control"  placeholder="Password">
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                    <div class="reg">
                    <br>
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