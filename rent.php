

<?php
session_start();


$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};
include 'connect.php';
$conn=$link;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloth Rental</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <link rel="stylesheet" href="css/admin_style.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
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
                        <a href="rent.php">rent</a>
                    </li>
                    <li>
                        <a href="clothes.php">All Clothes</a>
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
        <!-- /.container -->
    </nav>


<section class="placed-orders">

   <h1 class="title">placed orders</h1>

   <div class="box-container">

   <?php



   
 

$select_orders = mysqli_query($conn, "SELECT rent.*, customer.fullname, customer.email 
                                     FROM `rent` 
                                     JOIN customer ON rent.user_id = customer.user_id 
                                     WHERE rent.user_id = '$user_id'") or die('query failed');

if (mysqli_num_rows($select_orders) > 0) {
    while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
        $rent_date = strtotime($fetch_orders['rent_date']);
        $return_date = strtotime($fetch_orders['return_date']);
        $days_rented = ($return_date - $rent_date) / (60 * 60 * 24); // Calculate the number of days rented

        $current_date = date('Y-m-d');
    

      
        

      

     
        // Get the current timestamp

        // Calculate the rental price based on the number of days rented (assuming 100 rs per day)
        $rental_price = $fetch_orders['rental_price']; // Initialize with the default rental_price from the database

        // If the status is 'pending' and today's date is greater than the return_date, update the rental_price
    

        ?>
        <div class="box">
            <p> user id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
            <p> fullname : <span><?php echo $fetch_orders['fullname']; ?></span> </p>
            <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
            <p> payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
            <p> rent date : <span><?php echo $fetch_orders['rent_date']; ?></span> </p>
            <p> return date : <span><?php echo $fetch_orders['return_date']; ?></span> </p>

            <p> rental days : <span><?php echo $days_rented; ?> day(s)</span> </p>
            <?php
            if ($fetch_orders['payment_status'] === 'pending' && $current_date > $return_date) {
            $days_overdue = ($current_date - $return_date) / (60 * 60 * 24); // Calculate the number of overdue days
            $additional_price = $days_overdue * 100000000; // Calculate the additional price for overdue days
            $rental_price += $additional_price; // Update the rental_price with the additional_price
      
        ?>
            <p> rental price : <span>$<?php echo  $rental_price += $additional_price; ?>/-</span> with charge </p>
         <?php } else {
            ?>
            <p> rental price : <span>$<?php echo  $rental_price ?>/-</span> </p>
            <?php
         }
         ?>
           
        </div>
<?php
    }
} else {
    echo '<p class="empty">no orders placed yet!</p>';
}


?>



   </div>

</section>
