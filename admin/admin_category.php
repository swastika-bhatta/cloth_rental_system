<?php


session_start();

@include '../connect.php';

$conn=$link;

if (isset($_POST['add_product'])) {
 

   // Get the category_name from the form and sanitize it
   $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

   // Check if the category_name already exists in the category table
   $select_category_name = mysqli_query($conn, "SELECT category_name FROM `category` WHERE category_name = '$category_name'") or die(mysqli_error($conn));

   if (mysqli_num_rows($select_category_name) > 0) {
       $message[] = 'Category name already exists!';
   } else {
       // Insert the category_name into the category table
       $insert_category = mysqli_query($conn, "INSERT INTO `category` (category_name) VALUES ('$category_name')") or die(mysqli_error($conn));

       if ($insert_category) {
           $message[] = 'Category added successfully!';
       }
   }
}


if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];

   // Check if the category is associated with any products
   $check_association_query = mysqli_query($conn, "SELECT COUNT(*) AS count_products FROM `clothes` WHERE category_id = '$delete_id'") or die('query failed');
   $association_result = mysqli_fetch_assoc($check_association_query);
   $num_products_associated = $association_result['count_products'];

   if ($num_products_associated > 0) {
       // If the category is associated with any products, handle the error or notify the user
       $message[] = 'Cannot delete the category as it is associated with ' . $num_products_associated . ' product(s).';
   } else {
       // No products are associated with the category, so proceed with deletion
       $delete_result = mysqli_query($conn, "DELETE FROM `category` WHERE category_id = '$delete_id'") or die('query failed');

       header('location: admin_category.php');
   }
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
      <h3>add new category</h3>
      <input type="text" class="box" required placeholder="enter category name" name="category_name">
  
      <input type="submit" value="add category" name="add_product" class="btn">
   </form>

</section>

<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `category`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         
         <div class="name"><?php echo $fetch_products['category_name']; ?></div>
        
         <a href="admin_category_update.php?update=<?php echo $fetch_products['category_id']; ?>" class="option-btn">update</a>
         <a href="admin_category.php?delete=<?php echo $fetch_products['category_id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>
   

</section>












<script src="js/admin_script.js"></script>

</body>
</html>