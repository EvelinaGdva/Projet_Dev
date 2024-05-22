<?php include('menu-front/menu.php'); ?>

<section class="food-search text-center">
    <div class="container">
        <form action="food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>

<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php 
            if(isset($_GET['id']) && isset($_GET['name']) && isset($_GET['description']) && isset($_GET['price'])) {
                $id = $_GET['id'];
                $food_name = $_GET['name'];
                $food_description = $_GET['description'];
                $food_price = $_GET['price'];

                echo "<h2>$food_name</h2>";
                echo "<p>$food_description</p>";
                echo "<p>Price: $food_price</p>";
            } else {
                echo "<div class='error'>Food details not found.</div>";
            }
        ?>


                        <select name="category">
                            <?php                                 
                                $sql = "SELECT * FROM category";
                                $res = mysqli_query($conn, $sql);

                                if(mysqli_num_rows($res) > 0) {
                                    while($row = mysqli_fetch_assoc($res)) {
                                        echo "<option value='".$row['id']."'>".$row['food_name']."</option>";
                                    }
                                } else {
                                    echo "<option value='0'>Aucune catégorie trouvée</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</section>

<?php 
            if(isset($_POST['submit'])) {
                $food_name = $_POST['food_name'];
                $food_description = $_POST['food_description'];
                $food_price = $_POST['food_price'];
                $category = $_POST['category'];

                $image = $_FILES['image'];
                $image_name = $image['name'];
                $target_directory = "images/food/";
                $target_file = $target_directory . basename($image_name);

                if(move_uploaded_file($image['tmp_name'], $target_file)) {
                    require_once "Data/database.php";

                    $sql = "INSERT INTO food (food_name, food_description, food_price, image, id_category) 
                            VALUES ('$food_name', '$food_description', '$food_price', '$image_name', '$category')";

                    if(mysqli_query($conn, $sql)) {
                        echo "<div class='success'>Le plat a été ajouté avec succès.</div>";
                    } else {
                        echo "<div class='error'>Erreur lors de l'ajout du plat dans la base de données.</div>";
                    }
                } else {
                    echo "<div class='error'>Erreur lors du téléchargement de l'image.</div>";
                }
            }

            $sql = "SELECT * FROM food";
            $res = mysqli_query($conn, $sql);

            if(mysqli_num_rows($res) > 0) {
                while($row = mysqli_fetch_assoc($res)) {
                    echo "<div class='food-menu-box'>";
                    echo "<div class='food-menu-img'>";
                    if(!empty($row['image'])) {
                        echo "<img src='images/food/{$row['image']}' alt='Food Image' class='img-responsive img-curve'>";
                    } else {
                        echo "<div class='error'>Image not available.</div>";
                    }
                    echo "</div>";
                    echo "<div class='food-menu-desc'>";
                    echo "<h4>{$row['food_name']}</h4>";
                    echo "<p class='food-price'>{$row['food_price']}</p>";
                    echo "<p class='food-detail'>{$row['food_description']}</p>";
                    echo "<br>";
                    echo "<a href='order.php?food_id={$row['id']}' class='btn btn-primary'>Order Now</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='error'>Aucun plat trouvé.</div>";
            }
        ?>
