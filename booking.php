<?php
session_start();

include 'connect.php';
$conn=$link;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:index.php');
};

if(($_SESSION['email']) && !empty($_GET['id'])) {


    $email = $_SESSION['email'];
    $query = "SELECT user_id FROM customer WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
       $row = mysqli_fetch_assoc($result);
       $user_id = $row['user_id'];
   
 
?>


<!DOCTYPE html>
<html>
<title>Cloth Rental</title>
<head>
    <script type="text/javascript" src="assets/ajs/angular.min.js"> </script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
  <script type="text/javascript" src="assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>  
  <script type="text/javascript" src="assets/js/custom.js"></script> 
 <link rel="stylesheet" type="text/css" media="screen" href="assets/css/clientpage.css" />
</head>
<body> 

<nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="index.php">
                   Cloth Rental </a>
            </div>
           <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="mybookings.php">booking</a>
                    </li>
                    <?php
                    if(isset($_SESSION['email'])){ ?>
                        <li>
                        <a href=""></span><?php echo $_SESSION['email'] ?></a>
                        </li>
                        <li>
                        <a href="logout.php">Logout <span class="glyphicon glyphicon-log-out"></span></a>
                        </li>
                        <?php } else { ?>
                            <li>
                                <a href="./login.php"></span>Login</a>
                            </li>
                    <?php } ?>
                    <ul class="nav navbar-nav">
                <ul class="dropdown-menu">
            </ul>
            </li>
          </ul>
                </ul>
            </div>
        </div>
    </nav>
    <style>
   
    .message {
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        background-color: #f2f2f2;
        color: #333;
    }

    .success-message {
        background-color: #4CAF50;
        color: white;
    }

    .error-message {
        background-color: #f44336;
        color: white;
    }
</style>

    </style>

 <?php
if (isset($_POST['submit'])) {
    $user_id = $row['user_id'];
    $cloth_id = $_POST['cloth_id'];
    $size_id = $_POST['size_id'];
    $rent_date = $_POST['rent_date'];
    $return_date = $_POST['return_date'];
    $cloth_quantity = $_POST['cloth_quantity'];

    // You need to get the values for rental_price, method, and payment_status from your form or other sources.
    $rental_price = $_POST['rental_price'];
  

    // Assuming $conn is your database connection.
    $query = "INSERT INTO `rent` (user_id, cloth_id, size_id, rent_date, return_date, rental_price, method, payment_status, cloth_quantity)
              VALUES ('$user_id', '$cloth_id', '$size_id', '$rent_date', '$return_date', '$rental_price', 'cash', 'pending', '$cloth_quantity')";

    // Execute the INSERT query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Calculate the new stock quantity after booking
        $query = "SELECT stock FROM stock WHERE cloth_id = '$cloth_id' AND size_id = '$size_id'";
        $stock_result = mysqli_query($conn, $query);
        
        if ($stock_result && mysqli_num_rows($stock_result) > 0) {
            $row = mysqli_fetch_assoc($stock_result);
            $current_stock = $row['stock'];
            
            if ($current_stock >= $cloth_quantity) {
                // Update the stock
                $new_stock = $current_stock - $cloth_quantity;
                mysqli_query($conn, "UPDATE stock SET stock = '$new_stock' WHERE cloth_id = '$cloth_id' AND size_id = '$size_id'");
                
                $message[] = 'Cloth booked!';

                // Optionally, you can also commit the changes to the database.
                mysqli_commit($conn);
            } else {
                $message[] = 'Not enough stock for this item.';
            }
        } else {
            $message[] = 'Error fetching stock data.';
        }
    } else {
        $message[] = 'Error inserting data into the database.';
    }
}

 
// After your code for inserting data into the database

// Check if the $message array is not empty
// After your code for inserting data into the database

// Check if the $message array is not empty
if (!empty($message)) {
    // Output the messages to the user with appropriate CSS classes
    foreach ($message as $msg) {
        // Determine the CSS class based on the type of message (success or error)
        $cssClass = (strpos($msg, 'Error') !== false) ? 'error-message' : 'success-message';
        
        echo '<div class="message ' . $cssClass . '">' . $msg . '</div>';
    }
}




    $cloth_id = $_GET['id'];

    $sql = "SELECT * FROM clothes WHERE cloth_id = $cloth_id";
    $run = mysqli_query($link, $sql);
    $count = mysqli_num_rows($run);
    $row = mysqli_fetch_assoc($run);
    ?>

<div class="container" style="margin-top: 65px;" >
    <div class="col-md-7" style="float: none; margin: 0 auto;">
      <div class="form-area">

            <form role="form" action="" method="POST">
            <br style="clear: both">
            <br>
            <img style="width: 100px; height: 120px; margin-left: 200px;" src="./uploaded_img/<?php echo $row['image'] ?>" alt="">
            <br><br>
            <h5> Selected Cloth: <b><?php echo $row['name'] ?></b></h5>
            <h5>Rented Price (Per Day): <b><?php echo $row['price'] ?></b></h5>
            <label><h5>Rent Date:</h5></label>
            <input type="date" name="rent_date" min="<?php echo date('Y-m-d'); ?>" required="">
            &nbsp;
            <label><h5>Return Date:</h5></label>
            <input type="date" name="return_date" min="<?php echo date('Y-m-d'); ?>" required="">

            <?php
                $cloth_id = $_GET['id']; // Assuming you get the cloth_id from the URL parameters

                $select_category = mysqli_query($conn, "SELECT * FROM `stock` WHERE cloth_id ='$cloth_id'") or die('query failed');
                if (mysqli_num_rows($select_category) > 0) {
                    while ($fetch_category = mysqli_fetch_assoc($select_category)) {
                        $size_id = $fetch_category['size_id'];
                        

                        $select_categor = mysqli_query($conn, "SELECT * FROM `size` WHERE id ='$size_id'") or die('query failed');
                        if (mysqli_num_rows($select_categor) > 0) {
                            while ($fetch_categor = mysqli_fetch_assoc($select_categor)) {
                                ?>
                                <h5>Choose your Cloth Size: &nbsp;
                                    <input type="radio" name="size_id" value="<?php echo $fetch_categor['id']; ?>" ng-model="myVar">
                                    <b><?php echo $fetch_categor['name']; ?></b>&nbsp;
                                </h5>
                                <?php
                            }
                        }
                    }
                } else {
                    echo '<p class="empty">No sizes added yet!</p>';
                }
                ?>

            <input type="number" min="1" name="cloth_quantity" value="1" class="qty">
            <input type="hidden" name="cloth_id" value="<?php echo $row['cloth_id'] ?>">
            <input type="hidden" name="rental_price" value="<?php echo $row['price'] ?>">
            <br>
            <input type="submit" name="submit" value="Book Now" class="btn btn-warning pull-right">
        </form>

        
      </div>
      <div class="col-md-12" style="float: none; margin: 0 auto; text-align: center;">
            <h6><strong>Note:</strong> You will be charged with extra <span class="text-danger">Rs. 100</span> for each day after the due date ends.</h6>
        </div>
    </div>

</body>
<footer class="site-footer">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <h5>© 2023 Cloth Rental</h5>
                </div>
            </div>
        </div>
    </footer>
</html>
<?php
 } else {
    // handle error if user_id cannot be retrieved
    // you can redirect to an error page or show an error message
    exit('Error retrieving user_id');
 }
} else {
    header("location: index.php");
}
?>