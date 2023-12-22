<?php

@include '../connect.php';
$conn=$link;
session_start();



if(isset($_POST['update_return'])){
   $return_id = $_POST['return_id'];
   $update_status = $_POST['update_status'];
   mysqli_query($conn, "UPDATE `return` SET status = '$update_status' WHERE id = '$return_id'") or die('query failed');
   $message[] = 'return status has been updated!';
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

   <h1 class="title">placed return</h1>

   <div class="box-container">

   <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `return` ") or die('query failed');

            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
     
    

      
        

      

     
        // Get the current timestamp


    

        ?>
        <div class="box">
            
           
          
      
         <?php 
            ?>
            <p> rent id: <?php echo $fetch_orders['rent_id']; ?></span> </p>
          
            <form action="" method="post">
                <input type="hidden" name="return_id" value="<?php echo $fetch_orders['id']; ?>">
                <select name="update_status">
                    <option disabled selected><?php echo $fetch_orders['status']; ?></option>
                              <option value="pending">pending</option>
                                <option value="approved">approved</option><br>
                                <option value="cancel">cancel</option><br>
                </select>
                <input type="submit" name="update_return" value="update" class="option-btn">
            </form>
        </div>
<?php
    }
} else {
    echo '<p class="empty">no orders placed yet!</p>';
}
?>


   </div>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>