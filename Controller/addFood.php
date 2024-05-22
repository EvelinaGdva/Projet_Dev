<?php include('Gestion/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        
            <table class="tbl-30">

                <tr>
                    <td>Food Name </td>
                    <td>
                        <input type="text" name="food_name" placeholder="Nom du plat">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="food_description" cols="30" rows="5" placeholder="Description du plat"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="food_price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Catégorie: </td>
                    <td>
                        <select name="category">
                            <?php                                 
                                $sql = "SELECT * FROM category";
                                $res = mysqli_query($conn, $sql);

                                if(mysqli_num_rows($res) > 0)
                                {
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        echo "<option value='".$row['id']."'>".$row['food_name']."</option>";
                                    }
                                }
                                else
                                {
                                    echo "<option value='0'>Aucune catégorie trouvée</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Ajouter le plat" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php 
            if(isset($_POST['submit']))
            {
                $food_name = $_POST['food_name'];
                $food_description = $_POST['food_description'];
                $food_price = $_POST['food_price'];
                $category = $_POST['category'];

                if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK)
                {
                    $image = $_FILES['image'];
                    $image_tmp = $_FILES['image']['tmp_name'];

                    $ext = pathinfo($image, PATHINFO_EXTENSION);
                    $new_image = "Food-Name-" . uniqid('', true) . '.' . $ext;
                    $destination = "../images/food/" . $new_image_name;

                    if(move_uploaded_file($image_tmp, $destination))
                    {
                    }
                    else
                    {
                        $_SESSION['upload'] = "<div class='error'>Échec du téléchargement de l'image.</div>";
                        header('location:'.SITEURL.'../Controller/addFood.php');
                        exit(); 
                    }
                }
                else
                {
                    $new_image = ""; 
                }

                $sql2 = "INSERT INTO food (food_name, food_description, food_price, image, id_category) 
                         VALUES ('$food_name', '$food_description', $food_price, '$new_image', $category)";
                $res2 = mysqli_query($conn, $sql2);

                if($res2)
                {
                    $_SESSION['add'] = "<div class='success'>Plat ajouté avec succès.</div>";
                    header('location:'.SITEURL.'Controller/foodController.php');
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>Échec de l'ajout du plat.</div>";
                    header('location:'.SITEURL.'Controller/foodController.php');
                }
            }
        ?>

    </div>
</div>

