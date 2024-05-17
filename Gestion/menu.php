<?php 

    include('../Data/database.php'); 
    include('login-check.php');

?>


<html>
    <head>
        <title>Food Order Website - Home Page</title>

        <link rel="stylesheet" href="../css/index.css">
    </head>
    
    <body>
        <div class="menu text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="../Controller/adminController.php">Admin</a></li>
                    <li><a href="../Controller/categoryController.php">Category</a></li>
                    <li><a href="../Controller/foodController.php">Food</a></li>
                    <li><a href="../Controller/orderController.php">Order</a></li>
                    <li><a href="../Controller/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
