<?php 
    include('../Data/database.php');

    if(isset($_GET['id']) && isset($_GET['image_name'])) 
    {
        $id = $_GET['id'];
        $image = $_GET['image'];

        if($image != "")
        {
            $path = "../images/food/".$image;

            $remove = unlink($path);

            if($remove==false)
            {
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>";
                header('location:'.URL.'Controller/foodController.php');
                die();
            }

        }

        $sql = "DELETE FROM food WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";\
            header('location:'.URL.'Controller/foodController.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";\
            header('location:'.URL.'Controller/foodController.php');
        }

        

    }
    else
    {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
        header('location:'.URL.'Controller/foodController.php');
    }

?>