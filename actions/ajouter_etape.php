<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guide') {
    header('Location: ../pages/public/login.php');
    exit();
}

if (
    isset($_POST['id_visite'], $_POST['titre_etape'], $_POST['description_etape'], $_POST['ordre_etape'])
) {
    $id_visite = (int) $_POST['id_visite'];
    $titre = trim($_POST['titre_etape']);
    $description = trim(string: $_POST['description_etape']);
    $ordre = (int) $_POST['ordre_etape'];

    $stmt = $connexion->prepare("   
        INSERT INTO etapesvisite (titreetape, descriptionetape, ordreetape, id_visite)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("ssii", $titre, $description, $ordre, $id_visite);
    $stmt->execute();
}

header('Location: ../pages/guide/my_visits.php');
exit();
