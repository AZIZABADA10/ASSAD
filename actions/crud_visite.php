<?php
session_start();
require_once '../config/db.php';

/* ===========================
   Sécurité
=========================== */
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guide') {
    header('Location: ../pages/public/login.php');
    exit();
}

$id_guide = $_SESSION['user']['id_utilisateur'];

/* ===========================
   AJOUTER UNE VISITE
=========================== */
if (isset($_POST['ajouter_visite'])) {

    $titre        = $_POST['titre'];
    $description  = $_POST['description'] ?? null;
    $date_heure   = $_POST['date'] . ' ' . $_POST['heure_debut'];
    $duree        = $_POST['duree'];
    $prix         = $_POST['prix'];
    $langue       = $_POST['langue'];
    $capacite_max = $_POST['capacite_max'];

    $stmt = $connexion->prepare("
        INSERT INTO visitesguidees 
        (titre, description, date_heure, langue, capacite_max, duree, prix, id_guide, statut)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'ouverte')
    ");

    $stmt->bind_param(
    "ssssiidi",
    $titre,
    $description,
    $date_heure,
    $langue ,
    $capacite_max,
    $duree,
    $prix,
    $id_guide
    );


    $stmt->execute();

    header('Location: ../pages/guide/my_visits.php');
    exit();
}

/* ===========================
   ANNULER UNE VISITE (STATUT)
=========================== */
if (isset($_GET['id_annuler'])) {

    $id_visite = $_GET['id_annuler'];

    $stmt = $connexion->prepare("
        UPDATE visitesguidees 
        SET statut = 'annulee'
        WHERE id_visite = ? AND id_guide = ?
    ");
    $stmt->bind_param("ii", $id_visite, $id_guide);
    $stmt->execute();

    header('Location: ../pages/guide/my_visits.php');
    exit();
}
