<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['connecter'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $connexion->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->bind_param('s',$email);
     $stmt-> execute();
     $user = $stmt-> get_result() -> fetch_assoc();

    if ($user && $password === $user['mot_de_passe']) {

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
        }
        exit();

    } else {
        $_SESSION['login_error'] = "Email ou mot de passe incorrect";
        $_SESSION['form_active'] = 'login-form';
        header('Location: ../pages/public/login.php');
        exit();
    }
}
