<?php include('Gestion/menu.php'); ?> 

<?php 

    if(isset($_POST['submit'])) // Vérifie si le formulaire a été soumis.
    {
        $full_name = $_POST['full_name']; // Récupération du nom complet depuis le formulaire.
        $username = $_POST['username']; // Récupération du nom d'utilisateur.
        $password = md5($_POST['password']);  // Récupération et hachage du mot de passe.

        // Vérification des identifiants de l'administrateur prédéfini
        $predefined_email = "admin@eveliciousmunch.com";
        $predefined_password = md5("admin"); // Vous pouvez remplacer "admin123" par le mot de passe souhaité.

        if ($username === $predefined_email && $password === $predefined_password) {
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
        } else {
            $_SESSION['add'] = "<div class='error'>Invalid credentials.</div>"; // Message d'erreur si les identifiants sont incorrects.
            header("location:".SITEURL.'Controller/add-admin.php'); // Redirection vers la page d'ajout d'administrateur.
        }

    }
    
?>
