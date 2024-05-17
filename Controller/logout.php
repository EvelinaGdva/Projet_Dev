<?php 
    include('../Data/database.php');
    session_destroy(); 
    header('location:'.SITEURL.'Controller/login.php');

?>