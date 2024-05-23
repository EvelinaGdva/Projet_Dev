<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix d'Inscription</title>
</head>
<body>
    <h1>Choisissez le type d'inscription :</h1>
    <button id="userBtn">Utilisateur</button>
    <button id="restaurateurBtn">Restaurateur</button>

    <script>
        document.getElementById("userBtn").addEventListener("click", function() {
            window.location.href = "registration_user.php";
        });

        document.getElementById("restaurateurBtn").addEventListener("click", function() {
            window.location.href = "registration_restaurateur.php";
        });
    </script>
</body>
</html>
