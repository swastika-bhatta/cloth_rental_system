<?php
session_start();
include 'connect.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location: login.php');
    exit(); // Ensure that no code is executed after the header is sent
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloth Rental</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="index.php">
                   Cloth Rental </a>
            </div>
           <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="clothes.php">All Clothes</a>
                    </li>
                    <li>
                        <a href="mybookings.php">booking</a>
                    </li>
                    <?php
                    if(isset($_SESSION['email'])){ ?>
                        <li>
                        <a href=""></span><?php echo $_SESSION['fullname'] ?></a>
                        </li>
                        <li>
                        <a href="logout.php">Logout <span class="glyphicon glyphicon-log-out"></span></a>
                        </li>
                        <?php } else { ?>
                            <li>
                                <a href="./login.php"></span>Login</a>
                            </li>
                    <?php } ?>
                    <ul class="nav navbar-nav">
                <ul class="dropdown-menu">
            </ul>
            </li>
          </ul>
                </ul>
            </div>
        </div>
        <!-- /.container -->
    </nav>
    <div class="bgimg-1">
        <header class="intro">
            <div class="intro-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h1 class="brand-heading" style="color: black">Cloth Rental</h1>
                            <p class="intro-text">
                                Cloth Rental System
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>


    <?php
    $sql = "select * from clothes";
    $run = mysqli_query($link, $sql);
    $count = mysqli_num_rows($run);
    ?>

    <div id="sec2" style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
        <h3 style="text-align:center;">Available Clothes</h3>
<br>

        <section class="menu-content">
            <?php
            while ($row = mysqli_fetch_assoc($run)) {
                if(isset($_SESSION['email'])){ ?>
                <a href="./booking.php?id=<?php echo $row['cloth_id']; ?>">
                    <?php
                } else { ?>
                    <a style="cursor:pointer" onclick="alert('Please Login First')">
                <?php 
                }
                ?>
                <div class="sub-menu">
                <img class="card-img-top" src="<?php echo $row['image']; ?>" alt="Card image cap">
                <h5><b> <?php echo $row['name']; ?> </b></h5>
                <h6> Rent Price(per day): Rs <?php echo $row['price']; ?></h6>
                </div> 
                </a>                                                     
            <?php } ?>           
        </section>
    </div>

    <footer class="site-footer">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <h5>© 2023 Cloth Rental</h5>
                </div>
                
            </div>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="assets/js/jquery.easing.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="assets/js/theme.js"></script>
</body>

</html>