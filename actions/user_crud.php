<?php

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../pages/public/login.php');
    exit();
}

require_once __DIR__ .'/../config/db.php';



if (isset($_POST['ajouter_user'])) {
        $erreurs = [];
        $nom= $_POST['nom'];
        $email= $_POST['email'];
        $password= $_POST['password'];
        $role= $_POST['role'];


        $pattern_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";
        
        if (!preg_match($pattern_email,$email))
        {
            $erreurs['email_error'] = "L'adresse email n'est pas valide (format attendu: nom@exemple.com).";
        }
        if (strlen($password) < 6) 
        {
            $erreurs['password_error'] = "Le mot de passe doit faire au moins 6 caractères.";
        }

        $email_exist = $connexion -> prepare("SELECT * FROM utilisateurs where email = ?");
        $email_exist -> bind_param('s',$email);
        $email_exist -> execute();
        if ($email_exist->get_result()->num_rows > 0) {
            $erreurs['email_existe']='Email et déja existe';
        }


        if (empty($erreurs)) {
            $password_hache = password_hash($password,PASSWORD_DEFAULT);
            $stmt = $connexion -> prepare("INSERT INTO utilisateurs (nom_complet,mot_de_passe,email,`role`,statut_de_compet)
            VALUES (?,?,?,?,?)");
            $statut_de_compet = 'active';
            if ($role === 'guide') {
                    $statut_de_compet = 'en_attente';
                }
            $stmt -> bind_param('sssss',$nom,$password_hache,$email,$role,$statut_de_compet);
                $stmt->execute();
                $_SESSION['success'] = "Inscription réussie ! Connectez-vous.";
                $_SESSION['form_active'] = 'login-form'; 
                header('Location: ../pages/admin/manage_users.php');
                exit();
        }else{
            $_SESSION['register_errors'] = $erreurs;
            header('Location: ../pages/admin/manage_users.php?modal=s-inscrire-form');
            exit();
        }

}








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