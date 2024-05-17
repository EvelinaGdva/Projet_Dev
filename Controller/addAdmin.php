<?php include('partials/menu.php'); ?> // Inclusion du menu de navigation depuis un fichier externe.

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1> // Titre de la page pour ajouter un administrateur.

        <br><br>

        <?php 

            if(isset($_SESSION['add'])) // Vérifie si une variable de session 'add' est définie.
            {
                echo $_SESSION['add'];  // Affiche le message contenu dans la variable de session.
                unset($_SESSION['add']);  // Supprime la variable de session 'add' après l'avoir affichée.
            }
        ?>

        <form action="" method="POST"> // Formulaire pour soumettre les détails de l'administrateur.

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td> // Champ pour le nom complet de l'administrateur.
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td> // Champ pour le nom d'utilisateur de l'administrateur.
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td> // Champ pour le mot de passe de l'administrateur.
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary"> // Bouton pour ajouter l'administrateur.
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>



<?php 

    if(isset($_POST['submit'])) // Vérifie si le formulaire a été soumis.
    {
        $full_name = $_POST['full_name']; // Récupération du nom complet depuis le formulaire.
        $username = $_POST['username']; // Récupération du nom d'utilisateur.
        $password = md5($_POST['password']);  // Récupération et hachage du mot de passe.

        $sql = "INSERT INTO admin SET 
            full_name='$full_name',
            username='$username',
            password='$password'
        "; // Requête SQL pour insérer les données de l'administrateur dans la base de données.
 
        $res = mysqli_query($conn, $sql) or die(mysqli_error()); 

        if($res==TRUE) // Vérifie si l'insertion dans la base de données a réussi.
        {
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully.</div>"; // Message de succès à afficher.
            header("location:".SITEURL.'Controller/adminController.php'); // Redirection vers le contrôleur de l'administrateur.
        }
        else
        {
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin.</div>"; // Message d'erreur à afficher.
            header("location:".SITEURL.'Controller/add-admin.php'); // Redirection vers la page d'ajout d'administrateur.
        }

    }
    
?>
