<?php
session_start();
include 'connect.php';
$conn=$link;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // $password = hash("sha256", $password);

    $sql = "SELECT * FROM customer WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

      
        $_SESSION["fullname"] = $row['fullname'];
        $_SESSION["user_id"] = $row['user_id'];
        $_SESSION["email"] = $row['email'];

        // Redirect to a generic page or home page after successful login
        header("location: index.php");
    } else {
        // Login unsuccessful
        echo "Invalid username or password.";
    }
}

// Close connection
mysqli_close($conn);

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
                    <span style="font-size:15px">Don't have account?</span><a href="./register.php" style="color:red; font-size: 15px"> Register</a>
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