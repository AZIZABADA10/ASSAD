<?php

    require_once __DIR__ .'/../config/db.php';

$habitats = $connexion -> query("SELECT * FROM habitats ORDER BY id_habitat DESC");


if (isset($_POST['ajouter_habitat'])) {
    $nom_habitat = $_POST['nom_habitat'];
    $type_climat = $_POST['type_climat'];
    $zonezoo = $_POST['zonezoo'];
    $description_habitat = $_POST['description_habitat'];

    $stmt = $connexion -> prepare("INSERT INTO habitats (nom_habitat,type_climat,zonezoo,description_habitat) VALUES (?,?,?,?)");
    $stmt -> bind_param('ssss',$nom_habitat,$type_climat,$zonezoo,$description_habitat);
    $stmt -> execute();
    header('Location: ../pages/admin/manage_habitats.php');
    exit();
}


if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);

    // $check = $connexion->query("SELECT COUNT(*) AS total FROM animal WHERE id_habitat = $id");
    // $row = $check->fetch_assoc();

    // if ($row['total'] > 0) {
    //     header("Location: ../index.php?error=habitat_utilisé");
    //     exit();
    // }

    $sql = "DELETE FROM habitats WHERE id_habitat = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header('Location: ../pages/admin/manage_habitats.php');
    exit();

}


?>