<?php
session_start();
require_once __DIR__ .'/../config/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../../pages/public/login.php');
    exit();
}

$user_id = $_SESSION['user']['id_utilisateur'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_visite = intval($_POST['id_visite']);
    $nb_personnes = intval($_POST['nb_personnes']);

    if ($nb_personnes < 1) {
        $_SESSION['error'] = "Le nombre de personnes doit être au moins 1.";
        header("Location: ../../pages/public/visits.php");
        exit();
    }

    $stmt = $connexion->prepare("INSERT INTO reservations (id_visite, id_utilisateur, nb_personnes) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $id_visite, $user_id, $nb_personnes);
    $stmt->execute();

    header("Location: ../pages/public/visits.php");
    exit();
}
?>
