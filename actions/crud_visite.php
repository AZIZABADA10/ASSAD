<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../pages/public/login.php');
    exit();
}

// Ajouter une visite
if (isset($_POST['ajouter_visite'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_heure = $_POST['date'] . ' ' . $_POST['heure_debut'];
    $duree = $_POST['duree'];
    $prix = $_POST['prix'];
    $langue = $_POST['langue'];
    $capacite_max = $_POST['capacite_max'];

    $stmt = $connexion->prepare("INSERT INTO visitesguidees (titre, date_heure, langue, capacite_max, duree, prix, id_guide) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiddi", $titre, $date_heure, $langue, $capacite_max, $duree, $prix, $_SESSION['user']['id_utilisateur']);
    $stmt->execute();
    header('Location: ../pages/guide/my_visits.php');
    exit();
}

// Supprimer une visite
if (isset($_GET['id_supprimer'])) {
    $id = $_GET['id_supprimer'];
    $stmt = $connexion->prepare("DELETE FROM visitesguidees WHERE id_visite=?");
    $stmt->bind_param("i", $id,);
    $stmt->execute();
    header('Location: ../pages/guide/my_visits.php');
    exit();
}

?>
