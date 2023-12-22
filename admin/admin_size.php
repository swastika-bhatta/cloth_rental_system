<?php

@include '../connect.php';
$conn=$link;
session_start();

if(isset($_POST['add_product'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
 
   $select_product_name = mysqli_query($conn, "SELECT name FROM `size` WHERE name = '$name'") or die(mysqli_error($conn));

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'size name already exists!';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `size` (name) VALUES ('$name')")  or die(mysqli_error($conn));

      if($insert_product){
         
         }
            $message[] = 'Product added successfully!';
         }
}
   







// if(isset($_GET['delete'])){

//    $delete_id = $_GET['delete'];
//    $select_delete_image = mysqli_query($conn, "SELECT image FROM `clothes` WHERE cloth_id = '$delete_id'")  or die(mysqli_error($conn));
//    $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
//    // unlink('../uploaded_img/'.$fetch_delete_image['image']);
//    mysqli_query($conn, "DELETE FROM `stock` WHERE cloth_id = '$delete_id'")  or die(mysqli_error($conn));

//    mysqli_query($conn, "DELETE FROM `clothes` WHERE cloth_id = '$delete_id'")  or die(mysqli_error($conn));

//    header('location:admin_cloth.php');
//    $message[] = 'Product deleted successfully!';

// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="add-products">
   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add Size</h3>
      <input type="text" class="box" required placeholder="enter size details" name="name">
     
       

      <!-- <textarea name="details" class="box" required placeholder="enter product details" cols="30" rows="10"></textarea> -->
     
      
      <input type="submit" value="add size" name="add_product" class="btn">
   </form>
</section>


<section class="show-products">

   <div class="box-container">

               <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `size` ") or die(mysqli_error($conn));
            if (mysqli_num_rows($select_products) > 0) {
               while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
            <div class="box">
              
               <div class="name"><?php echo $fetch_products['name']; ?></div>

                 
            <?php
               }
            } else {
               echo '<p class="empty">No size added yet!</p>';
            }
            ?>

   </div>
   

</section>












<script src="../js/admin_script.js"></script>

</body>
</html>