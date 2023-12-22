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
if (isset($_POST['Return_Product'])) {
    // Handle the form submission
    $rent_id = $_POST['rent_id'];
 
 
    // Insert the return information into the return table
    $sql = "INSERT INTO `return` (rent_id) VALUES ('$rent_id')";
 
    if ($conn->query($sql) === TRUE) {
       $message[] = 'Product returned request send!';
     
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
 }
if(isset($message)){
    foreach($message as $message){
      echo '
      <div class="message">
          <span>'.$message.'</span>
          <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
    }

// if(($_SESSION['email']) && !empty($_GET['id'])) {


//     $email = $_SESSION['email'];
//     $query = "SELECT user_id FROM customer WHERE email = '$email'";
//     $result = mysqli_query($conn, $query);
//     if ($result && mysqli_num_rows($result) > 0) {
//        $row = mysqli_fetch_assoc($result);
//        $user_id = $row['user_id'];
   
 
 
?>


<div class="container">
      <div class="jumbotron">
        <p class="text-center">Your Bookings</p>
      </div>
    </div>

<?


if(isset($_POST['update_order'])){
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `rent` SET payment_status = '$update_payment' WHERE rent_id = '$order_id'") or die('query failed');
   $message[] = 'payment status has been updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `rent` WHERE rent_id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}


 

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
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- custom admin css file link  -->
<link rel="stylesheet" href="css/admin_style.css">
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

   


    <section class="placed-orders">

<h1 class="title">Placed Orders</h1>

<div class="box-container">

     <?php
     $select_orders_query = mysqli_query($conn, "SELECT * FROM `rent` WHERE user_id = '$user_id' ") or die(mysqli_error($conn));

     if (mysqli_num_rows($select_orders_query) > 0) {
         while ($fetch_orders = mysqli_fetch_assoc($select_orders_query)) {
             $rent_id = $fetch_orders['rent_id'];
             $rent_date = strtotime($fetch_orders['rent_date']);
             $return_date = strtotime($fetch_orders['return_date']);
             $days_rented = ($return_date - $rent_date) / (60 * 60 * 24); // Calculate the number of days rented

             $current_date = date('Y-m-d');

             $select_customer = mysqli_query($conn, "SELECT * FROM `customer` WHERE user_id = '$user_id'") or die(mysqli_error($conn));

             if (mysqli_num_rows($select_customer) > 0) {
                 $fetch_customer = mysqli_fetch_assoc($select_customer);

                 // Get the current timestamp

                 // Calculate the rental price based on the number of days rented (assuming 100 rs per day)
                 $rental_price = $fetch_orders['rental_price']; // Initialize with the default rental_price from the database

                 // If the status is 'pending' and today's date is greater than the return_date, update the rental_price

                 ?>
                 <div class="box">
                     <p> Full Name: <span><?php echo $fetch_customer['fullname']; ?></span> </p>
                     <p> Email: <span><?php echo $fetch_customer['email']; ?></span> </p>
                     <p> Payment Method: <span><?php echo $fetch_orders['method']; ?></span> </p>
                     <p> Rent Date: <span><?php echo $fetch_orders['rent_date']; ?></span> </p>
                     <p> Return Date: <span><?php echo $fetch_orders['return_date']; ?></span> </p>
                     <p> Rental Days: <span><?php echo $days_rented; ?> day(s)</span> </p>
                     <p> Rental Price with Date: <span>Rs<?php echo $rental_price * $days_rented; ?>/-</span> </p>

                     <?php
                     $select_return = mysqli_query($conn, "SELECT * FROM `return` WHERE rent_id = '$rent_id'") or die('query failed');

                     if (mysqli_num_rows($select_return) > 0) {
                         $fetch_return = mysqli_fetch_assoc($select_return);
                         $returnStatus = $fetch_return['status'];

                         if ($returnStatus == 'approved') {
                             echo "Your return request has been approved. We will contact you soon.";
                         } elseif ($returnStatus == 'cancelled') {
                             echo "Sorry, your return request has been cancelled. You can't return this order.";
                         } else {
                             // Handle other statuses as needed
                             echo "Your return request is pending.";
                         }
                     } else {
                         // Display a form for users to submit a return
                         ?>
                         <form action="" method="post">
                             <input type="hidden" name="rent_id" value="<?php echo $rent_id; ?>">
                             <input type="submit" class="btn btn-danger btn-outline-light my-2 my-sm-0" name="Return_Product" value="Return Product">
                         </form>
                         <?php
                     }
                     ?>
                 </div>
                 <?php
             }
         }
     } else {
         echo '<p class="empty">No orders placed yet!</p>';
     }
     ?>

</div>

</section>





