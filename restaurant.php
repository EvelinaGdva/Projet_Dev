<?php include('menu-front/menu.php'); ?>

<?php 
    // Vérifiez si l'ID du restaurant est passé dans l'URL
    if(isset($_GET['id']))
    {
        $restaurant_id = $_GET['id'];

        // Requête pour récupérer les détails du restaurant
        $sql = "SELECT * FROM restaurant WHERE id=$restaurant_id";
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res) > 0)
        {
            // Restaurant trouvé
            $row = mysqli_fetch_assoc($res);
            $restaurant_name = $row['name'];
            $restaurant_description = $row['description'];
            $restaurant_image = $row['image'];
        }
        else
        {
            // Redirection si le restaurant n'est pas trouvé
            header('location:index.php');
        }
    }
    else
    {
        // Redirection si l'ID n'est pas passé
        header('location:index.php');
    }
?>

<section class="restaurant-detail">
    <div class="container">
        <h2 class="text-center"><?php echo $restaurant_name; ?></h2>
        
        <div class="restaurant-box">
            <div class="restaurant-img">
                <?php 
                    if($restaurant_image == "") {
                        echo "<div class='error'>Image not available.</div>";
                    } else {
                        echo "<img src='images/restaurants/$restaurant_image' alt='$restaurant_name' class='img-responsive img-curve'>";
                    }
                ?>
            </div>
            <div class="restaurant-desc">
                <h4><?php echo $restaurant_name; ?></h4>
                <p class="restaurant-detail"><?php echo $restaurant_description; ?></p>
            </div>
        </div>

        <h3 class="text-center">Menu</h3>

        <?php 
            // Requête pour récupérer les plats du restaurant
            $sql2 = "SELECT * FROM food WHERE restaurant_id=$restaurant_id";
            $res2 = mysqli_query($conn, $sql2);

            if(mysqli_num_rows($res2) > 0)
            {
                while($row2 = mysqli_fetch_assoc($res2))
                {
                    $food_name = $row2['name'];
                    $food_description = $row2['description'];
                    $food_price = $row2['price'];
                    $food_image = $row2['image'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
                                if($food_image == "") {
                                    echo "<div class='error'>Image not available.</div>";
                                } else {
                                    echo "<img src='images/food/$food_image' alt='$food_name' class='img-responsive img-curve'>";
                                }
                            ?>
                        </div>
                        <div class="food-menu-desc">
                            <h4><?php echo $food_name; ?></h4>
                            <p class="food-price"><?php echo $food_price; ?>€</p>
                            <p class="food-detail"><?php echo $food_description; ?></p>
                            <br>
                            <a href="order.php?food_id=<?php echo $row2['id']; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else
            {
                echo "<div class='error'>No food items found.</div>";
            }
        ?>
        <div class="clearfix"></div>
    </div>
</section>

<?php include('menu-front/footer.php'); ?>
