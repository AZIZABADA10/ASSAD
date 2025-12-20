<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['ajouter_etape'])) {
    $id_visite = (int)$_POST['id_visite'];
    $titre = $_POST['titre_etape'];
    $description = $_POST['description_etape'];
    $zone = $_POST['zone_etape'];
    $ordre = (int)$_POST['ordre_etape'];

    $stmt = $connexion->prepare("
        INSERT INTO etapesvisite (titreetape, descriptionetape, ordreetape, id_visite)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param('ssii', $titre, $description, $ordre, $id_visite);
    $stmt->execute();

    $_SESSION['success'] = "Étape ajoutée avec succès !";
    header("Location: ../pages/guide/my_visits.php");
    exit();
}

?>
