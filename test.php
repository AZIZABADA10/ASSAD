<?php
session_start();
require_once '../config/db.php';

// --- LOGIQUE DE CONNEXION ---
if (isset($_POST['connecter'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $connexion->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        // Vérification du mot de passe (Haché OU clair pour l'admin de test)
        $is_valid = (password_verify($password, $user['mot_de_passe']) || $password === $user['mot_de_passe']);

        if ($is_valid) {
            // Vérification du statut selon votre ENUM
            if ($user['statut_de_compte'] === 'active') {
                $_SESSION['user'] = $user;
                
                // Redirection par rôle
                $role = $user['role'];
                $path = ($role === 'admin') ? 'admin' : (($role === 'guide') ? 'guide' : 'visitor');
                header("Location: ../pages/$path/dashboard.php");
                exit();

            } elseif ($user['statut_de_compte'] === 'en_attend') {
                $_SESSION['attend_activation'] = "Votre compte est en attente d'activation par un administrateur.";
            } elseif ($user['statut_de_compte'] === 'blocked') {
                $_SESSION['login_error'] = "Ce compte a été bloqué par l'administration.";
            }
        } else {
            $_SESSION['login_error'] = "Mot de passe incorrect.";
        }
    } else {
        $_SESSION['login_error'] = "Aucun compte trouvé avec cet email.";
    }

    // En cas d'erreur ou d'attente
    $_SESSION['form_active'] = 'login-form';
    header('Location: ../pages/public/login.php');
    exit();
}

