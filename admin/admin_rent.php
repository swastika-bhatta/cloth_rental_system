<?php

@include '../connect.php';
$conn=$link;
session_start();



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
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="placed-orders">

<input class="form-control hero" type="search" id="search-input" name="search_box" placeholder="Search" aria-label="Search" style="display: flex;justify-content: center;font-size: x-large;text-align: center;padding-left: 9%;">
   <h1 class="title">placed orders</h1>


   <div class="box-container">


   <?php
            $select_orders = mysqli_query($conn, "SELECT rent.*, rent.rent_id,customer.fullname, customer.email FROM `rent` JOIN customer ON rent.user_id = customer.user_id") or die('query failed');

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
    <form action="" method="post" class="div-element">
     <div class="box div-element">
        <p> rent id : <span><?php echo $fetch_orders['rent_id']; ?></span> </p>
            <p> user id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
            <p> fullname : <span><?php echo $fetch_orders['fullname']; ?></span> </p>
            <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
            <p> payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
            <p> rent date : <span><?php echo $fetch_orders['rent_date']; ?></span> </p>
            <p> return date : <span><?php echo $fetch_orders['return_date']; ?></span> </p>

            <p> rental days : <span><?php echo $days_rented; ?> day(s)</span> </p>
        
      
         <?php 
            ?>
            <p> rental price  with date : <span>RS<?php echo  $rental_price * $days_rented;  ?>/-</span> </p>
          
            <form action="" method="post" >
                <input type="hidden" name="order_id" value="<?php echo $fetch_orders['rent_id']; ?>">
                <select name="update_payment">
                    <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
                    <br>
                    <option value="pending">pending</option>
                    <option value="completed">completed</option>
                </select>
                <input type="submit" name="update_order" value="update" class="option-btn">
                <a href="admin_orders.php?delete=<?php echo $fetch_orders['rent_id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
            </form>
        </div>
        <?php
            }
        } else {
            echo '<p class="empty">no orders placed yet!</p>';
        }
        ?>
     </div>

  </form>

</section>













<script src="js/admin_script.js"></script>
<script>
    // Search functionality
    const searchInput = document.getElementById('search-input');
  const divElements = document.querySelectorAll('.div-element');

  searchInput.addEventListener('input', function () {
    const query = searchInput.value.toLowerCase();

    divElements.forEach(function (divElement) {
      const textContent = divElement.textContent.toLowerCase();

      if (textContent.includes(query)) {
        divElement.style.display = 'block';
      } else {
        divElement.style.display = 'none';
      }
    });
  });

 
 
    // Price Range Filter functionality
    function filterNumbers() {
        let rangeInput = document.getElementById("rangeInput").value;
        let range = rangeInput.split("-");
        let min = parseInt(range[0]);
        let max = parseInt(range[1]);
        let numberList = document.getElementById("numberList");
        let numbers = numberList.getElementsByClassName("number");
        for (let i = 0; i < numbers.length; i++) {
            let number = parseInt(numbers[i].innerText);
            if (number >= min && number <= max) {
                numbers[i].style.display = "inline-block";
            } else {
                numbers[i].style.display = "none";
            }
        }
    }
</script>

</body>
</html>