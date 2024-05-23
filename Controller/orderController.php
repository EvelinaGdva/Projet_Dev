<?php include('Gestion/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br /><br /><br />

        <?php
        function modifier($image, $nom, $prix, $desc, $id)
        {
            if(require("Data/database.php")) 
            {
                $req = $conn->prepare("UPDATE produits SET `image` = ?, nom = ?, prix = ?, description = ? WHERE id=?"); // Correction: Utilisation de $conn au lieu de $access

                $req->execute(array($image, $nom, $prix, $desc, $id));

                $req->closeCursor();
            }
        }

        function afficherUnProduit($id)
        {
            if(require("Data/database.php")) 
            {
                $req = $access->prepare("SELECT * FROM produits WHERE id=?");

                $req->execute(array($id));

                $data = $req->fetchAll(PDO::FETCH_OBJ);

                $req->closeCursor();

                return $data;
            }
        }

        function ajouter($image, $nom, $prix, $desc)
        {
            if(require("Data/database.php"))             {
                $req = $access->prepare("INSERT INTO produits (image, nom, prix, description) VALUES (?, ?, ?, ?)");

                $req->execute(array($image, $nom, $prix, $desc));

                $req->closeCursor();
            }
        }

        function afficher()
        {
            if(require("Data/database.php"))             {
                $req = $access->prepare("SELECT * FROM produits ORDER BY id DESC");

                $req->execute();

                $data = $req->fetchAll(PDO::FETCH_OBJ);

                $req->closeCursor();

                return $data;
            }
        }

        function supprimer($id)
        {
            if(require("Data/database.php"))             {
                $req = $access->prepare("DELETE FROM produits WHERE id=?");

                $req->execute(array($id));

                $req->closeCursor();
            }
        }

        function getAdmin($email, $password)
        {
            if(require("Data/database.php"))             {
                $req = $access->prepare("SELECT * FROM admin WHERE email = ? AND motdepasse = ?"); // Correction: Requête pour récupérer l'admin par email et mot de passe

                $req->execute(array($email, $password));

                $data = $req->fetchAll(PDO::FETCH_OBJ);

                if($req->rowCount() == 1)
                {
                    return $data;
                }
                else
                {
                    return false;
                }
            }
        }
        ?>
