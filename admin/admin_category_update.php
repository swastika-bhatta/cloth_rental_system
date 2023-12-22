<?php


session_start();
@include '../connect.php';
$conn=$link;

if (isset($_POST['update_category'])) {
    // Assuming you have already established the $conn variable for database connection

    $update_category_id = mysqli_real_escape_string($conn, $_POST['update_category_id']);
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

    // Check if the category_name already exists in the category table (excluding the current category_id)
    $select_category_name = mysqli_query($conn, "SELECT category_id FROM `category` WHERE category_name = '$category_name' AND category_id != '$update_category_id'") or die('query failed');

    if (mysqli_num_rows($select_category_name) > 0) {
        $message[] = 'Category name already exists!';
    } else {
        // Update the category_name in the category table
        mysqli_query($conn, "UPDATE `category` SET category_name = '$category_name' WHERE category_id = '$update_category_id'") or die('query failed');
        $message[] = 'Category updated successfully!';
    }
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
$select_products = mysqli_query($conn, "SELECT * FROM `category` WHERE category_id = '$update_id'") or die('query failed');
if (mysqli_num_rows($select_products) > 0) {
    while ($fetch_products = mysqli_fetch_assoc($select_products)) {
?>

<form action="" method="post" enctype="multipart/form-data">

    <input type="hidden" value="<?php echo $fetch_products['category_id']; ?>" name="update_category_id">

    <input type="text" class="box" value="<?php echo $fetch_products['category_name']; ?>" required placeholder="Update product name" name="category_name">
   
    <input type="submit" value="Update category" name="update_category" class="btn">
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