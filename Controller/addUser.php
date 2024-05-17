<?php include('Gestion/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add User</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['add'])) 
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your full name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Your username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Your password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add user" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

    </div>
</div>


<?php 
    if(isset($_POST['submit']))
    {
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); 

        // Vous devrez inclure votre fichier de configuration de base de données ici
        $conn = mysqli_connect("localhost", "username", "password", "database_name");

        // Vérifie si la connexion à la base de données est réussie
        if(!$conn)
        {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO user (full_name, username, password) VALUES ('$full_name', '$username', '$password')";

        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if($res)
        {
            $_SESSION['add'] = "<div class='success'>Utilisateur ajouté avec succès.</div>";
            header("location:UserController.php");
        }
        else
        {
            $_SESSION['add'] = "<div class='error'>Échec de l'ajout de l'utilisateur.</div>";
            header("location:addUser.php");
        }

        mysqli_close($conn);
    }
?>
