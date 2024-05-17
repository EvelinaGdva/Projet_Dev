<?php 
    include('../Data/database.php'); 
    include('login-check.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>
    <link rel="stylesheet" href="Css/index.css">
</head>
<body>
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li><a href="<?php echo SITEURL; ?>index.php">Home</a></li>
                    <li><a href="<?php echo SITEURL; ?>category.php">Category</a></li>
                    <li><a href="<?php echo SITEURL; ?>food.php">Food</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>

    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="adminController.php">Admin</a></li>
                <li><a href="categoryController.php">Category</a></li>
                <li><a href="foodController.php">Food</a></li>
                <li><a href="orderController.php">Order</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
