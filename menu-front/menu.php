<?php include('Data/database.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evelicious Munch</title>

    <link rel="stylesheet" href="CSS/index.css">
</head>

<body>
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="index.php" title="Logo">
                    <img src="Images/Logo.png" alt="Logo" class="img-responsive">
                </a>
            </div>

            <section class="food-menu">
           <div class="menu text-right">
    <ul>
        <li><a href="loginUser.php">Espace Utilisateur</a></li> 
        <li><a href="loginRestaurant.php">Espace Restaurateur</a></li>
    </ul>
</div>

            <div class="clearfix"></div>
        </div>
    </section>