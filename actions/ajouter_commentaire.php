<?php
session_start();
require_once '../config/db.php';


if (isset($_POST['id_visite'], $_POST['note'], $_POST['texte'])) {
    $id_visite = (int)$_POST['id_visite'];
    $note = (int)$_POST['note'];
    $texte = trim($_POST['texte']);
    $id_utilisateur = $_SESSION['user']['id_utilisateur'];

    $stmt = $connexion->prepare("
        SELECT statut FROM reservations 
        WHERE id_visite = ? AND id_utilisateur = ?
    ");
    $stmt->bind_param("ii", $id_visite, $id_utilisateur);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if ($res && $res['statut'] === 'confirmee') {
        $stmt = $connexion->prepare("
            INSERT INTO commentaires (id_visite, id_utilisateur, note, texte) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("iiis", $id_visite, $id_utilisateur, $note, $texte);
        $stmt->execute();
        $_SESSION['success'] = "Commentaire ajouté avec succès !";
    } else {
        $_SESSION['error'] = "Impossible d'ajouter un commentaire pour une réservation non confirmée.";
    }
}

header('Location: ../pages/visitor/dashboard.php');
exit();
