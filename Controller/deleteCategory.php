<?php 
    include('../Data/database.php');

    if(isset($_GET['id']) AND isset($_GET['image']))
    {
        $id = $_GET['id'];
        $image = $_GET['image'];

        if($image != "")
        {
            $path = "../images/category/".$image;
            $remove = unlink($path);

            if($remove==false)
            {
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
                header('location:'.URL.'Controller/categoryController.php');
                die();
            }
        }

        $sql = "DELETE FROM category WHERE id=$id";

        $res = mysqli_query($conn, $sql);

       
        if($res==true)
        {
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
            header('location:'.URL.'Controller/categoryController.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
            header('location:'.URL.'Controller/categoryController.php');
        }
    }
    else
    {
        header('location:'.URL.'Controller/categoryController.php');
    }
?>