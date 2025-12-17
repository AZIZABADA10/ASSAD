<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['connecter'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_choisi = $_POST['role']; 

    $stmt = $connexion->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        $is_valid = false;

        if (password_verify($password, $user['mot_de_passe'])) {
            $is_valid = true;
        } 
        elseif ($password === $user['mot_de_passe']) {
            $is_valid = true;
        }

        if ($is_valid) {
            $_SESSION['user'] = $user;

            switch ($user['role']) {
                case 'admin':
                    header('Location: ../pages/admin/dashboard.php');
                    break;
                case 'visiteur':
                    header('Location: ../pages/visitor/dashboard.php');
                    break;
                case 'guide':
                    header('Location: ../pages/guide/dashboard.php');
                    break;
                default:
                    header('Location: ../pages/public/login.php');
                    break;
            }
            exit();
        }
    }else {
        $_SESSION['login_error'] = "Email ou mot de passe incorrect";
        $_SESSION['form_active'] = 'login-form';
        header('Location: ../pages/public/login.php');
        exit();
    }

    
}



if (isset($_POST['inscrire'])) {
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
        $password_hache = password_hash($password,PASSWORD_BCRYPT);
        $stmt = $connexion -> prepare("INSERT INTO utilisateurs (nom_complet,mot_de_passe,email,`role`)
        VALUES (?,?,?,?)");
        $stmt -> bind_param('ssss',$nom,$password_hache,$email,$role);
        $stmt->execute();
        $_SESSION['success'] = "Inscription réussie ! Connectez-vous.";
        $_SESSION['form_active'] = 'login-form'; 
        header('Location: ../pages/public/login.php');
        exit();
    }else{
        $_SESSION['register_errors'] = $erreurs;
        $_SESSION['form_active'] = 's-inscrire-form';
        header('Location: ../pages/public/login.php');
        exit();
    }

}