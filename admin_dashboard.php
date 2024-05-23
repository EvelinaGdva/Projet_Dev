<?php

$host = "localhost"; 
$db_username = "root";
$db_password = "root";
$database = "Evelicious_munch";
$port = 8887;

$conn = new mysqli($host, $db_username, $db_password, $database, $port);

// Vérifier la connexion
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Pour supprimer un restaurant
if(isset($_POST['delete'])){
  $id = $_POST['id'];

  $sql = "DELETE FROM restaurants WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    echo "Restaurant supprimé avec succès";
  } else {
    echo "Erreur lors de la suppression du restaurant: " . $conn->error;
  }
}

// Pour modifier un restaurant
if(isset($_POST['update'])){
  $id = $_POST['id'];
  $name = $_POST['name'];
  $location = $_POST['location'];
  $description = $_POST['description'];

  $sql = "UPDATE restaurants SET name='$name', location='$location', description='$description' WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    echo "Restaurant modifié avec succès";
  } else {
    echo "Erreur lors de la modification du restaurant: " . $conn->error;
  }
}

$conn->close();
?>