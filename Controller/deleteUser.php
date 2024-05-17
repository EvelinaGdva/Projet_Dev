<?php 
    // Vérification de l'existence de l'identifiant de l'administrateur à supprimer
    if(isset($_GET['id'])) {
        $id = $_GET['id']; // Récupération de l'identifiant de l'administrateur à supprimer

        // Requête SQL pour supprimer l'administrateur de la base de données
        $sql = "DELETE FROM user WHERE id=$id";

        // Exécution de la requête SQL
        $res = mysqli_query($conn, $sql);

        // Vérification de la réussite de la suppression
        if($res==true)
        {
            $_SESSION['delete'] = "<div class='success'>User Deleted Successfully.</div>"; // Message de succès
            header('location:'.SITEURL.'Controller/UserController.php'); // Redirection vers la page de gestion des administrateurs
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete User. Try Again Later.</div>"; // Message d'erreur
            header('location:'.SITEURL.'Controller/UserController.php'); // Redirection vers la page de gestion des administrateurs
        }
    }
    else {
        // Si l'identifiant n'est pas défini, afficher un message d'erreur
        $_SESSION['delete'] = "<div class='error'>User ID not provided.</div>";
        header('location:'.SITEURL.'Controller/UserController.php'); // Redirection vers la page de gestion des administrateurs
    }
?>
