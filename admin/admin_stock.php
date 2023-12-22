<?php

@include '../connect.php';

$conn=$link;

session_start();

if (isset($_POST['add_product'])) {
    $cloth_id = mysqli_real_escape_string($conn, $_POST['cloth_id']);

    $stock = mysqli_real_escape_string($conn, $_POST['stock']); // Adding stock field
    $size_id = mysqli_real_escape_string($conn, $_POST['size_id']); // Adding size field

  
    

 
        $insert_product = mysqli_query($conn, "INSERT INTO `stock` (cloth_id,size_id, stock) VALUES ('$cloth_id','$size_id', '$stock')") or die(mysqli_error($conn));

        if ($insert_product) {
            $message[] = 'Product added successfully!';
        }
        header('location: admin_cloth.php');
    }







if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
   header('location:admin_products.php');

}

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
     
      <div class="flex">
         <div class="inputBox">
            <?php
                if (isset($_GET['cloth'])) {
            $cloth_id = $_GET['cloth'];
            $update_query = mysqli_query($conn, "SELECT * FROM `clothes` WHERE cloth_id = '$cloth_id'") or die('query failed');
            if (mysqli_num_rows($update_query) > 0) {
                $fetch_update = mysqli_fetch_assoc($update_query);
        ?>
         </div>
         <h3>add <?php echo $fetch_update['name']; ?> stock</h3>
         <input type="hidden"  class="box" required value="<?php echo $fetch_update['cloth_id']; ?>"name="cloth_id">

      </div>
      <?php
      }
   } else {
      echo '<script>document.querySelector(".form-container1").style.display = "none";</script>';
   }
   ?>
      <input type="number" min="0" class="box" required placeholder="enter cloth stock" name="stock">
      <select name="size_id" class="box">
     <option value="" selected disabled>select size</option>
      <?php
               $select_category = mysqli_query($conn, "SELECT * FROM `size`") or die('query failed');
               if (mysqli_num_rows($select_category) > 0) {
                  while ($fetch_category = mysqli_fetch_assoc($select_category)) {
                     // Extracting data from a database 
                     ?>
                     <option value="<?php echo $fetch_category['id']; ?>"><?php echo $fetch_category['name']; ?></option>
               <?php
                  }
               } else {
                  echo '<p class="empty">no size!</p>';
               }
               ?>
         </select>
     
     
            

      <!-- <textarea name="details" class="box" required placeholder="enter product details" cols="30" rows="10"></textarea> -->
      
      <input type="submit" value="add stock" name="add_product" class="btn">
   </form>
</section>














<script src="js/admin_script.js"></script>

</body>
</html>