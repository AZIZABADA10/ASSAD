<?php

    require_once __DIR__ .'/../config/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $connexion -> prepare("SELECT * from utilisateurs WHERE id_utilisateur = ?");
    $stmt -> bind_param('i',$id);
    $stmt -> execute();
    $habitat = $stmt->get_result()->fetch_assoc();
}

if (isset($_GET[''])) {
    # code...
}



