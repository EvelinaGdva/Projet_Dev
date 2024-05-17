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

        <h2 class="text-center">Add Food</h2>
        <form action="food.php" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Nom du plat:</td>
                    <td><input type="text" name="food_name" placeholder="Nom du plat"></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td><textarea name="food_description" cols="30" rows="5" placeholder="Description du plat"></textarea></td>
                </tr>
                <tr>
                    <td>Prix:</td>
                    <td><input type="number" name="food_price"></td>
                </tr>
                <tr>
                    <td>Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Catégorie:</td>
                    <td>
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
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Ajouter le plat" class="btn-secondary"></td>
                </tr>
            </table>
        </form>
    </div>
</section>

<?php 
            // Vérifier si l'ajout du plat a été soumis
            if(isset($_POST['submit'])) {
                // Récupérer les informations du formulaire
                $food_name = $_POST['food_name'];
                $food_description = $_POST['food_description'];
                $food_price = $_POST['food_price'];
                $category = $_POST['category'];

                // Traiter le téléchargement de l'image
                $image = $_FILES['image'];
                $image_name = $image['name'];
                $target_directory = "images/food/";
                $target_file = $target_directory . basename($image_name);

                // Si l'image est téléchargée avec succès, procéder à l'insertion dans la base de données
                if(move_uploaded_file($image['tmp_name'], $target_file)) {
                    require_once "Data/database.php";

                    // Requête d'insertion dans la base de données
                    $sql = "INSERT INTO food (food_name, food_description, food_price, image, id_category) 
                            VALUES ('$food_name', '$food_description', '$food_price', '$image_name', '$category')";

                    // Exécuter la requête d'insertion
                    if(mysqli_query($conn, $sql)) {
                        echo "<div class='success'>Le plat a été ajouté avec succès.</div>";
                    } else {
                        echo "<div class='error'>Erreur lors de l'ajout du plat dans la base de données.</div>";
                    }
                } else {
                    echo "<div class='error'>Erreur lors du téléchargement de l'image.</div>";
                }
            }

            // Sélectionner tous les plats de la base de données
            $sql = "SELECT * FROM food";
            $res = mysqli_query($conn, $sql);

            // Vérifier s'il y a des plats à afficher
            if(mysqli_num_rows($res) > 0) {
                // Afficher chaque plat
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
