<?php

require_once '../config/db.php';


if (isset($_POST['connecter'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $connexion -> prepare("SELECT * FROM utilisateurs WHERE email =?");
    $stmt -> bind_param('s',$email);
    $stmt -> execute();
    $user = $stmt -> get_result() -> fetch_assoc();
    if ($user && $password === $user['mot_de_passe']) {
        switch ($user['role']) {
            case 'admin':
                header('Location:../pages/admin/dashboard.php');
               break;
            case 'visiteur':
                header('Location:../pages/visitor/dashboard.php');
                exit();
            case 'guide':
                header('Location:../pages/guide/dashboard.php');
                exit();
            default:
                header('Location:../pages/public/login.php');
                exit();
        }
    }else {
        $_SESSION['login_error'] = "Email ou le mot de passe incorrect !";
        header('Location:../pages/public/login.php?erreur=1');
        exit();
}
}




?>