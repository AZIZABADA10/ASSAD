<?php

    require_once __DIR__ .'/../config/db.php';

    $users = $connexion -> query("SELECT * FROM utilisateurs order by id_utilisateur desc");

    if (isset($_POST['changer_status'])) {
        $id_a_modifier = intval($_GET['id']);
        $neveau_statut = $_POST['statut_de_compet'];
        // var_dump($id_a_modifier) ;
        // var_dump($neveau_statut) ;

        $stmt = $connexion -> prepare("UPDATE utilisateurs 
        SET statut_de_compet = ?  
        WHERE id_utilisateur = ?"
        );
        $stmt -> bind_param('si',$neveau_statut,$id_a_modifier);
        $stmt -> execute();
        header('Location: ../pages/admin/manage_users.php');
        exit();
    }

    if(isset($_GET['id_supprimer'])){
        $id = intval($_GET['id_supprimer']);
        $stmt = $connexion -> prepare("DELETE FROM utilisateurs WHERE id_utilisateur =?");
        $stmt ->bind_param('i',$id);
        $stmt ->execute();
        header('Location: ../pages/admin/manage_users.php');
        exit();
    }

?>