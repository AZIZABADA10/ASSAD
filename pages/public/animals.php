<?php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Zoo ASSAD | Animaux</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/tailwind-config.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="../../assets/images/assad_logo.png" type="image/x-icon">
</head>

<body class="bg-light text-dark">
<header class="fixed top-0 w-full z-50 bg-dark/90 backdrop-blur-md border-b border-white/10">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4 text-white">

        <!-- Logo -->
        <div class="flex items-center gap-3 group cursor-pointer">
    
            <!-- Logo -->
            <div class="relative w-15 h-16">
                <img 
                    src="../../assets/images/assad_logo.png" 
                    alt="Logo Zoo ASSAD"
                    class="w-full h-full object-contain logo-anim"
                >
            </div>

            <!-- Text -->
            <h1 class="text-xl font-bold tracking-wide transition-colors duration-300 group-hover:text-accent">
                Zoo ASSAD
            </h1>
        </div>
        <!-- Navigation -->
        <nav class="hidden md:flex gap-8 font-medium">
            <a href="index.php" class="hover:text-accent transition">Accueil</a>
            <a href="pages/public/animals.php" class="hover:text-accent transition">Animaux</a>
            <a href="pages/public/visits.php" class="hover:text-accent transition">Visites Guidées</a>
            <a href="pages/public/lion.php" class="hover:text-accent transition">Lion de l'Atlas</a>
        </nav>

        <!-- Button -->
        <a href="pages/public/login.php"
           class="bg-accent text-dark px-5 py-2 rounded-full font-semibold hover:scale-105 transition-all">
            Connexion
        </a>
    </div>
</header>
<main class="h-[400px]">

</main>
<footer class="bg-dark text-gray-300 pt-20">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">

        <div>
            <h3 class="text-xl font-bold text-white mb-4">
              <img src="assets/images/assad_logo.png" 
               alt="Symbole CAN 2025"
               class="h-16 w-16 object-contain inline-block"> Zoo ASSAD</h3>
            <p>
                Un zoo virtuel moderne célébrant la CAN 2025 et la richesse de la faune africaine.
            </p>
        </div>

        <div>
            <h4 class="font-semibold text-white mb-3">Explorer</h4>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-accent">Animaux</a></li>
                <li><a href="#" class="hover:text-accent">Visites</a></li>
                <li><a href="#" class="hover:text-accent">Lion de l'Atlas</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-semibold text-white mb-3">Contact</h4>
            <p>Rabat, Maroc<br>contact@zoo-assad.ma</p>
        </div>

        <div>
            <h4 class="font-semibold text-white mb-3">Horaires</h4>
            <p>Tous les jours<br>09:00 – 18:00</p>
        </div>
    </div>

    <div class="text-center mt-12 border-t border-white/10 py-6">
        © 2025 Zoo Virtuel ASSAD — CAN 2025
    </div>
</footer>

</body>
</html>
