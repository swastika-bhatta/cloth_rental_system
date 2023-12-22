<?php


session_start();
@include '../connect.php';
$conn=$link;

if (isset($_POST['update_product'])) {
   $update_p_id = $_POST['update_p_id'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $category_id = mysqli_real_escape_string($conn, $_POST['category_id']); 

   mysqli_query($conn, "UPDATE `clothes` SET name = '$name', price = '$price', category_id = '$category_id' WHERE cloth_id = '$update_p_id'") or die(mysqli_error($conn));

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/' . $image;
   $old_image = $_POST['update_p_image'];

   if (!empty($image)) {
       if ($image_size > 20000000000) {
           $message[] = 'Image file size is too large!';
       } else {
           mysqli_query($conn, "UPDATE `clothes` SET image = '$image' WHERE cloth_id = '$update_p_id'") or die(mysqli_error($conn));
           move_uploaded_file($image_tmp_name, $image_folder);
         //   unlink('../uploaded_img/' . $old_image);
           $message[] = 'Image updated successfully!';
       }
   }

   $message[] = 'Product updated successfully!';
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
$update_id = $_GET['update'];
$select_products = mysqli_query($conn, "SELECT * FROM `clothes` WHERE cloth_id = '$update_id'") or die('query failed');
if (mysqli_num_rows($select_products) > 0) {
    while ($fetch_products = mysqli_fetch_assoc($select_products)) {
?>

<form action="" method="post" enctype="multipart/form-data">
    <img src="../uploaded_img/<?php echo $fetch_products['image']; ?>" class="image" alt="">
    <input type="hidden" value="<?php echo $fetch_products['cloth_id']; ?>" name="update_p_id">
    <input type="hidden" value="<?php echo $fetch_products['image']; ?>" name="update_p_image">
    <input type="text" class="box" value="<?php echo $fetch_products['name']; ?>" required placeholder="Update product name" name="name">
    <input type="number" min="0" class="box" value="<?php echo $fetch_products['price']; ?>" required placeholder="Update product price" name="price">
    <div class="flex">
        <div class="inputBox">
            <select name="category_id" class="box">
                <option value="" disabled>Select category</option>
                <?php
                $select_category = mysqli_query($conn, "SELECT * FROM `category`") or die('query failed');
                if (mysqli_num_rows($select_category) > 0) {
                    while ($fetch_category = mysqli_fetch_assoc($select_category)) {
                        // Check if the option matches the current product's category_id
                        $selected = ($fetch_category['category_id'] == $fetch_products['category_id']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $fetch_category['category_id']; ?>" <?php echo $selected; ?>><?php echo $fetch_category['category_name']; ?></option>
                    <?php
                    }
                } else {
                    echo '<option value="" disabled>No categories found</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image">
    <input type="submit" value="Update product" name="update_product" class="btn">
    <a href="admin_cloth.php" class="option-btn">Go back</a>
</form>

<?php
    }
} else {
    echo '<p class="empty">No update product selected</p>';
}
?>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>