<?php
$conn = mysqli_connect('localhost','root','','cloth_rental') or die('connection failed');

if(($_SESSION['email']) && !empty($_GET['id'])) {
   header('location:index.php');

  
  
   
}

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="flex">

      <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="main.php">home</a>
         <a href="admin_cloth.php">cloth</a>
         <a href="admin_category.php">category</a>
         <a href="admin_size.php">size</a>
         <a href="admin_rent.php">rent cloth</a>
         <a href="return.php">return</a>
      
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
         <p>username : <span>admin</span></p>
         <p>email : <span><?php echo $_SESSION['email']; ?></span></p>
         <a href="logout.php" class="delete-btn">logout</a>

      </div>

   </div>

</header>

<script src="../js/admin_script.js"></script>