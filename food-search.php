
    <?php include('menu-front/menu.php'); ?>

<section class="food-search text-center">
    <div class="container">
        <?php 

            $search = mysqli_real_escape_string($conn, $_POST['search']);
        
        ?>


        <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

    </div>
</section>

<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php 

            $sql = "SELECT * FROM food WHERE food_name LIKE '%$search%' OR food_description LIKE '%$search%'";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            if($count>0)
            {
                while($row=mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $food_name= $row['food_name'];
                    $food_price = $row['food_price'];
                    $food_description = $row['food_description'];
                    $image = $row['image'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
                                if($image=="")
                                {
                                    echo "<div class='error'>Image not Available.</div>";
                                }
                                else
                                {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                    <?php 

                                }
                            ?>
                            
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $food_name; ?></h4>
                            <p class="food-price"><?php echo $food_price; ?></p>
                            <p class="food-detail">
                                <?php echo $food_description; ?>
                            </p>
                            <br>

                            <a href="order.php" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else
            {
                echo "<div class='error'>Food not found.</div>";
            }
        
        ?>

        

        <div class="clearfix"></div>

        

    </div>

</section>