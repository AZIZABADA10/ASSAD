<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lion de l'Atlas | Zoo ASSAD</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../../assets/js/tailwind-config.js"></script>
  <link rel="shortcut icon" href="../../assets/images/assad_logo.png" type="image/x-icon">
  <link rel="stylesheet" href="../../assets/css/style.css">

</head>
<body class="bg-light text-dark font-sans">

  <!-- Header -->
  <header class="fixed top-0 w-full z-50 bg-dark/90 backdrop-blur-md border-b border-white/10">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4 text-white">
        <div class="flex items-center gap-3 group cursor-pointer">
            <div class="relative w-15 h-16">
                <img 
                    src="../../assets/images/assad_logo.png" 
                    alt="Logo Zoo ASSAD"
                    class="w-full h-full object-contain logo-anim"
                >
            </div>
            <h1 class="text-xl font-bold tracking-wide transition-colors duration-300 group-hover:text-accent">
                Zoo ASSAD
            </h1>
        </div>
        <nav class="hidden md:flex gap-8 font-medium">
            <a href="../../index.php" class="hover:text-accent transition">Accueil</a>
            <a href="../public/animals.php" class="hover:text-accent transition">Animaux</a>
            <a href="../public/visits.php" class="hover:text-accent transition">Visites Guidées</a>
            <a href="../public/lion.php" class="hover:text-accent transition">Lion de l'Atlas</a>
        </nav>
        <a href="../public/login.php"
           class="bg-accent text-dark px-5 py-2 rounded-full font-semibold hover:scale-105 transition-all">
            Connexion
        </a>
    </div>
  </header>



<!-- MAIN -->
<main class="min-h-screen flex items-center justify-center pt-32 px-4
             bg-[url('../../assets/images/jungle-bg.jpg')] bg-cover bg-center">

    <div class="w-full max-w-md">

        <!-- LOGIN -->
        <div id="login-form"
             class="<?= $form_active === 'login-form' ? '' : 'hidden' ?>
                    bg-dark/90 backdrop-blur-lg border border-white/10
                    rounded-2xl shadow-2xl p-8">

            <h2 class="text-2xl font-bold text-center text-accent mb-6">
                Connexion Zoo ASSAD
            </h2>

            <form action="auth.php" method="POST" class="space-y-4">

                <input type="email" name="email" placeholder="Email"
                       class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none">

                <input type="password" name="password" placeholder="Mot de passe"
                       class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none">

                <button name="connecter"
                        class="w-full py-3 rounded-lg bg-accent text-dark
                               font-semibold hover:opacity-90 transition">
                    Se connecter
                </button>
            </form>

            <p class="text-center text-sm mt-6 text-gray-300">
                Pas de compte ?
                <button onclick="afficherForm('s-inscrire-form')"
                        class="text-accent font-semibold hover:underline">
                    Créer un compte
                </button>
            </p>
        </div>

        <!-- REGISTER -->
        <div id="s-inscrire-form"
             class="<?= $form_active === 's-inscrire-form' ? '' : 'hidden' ?>
                    bg-dark/90 backdrop-blur-lg border border-white/10
                    rounded-2xl shadow-2xl p-8">

            <h2 class="text-2xl font-bold text-center text-accent mb-6">
                Inscription Zoo ASSAD
            </h2>

            <form action="auth.php" method="POST" class="space-y-4">

                <input type="text" name="nom" placeholder="Nom complet"
                       class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none">

                <input type="email" name="email" placeholder="Email"
                       class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none">

                <input type="password" name="password" placeholder="Mot de passe"
                       class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none">

                <select name="role"
                        class="w-full px-4 py-3 rounded-lg bg-dark
                               border border-white/20 text-white
                               focus:ring-2 focus:ring-accent focus:outline-none">
                    <option value="">Sélectionner un rôle</option>
                    <option value="Admin">Admin</option>
                    <option value="Utilisateur">Utilisateur</option>
                </select>

                <button name="inscrire"
                        class="w-full py-3 rounded-lg bg-accent text-dark
                               font-semibold hover:opacity-90 transition">
                    S'inscrire
                </button>
            </form>

            <p class="text-center text-sm mt-6 text-gray-300">
                Déjà un compte ?
                <button onclick="afficherForm('login-form')"
                        class="text-accent font-semibold hover:underline">
                    Se connecter
                </button>
            </p>
        </div>

    </div>
</main>

<script src="../../assets/js/main.js"></script>

</body>
</html>
