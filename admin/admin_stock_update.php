<?php



session_start();

@include '../connect.php';
$conn=$link;


if (isset($_POST['update_product'])) {


   // Update stock in the 'stock' table based on stock ID
   $stock_id = $_POST['stock_id'];
   $stock_value = mysqli_real_escape_string($conn, $_POST['stock']);

   mysqli_query($conn, "UPDATE `stock` SET stock = '$stock_value' WHERE id = '$stock_id'") or die('query failed');

   $message[] = 'stock updated successfully!';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="update-product">

<?php

   $update_id = $_GET['cloth'];
   $select_products = mysqli_query($conn, "SELECT * FROM `stock` WHERE cloth_id = '$update_id'") or die('query failed');
   if(mysqli_num_rows($select_products) > 0){
      while($fetch_products = mysqli_fetch_assoc($select_products)){
?>

<form action="" method="post" enctype="multipart/form-data">

   <input type="hidden" value="<?php echo $fetch_products['id']; ?>" name="stock_id">

   <h3><?php echo $fetch_products['size']; ?> </h3>

   
   <input type="number" min="0" class="box" value="<?php echo $fetch_products['stock']; ?>" required placeholder="update product stock" name="stock">
 
   <input type="submit" value="update stock" name="update_product" class="btn">
   <a href="admin_cloth.php" class="option-btn">go back</a>
</form>

<?php
      }
   }else{
      echo '<p class="empty">no update product select</p>';
   }
?>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>