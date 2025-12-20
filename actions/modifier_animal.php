<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$id = $_GET['id'] ?? null;
$animal = null;

if ($id) {
    $stmt = $connexion->prepare("SELECT * FROM animal WHERE id_animal = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $animal = $stmt->get_result()->fetch_assoc();
}

$erreurs = $_SESSION['update_errors'] ?? [];
unset($_SESSION['update_errors']);

function afficher_erreurs($erreur) {
    return !empty($erreur) ? "<p class='text-red-400 text-sm mt-1'>$erreur</p>" : '';
}

if (isset($_POST['modifier_animal'])) {

    $nom = $_POST['nom_animal'];
    $espace = $_POST['espace'];
    $alimentation = $_POST['alimentation'];
    $pays = $_POST['pays_origine'];
    $description = $_POST['description_courte'];
    $id_habitat = $_POST['id_habitat'];

    $image_name = $animal['image_animal'];

    // Upload image (optionnel)
    if (!empty($_FILES['image_animal']['name'])) {
        $image_name = uniqid() . '_' . $_FILES['image_animal']['name'];
        move_uploaded_file(
            $_FILES['image_animal']['tmp_name'],
            "../uploads/$image_name"
        );
    }

    if (empty($erreurs)) {
        $stmt = $connexion->prepare("
            UPDATE animal SET
                nom_animal = ?,
                espace = ?,
                alimentation = ?,
                image_animal = ?,
                pays_origine = ?,
                description_courte = ?,
                id_habitat = ?
            WHERE id_animal = ?
        ");

        $stmt->bind_param(
            'ssssssii',
            $nom,
            $espace,
            $alimentation,
            $image_name,
            $pays,
            $description,
            $id_habitat,
            $id
        );

        $stmt->execute();
        header('Location: ../pages/admin/manage_animals.php');
        exit();
    } else {
        $_SESSION['update_errors'] = $erreurs;
        header("Location: modifier_animal.php?id=$id");
        exit();
    }
}
?>
