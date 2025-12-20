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
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>

</head>

<body class="bg-light text-dark font-sans">

    <!-- Header -->
    <header class="fixed top-0 w-full z-50 bg-dark/90 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4 text-white">
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="relative w-15 h-16">
                    <img src="../../assets/images/assad_logo.png" alt="Logo Zoo ASSAD"
                        class="w-full h-full object-contain logo-anim">
                </div>
                <h1 class="text-xl font-bold tracking-wide transition-colors duration-300 group-hover:text-accent">
                    Zoo ASSAD
                </h1>
            </div>
            <nav class="hidden md:flex gap-8 font-medium items-center">
                <a href="../../index.php" class="hover:text-accent transition">Accueil</a>
                <a href="../public/animals.php" class="hover:text-accent transition">Animaux</a>
                <a href="../public/visits.php" class="hover:text-accent transition">Visites Guidées</a>
                <a href="../public/lion.php" class="hover:text-accent transition">Lion de l'Atlas</a>

                <!-- Lien selon le rôle -->
                <?php if (isset($_SESSION['user'])): ?>

                    <?php if ($_SESSION['user']['role'] === 'visiteur'): ?>
                        <a href="../visitor/dashboard.php" class="hover:text-accent transition font-semibold">
                            Mes réservations
                        </a>

                    <?php elseif ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="../admin/dashboard.php" class="hover:text-accent transition font-semibold">
                            Dashboard
                        </a>

                    <?php elseif ($_SESSION['user']['role'] === 'guide'): ?>
                        <a href="../guide/dashboard.php" class="hover:text-accent transition font-semibold">
                            Dashboard
                        </a>
                    <?php endif; ?>

                <?php endif; ?>

                <!-- Login -->
                <?php if (!isset($_SESSION['user'])): ?>
                    <a href="../public/login.php"
                    class="px-4 py-2 rounded-full bg-accent text-white hover:bg-accent/80 transition">
                        Se connecter
                    </a>
                <?php endif; ?>

                <!-- Logout -->
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="../../actions/logout.php"
                    class="px-4 py-2 rounded-full border border-white/20 hover:bg-white/10 transition">
                        Déconnecter
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </header>