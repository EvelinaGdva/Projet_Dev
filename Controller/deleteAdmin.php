<?php 
    $id = $_GET['id'];

    $sql = "DELETE FROM admin WHERE id=$id";

    $res = mysqli_query($conn, $sql);

    if($res==true)
    {
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
        header('location:'.SITEURL.'Controller/adminController.php');
    }
    else
    {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again Later.</div>";
        header('location:'.SITEURL.'Controller/adminController.php');
    }

?>