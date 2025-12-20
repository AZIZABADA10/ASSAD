<?php
session_start();

$erreurs = [
    'login_error' => $_SESSION['login_error'] ?? '',
    's_inscrire' => $_SESSION['sinscrire_erreur'] ?? '',
    'email_error' => $_SESSION['register_errors']['email_error'] ?? '',
    'password_error' => $_SESSION['register_errors']['password_error'] ?? '',
    'email_existe' => $_SESSION['register_errors']['email_existe'] ?? '',
    'attend_activation' => $_SESSION['attend_activation'] ?? ''
];

$form_active = $_SESSION['form_active'] ?? 'login-form';


unset($_SESSION['login_error'], $_SESSION['sinscrire_erreur'], $_SESSION['form_active'], $_SESSION['attend_activation'], $_SESSION['register_errors']);


function afficher_erreurs($erreur)
{
    return !empty($erreur)
        ? "<p class='bg-red-500/20 border border-red-500 text-red-300 px-4 py-2 rounded-lg text-sm mb-4'>$erreur</p>"
        : '';
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lion de l'Atlas | Zoo ASSAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/tailwind-config.js"></script>
    <link rel="shortcut icon" href="../../assets/images/assad_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="bg-light text-dark font-sans">

    <!-- Header -->
<?php
  require '../layouts/header.php';
  ?>

    <!-- MAIN -->
    <main class="min-h-screen flex items-center justify-center pt-32 px-4
             bg-[url('../../assets/images/jungle-bg.jpg')] bg-cover bg-center">

        <div class="w-full max-w-md">

            <!-- LOGIN -->
            <div id="login-form" class="<?= $form_active === 'login-form' ? '' : 'hidden' ?>
                    bg-dark/90 backdrop-blur-lg border border-white/10
                    rounded-2xl shadow-2xl p-8">

                <h2 class="text-2xl font-bold text-center text-accent mb-6">
                    Connexion Zoo ASSAD
                </h2>
                <?php if (!empty($erreurs['attend_activation'])): ?>
                    <div class="bg-blue-500/20 border border-blue-500 text-blue-200 p-4 rounded-lg mb-6 text-center">
                        <?= htmlspecialchars($erreurs['attend_activation']); ?>
                    </div>
                <?php endif; ?>
                <?= afficher_erreurs($erreurs['login_error']); ?>

                <form action="../../actions/auth.php" method="POST" class="space-y-4">

                    <input type="email" name="email" placeholder="Email" class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none text-white" required>

                    <input type="password" name="password" placeholder="Mot de passe" class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none text-white" required>
                    <!-- <select name="role"
                        class="w-full px-4 py-3 rounded-lg bg-dark
                               border border-white/20 text-white
                               focus:ring-2 focus:ring-accent focus:outline-none" required>
                    <option value="">Sélectionner un rôle</option>
                    <option value="admin">Admin</option>
                    <option value="visiteur">Visiteur</option>
                    <option value="guide">Guide</option> -->
                    </select>

                    <button name="connecter" class="w-full py-3 rounded-lg bg-accent text-dark
                               font-semibold hover:opacity-90 transition">
                        Se connecter
                    </button>
                </form>

                <p class="text-center text-sm mt-6 text-gray-300">
                    Pas de compte ?
                    <button onclick="afficherForm('s-inscrire-form')" class="text-accent font-semibold hover:underline">
                        Créer un compte
                    </button>
                </p>
            </div>

            <!-- REGISTER -->
            <div id="s-inscrire-form" class="<?= $form_active === 's-inscrire-form' ? '' : 'hidden' ?>
                    bg-dark/90 backdrop-blur-lg border border-white/10
                    rounded-2xl shadow-2xl p-8">

                <h2 class="text-2xl font-bold text-center text-accent mb-6">
                    Inscription Zoo ASSAD
                </h2>

                <form action="../../actions/auth.php" method="POST" class="space-y-4">

                    <input type="text" name="nom" placeholder="Nom complet" class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none text-white" required>

                    <input type="email" name="email" placeholder="Email" class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none text-white" required>
                    <?= afficher_erreurs($erreurs['email_error']); ?>
                    <?= afficher_erreurs($erreurs['email_existe']); ?>
                    <input type="password" name="password" placeholder="Mot de passe" class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none text-white" required>
                    <?= afficher_erreurs($erreurs['password_error']); ?>

                    <select name="role" class="w-full px-4 py-3 rounded-lg bg-dark
                               border border-white/20 text-white
                               focus:ring-2 focus:ring-accent focus:outline-none text-white" required>
                        <option value="">Sélectionner un rôle</option>
                        <option value="visiteur">Visiteur</option>
                        <option value="guide">Guide</option>
                    </select>

                    <button name="inscrire" class="w-full py-3 rounded-lg bg-accent text-dark
                               font-semibold hover:opacity-90 transition">
                        S'inscrire
                    </button>
                </form>

                <p class="text-center text-sm mt-6 text-gray-300">
                    Déjà un compte ?
                    <button onclick="afficherForm('login-form')" class="text-accent font-semibold hover:underline">
                        Se connecter
                    </button>
                </p>
            </div>

        </div>
    </main>

    <script src="../../assets/js/main.js"></script>

</body>

</html>