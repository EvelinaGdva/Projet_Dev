<?php include ('Controller/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php 
        
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        
        ?>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Category Name: </td>
                    <td>
                        <input type="text" name="category_name" placeholder="Category Name">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php 
            if(isset($_POST['submit']))
            {
                $title = $_POST['title'];


                if(isset($_FILES['image']))
                {
                    $image = $_FILES['image'];
                    
                    if($image != "")
                    {
                        $ext = end(explode('.', $image));

                        $image = "Food_Category_".rand(000, 999).'.'.$ext; 
                        
                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image;

                        $upload = move_uploaded_file($source_path, $destination_path);

                        if($upload==false)
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image. </div>";
                            header('location:'.SITEURL.'Controller/addCategory.php');
                            die();
                        }

                    }
                }
                else
                {
                    $image="";
                }

                $sql = "INSERT INTO category SET 
                    category_name='$category_name',
                    image='$image',
                ";

                $res = mysqli_query($conn, $sql);

                if($res==true)
                {
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                    header('location:'.SITEURL.'Controller/categoryController.php');
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                    header('location:'.SITEURL.'Controller/category.php');
                }
            }
        
        ?>

    </div>
</div>

