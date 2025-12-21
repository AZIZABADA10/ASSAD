<?php

require_once 'config/db.php';


$sql = "
    SELECT 
        animal.*,
        habitats.nom_habitat
    FROM animal
    JOIN habitats ON animal.id_habitat = habitats.id_habitat
    LIMIT 3
";
$stmt = $connexion->prepare($sql);
$stmt->execute();
$animaux = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Zoo ASSAD | CAN 2025</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="assets/js/tailwind-config.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/assad_logo.png" type="image/x-icon">
</head>

<body class="bg-light text-dark">

<!-- ================= HEADER ================= -->
<header class="fixed top-0 w-full z-50 bg-dark/90 backdrop-blur-md border-b border-white/10">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4 text-white">

        <!-- Logo -->
        <div class="flex items-center gap-3 group cursor-pointer">
    
            <!-- Logo -->
            <div class="relative w-15 h-16">
                <img 
                    src="assets/images/assad_logo.png" 
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

<!-- ================= HERO ================= -->
<section class="hero-bg relative min-h-screen flex items-center overflow-hidden">

    <!-- Overlay Gradient -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-black/20"></div>

    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-6 py-32 text-white w-full">

        <div class="flex flex-col md:flex-row items-center gap-12">

            <!-- Cup CAN -->
            <div class="w-28 md:w-36 flex-shrink-0 animate-float">
                <img
                    src="assets/images/la_cup_du_can.png"
                    alt="Coupe d'Afrique des Nations"
                    class="w-full cup-anim cup-wrapper drop-shadow-[0_20px_30px_rgba(0,0,0,0.7)]"
                >
            </div>

            <!-- Text Content -->
            <div class="text-center md:text-left">

                <span class="inline-block mb-4 px-4 py-1 rounded-full bg-red-600/20 text-red-400 font-semibold tracking-wide">
                    CAN 2025 – Maroc
                </span>

                <h2 class="text-4xl md:text-6xl font-extrabold leading-tight">
                    Célébrons la
                    <span class="text-accent">CAN 2025</span>
                </h2>

                <h3 class="text-5xl md:text-6xl font-black text-accent mt-2 drop-shadow-lg">
                    Zoo Virtuel ASSAD
                </h3>

                <p class="max-w-2xl mt-6 text-lg text-gray-200 leading-relaxed">
                    Découvrez la majestueuse faune africaine et rencontrez notre emblématique
                    <span class="text-accent font-semibold">Lion de l'Atlas</span>,
                    symbole de force et de fierté du continent africain.
                </p>

                <!-- Buttons -->
                <div class="mt-10 flex flex-wrap justify-center md:justify-start gap-5">
                    <a href="pages/public/animals.php"
                       class="bg-accent text-dark px-8 py-3 rounded-full font-bold
                              hover:shadow-[0_20px_40px_rgba(255,193,7,0.4)]
                              hover:-translate-y-1 transition-all duration-300">
                        Explorer le Zoo
                    </a>

                    <a href="pages/public/lion.php"
                       class="border border-white/50 px-8 py-3 rounded-full
                              hover:shadow-[0_20px_40px_rgba(255,193,7,0.4)]
                              hover:-translate-y-1 transition-all duration-300
                              transition-all duration-300">
                        Voir le Lion de l'Atlas
                    </a>
                </div>

            </div>
        </div>

    </div>
</section>


<!-- ================= ANIMAUX ================= -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-extrabold text-center mb-14">
            🐾 Nos Animaux
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            
        <?php foreach ($animaux as $animal): ?>
            <div class="bg-white rounded-3xl shadow-md overflow-hidden
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                <!-- Image -->
                <div class="relative h-60 overflow-hidden">
                    <img src="actions/uploads/<?= htmlspecialchars($animal['image_animal']) ?>"
                         class="w-full h-full object-cover">

                    <span class="absolute top-4 left-4 bg-[#f59e0b] text-white
                                 text-xs font-semibold px-4 py-1 rounded-full shadow">
                        <?= htmlspecialchars($animal['alimentation']) ?>
                    </span>
                </div>

                <!-- Contenu -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-[#0f172a] mb-2">
                        <?= htmlspecialchars($animal['nom_animal']) ?>
                    </h2>

                    <p class="text-gray-600 text-sm mb-4">
                        <?= htmlspecialchars($animal['description_courte']) ?>
                    </p>

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">
                            <?= htmlspecialchars($animal['pays_origine']) ?>
                        </span>

                        <span class="bg-[#16a34a]/10 text-[#14532d]
                                     font-semibold px-3 py-1 rounded-full">
                            <?= htmlspecialchars($animal['nom_habitat']) ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

        <div class="text-center mt-12">
            <a href="pages/public/animals.php"
               class="bg-accent text-dark px-8 py-3 rounded-full font-bold hover:shadow-xl transition">
                Voir tous les animaux →
            </a>
        </div>
    </div>
</section>

<!-- ================= VISITES ================= -->
<section class="py-24 bg-gray-100">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-extrabold text-center mb-14">
            🧭 Visites Guidées
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="bg-white rounded-2xl h-60 flex items-center justify-center shadow">
                Visite 1
            </div>
            <div class="bg-white rounded-2xl h-60 flex items-center justify-center shadow">
                Visite 2
            </div>
            <div class="bg-white rounded-2xl h-60 flex items-center justify-center shadow">
                Visite 3
            </div>
        </div>
    </div>
    <div class="text-center mt-12">
            <a href="pages/public/animals.php"
               class="bg-accent text-dark px-8 py-3 rounded-full font-bold hover:shadow-xl transition">
                Voir tous les Visites →
            </a>
        </div>
</section>

<!-- ================= FOOTER ================= -->
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
