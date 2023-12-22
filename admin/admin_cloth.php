<?php

@include '../connect.php';
$conn=$link;
session_start();

if(isset($_POST['add_product'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   // $stock = mysqli_real_escape_string($conn, $_POST['stock']);
   
   $category_id = mysqli_real_escape_string($conn, $_POST['category_id']); // Renamed to category_id
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `clothes` WHERE name = '$name'") or die(mysqli_error($conn));

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'Product name already exists!';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `clothes` (name, price, category_id, image) VALUES ('$name', '$price', '$category_id', '$image')")  or die(mysqli_error($conn));

      if($insert_product){
         if($image_size > 2000000){
            $message[] = 'Image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Product added successfully!';
         }
      }
   }
}






if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `clothes` WHERE cloth_id = '$delete_id'")  or die(mysqli_error($conn));
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   // unlink('../uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `stock` WHERE cloth_id = '$delete_id'")  or die(mysqli_error($conn));

   mysqli_query($conn, "DELETE FROM `clothes` WHERE cloth_id = '$delete_id'")  or die(mysqli_error($conn));

   header('location:admin_cloth.php');
   $message[] = 'Product deleted successfully!';

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
      <h3>add new cloth</h3>
      <input type="text" class="box" required placeholder="Enter Cloth name" name="name">
      <input type="number" min="0" class="box" required placeholder="Enter Cloth price" name="price">
      <!-- <input type="number" min="0" class="box" required placeholder="enter product stock" name="stock"> -->
      <div class="flex">
         <div class="inputBox">
            <select name="category_id" class="box">
               <option value="" selected disabled>select category</option>
               <?php
               $select_category = mysqli_query($conn, "SELECT * FROM `category`") or die('query failed');
               if (mysqli_num_rows($select_category) > 0) {
                  while ($fetch_category = mysqli_fetch_assoc($select_category)) {
                     // Extracting data from a database 
                     ?>
                     <option value="<?php echo $fetch_category['category_id']; ?>"><?php echo $fetch_category['category_name']; ?></option>
               <?php
                  }
               } else {
                  echo '<p class="empty">no product!</p>';
               }
               ?>
            </select>
         </div>
      </div>

      <!-- <textarea name="details" class="box" required placeholder="enter product details" cols="30" rows="10"></textarea> -->
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      
      <input type="submit" value="add Cloth" name="add_product" class="btn">
   </form>
</section>


<section class="show-products">

   <div class="box-container">

   <?php
    $select_products = mysqli_query($conn, "SELECT * FROM `clothes`") or die(mysqli_error($conn));

    if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
            <div class="box">
                <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
                <img class="image" src="../uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_products['name']; ?></div>

                <?php
                $cloth_id = $fetch_products['cloth_id'];

                // Query to select stock information for the current cloth
                $select_stock = mysqli_query($conn, "SELECT * FROM `stock` WHERE cloth_id = '$cloth_id'") or die(mysqli_error($conn));

                if (mysqli_num_rows($select_stock) > 0) {
                    while ($fetch_stock = mysqli_fetch_assoc($select_stock)) {
                        $size_id = $fetch_stock['size_id'];
                        $stock_quantity = $fetch_stock['stock'];

                        // Query to select size information for the current stock
                        $select_size = mysqli_query($conn, "SELECT * FROM `size` WHERE id = '$size_id'") or die('query failed');

                        if (mysqli_num_rows($select_size) > 0) {
                            while ($fetch_size = mysqli_fetch_assoc($select_size)) {
                                ?>
                                <div class="details"><?php echo $fetch_size['name'] . ": " . $stock_quantity; ?></div>
                                <?php
                            }
                        }
                    }

                    // Display the "Update Stock" button only once
                    $update_url = "admin_stock_update.php?cloth=" . $cloth_id;
                    ?>
                    <a href="admin_stock.php?cloth=<?php echo $cloth_id; ?>" class="option-btn" style="background-color: blue;">Add Stock</a>
                    <a href="<?php echo $update_url; ?>" class="option-btn" style="background-color: green;">Update Stock</a>
                    <?php
                } else {
                    ?>
                    <div class="details">Stock not available</div>
                    <a href="admin_stock.php?cloth=<?php echo $cloth_id; ?>" class="option-btn" style="background-color: blue;">Add Stock</a>
                    <?php
                }
                ?>

                <a href="admin_update_cloth.php?update=<?php echo $fetch_products['cloth_id']; ?>" class="option-btn">Update</a>
                <a href="admin_cloth.php?delete=<?php echo $fetch_products['cloth_id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
            </div>
            <?php
        }
    } else {
        echo '<p class="empty">No products added yet!</p>';
    }
?>


   </div>
   

</section>












<script src="../js/admin_script.js"></script>

</body>
</html>