<?php 

if (isset($_POST['inscrire'])) {
    $erreurs = [];
    
    // Récupération et nettoyage des données
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // --- VALIDATION ---
    if (empty($nom)) $erreurs[] = "Le nom est obligatoire.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurs[] = "Format d'email invalide.";
    if (strlen($password) < 6) $erreurs[] = "Le mot de passe doit faire au moins 6 caractères.";
    if (empty($role)) $erreurs[] = "Veuillez choisir un rôle.";

    // Vérifier si l'email existe déjà
    $checkEmail = $connexion->prepare("SELECT id_utilisateur FROM utilisateurs WHERE email = ?");
    $checkEmail->bind_param('s', $email);
    $checkEmail->execute();
    if ($checkEmail->get_result()->num_rows > 0) {
        $erreurs[] = "Cet email est déjà utilisé.";
    }

    // --- TRAITEMENT ---
    if (empty($erreurs)) {
        // Hachage du mot de passe
        $password_hache = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $connexion->prepare("INSERT INTO utilisateurs (nom_complet, email, role, mot_de_passe) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $nom, $email, $role, $password_hache);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Inscription réussie ! Connectez-vous.";
            $_SESSION['form_active'] = 'login-form'; // Redirige vers le login
            header('Location: ../pages/public/login.php');
            exit();
        } else {
            $erreurs[] = "Erreur lors de l'inscription.";
        }
    }

    // En cas d'erreurs, on les stocke en session et on repart au formulaire
    $_SESSION['register_errors'] = $erreurs;
    $_SESSION['form_active'] = 's-inscrire-form';
    header('Location: ../pages/public/login.php');
    exit();
}