<?php

    require_once '../config/db.php';


if (isset($_POST['ajouter_animal'])) {
    
    $nom = $_POST['nom'];
    $espace = $_POST['espace'];
    $alimentation = $_POST['alimentation'];
    $habitat = $_POST['habitat'];
    $pays_origine = $_POST['pays_origine'];
    $description_courte = $_POST['description_courte'];


    $imageName = null;
    if (!empty($_FILES['image']['tmp_name'])) {
        $ext =pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION)  ; 
        $imageName =uniqid() . '.'. $ext ;
        move_uploaded_file($_FILES['image']['tmp_name'],'uploads/'.$imageName );
    }  

    $stmt = $connexion->prepare("
        INSERT INTO animal 
        (nom, espace, alimentation, image_animal, pays_origine, id_habitat, description_courte)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sisssis",
        $nom,
        $espace,
        $alimentation,
        $imageName,
        $pays_origine,
        $habitat,
        $description_courte
    );

    $stmt->execute();
    header('Location: ../pages/admin/manage_animals.php');
    exit();

}



?>