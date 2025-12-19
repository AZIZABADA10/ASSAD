<?php

session_start();

require_once '../../config/db.php';


if (!isset($_SESSION['user'])) {
    header('Location: ../../pages/public/login.php');
    exit();
}





// Total utilisateurs
$total_users = $connexion->query("SELECT COUNT(*) total FROM utilisateurs")->fetch_assoc()['total'];

// Admin
$total_admin = $connexion->query("SELECT COUNT(*) total FROM utilisateurs WHERE role='admin'")->fetch_assoc()['total'];

// Guide
$total_guide = $connexion->query("SELECT COUNT(*) total FROM utilisateurs WHERE role='guide'")->fetch_assoc()['total'];

// Visiteur
$total_visiteur = $connexion->query("SELECT COUNT(*) total FROM utilisateurs WHERE role='visiteur'")->fetch_assoc()['total'];

// Total animaux
$total_animaux = $connexion->query("SELECT COUNT(*) total FROM animal")->fetch_assoc()['total'];

// Total habitats
$total_habitats = $connexion->query("SELECT COUNT(*) total FROM habitats")->fetch_assoc()['total'];

$animaux_alimentation = $connexion->query("
    SELECT alimentation, COUNT(*) total
    FROM animal
    GROUP BY alimentation
");


?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin | Statistiques</title>
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

        
<button
  onclick="window.location.href='../../actions/logout.php'"
  class="group flex items-center gap-2
         bg-gradient-to-r from-red-600 to-red-700
         text-white px-6 py-2 rounded-full font-semibold
         shadow-lg shadow-red-900/30
         hover:scale-105 hover:shadow-xl
         transition-all duration-300">

    <i class='bxr  bx-arrow-out-right-square-half' style='color:#fa0d0d'></i> 

    <span>Logout</span>
</button>    </div>
  </header>

  <!-- Layout -->
  <div class="flex pt-24">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-24 h-[calc(100vh-6rem)] w-64 bg-dark text-white border-r border-white/10">
      <div class="p-6">

        <a href="dashboard.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    font-medium text-white/90
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
            <i class='bx bx-dashboard text-xl group-hover:scale-110 transition'></i>
            <span>Page principale</span>
        </a>

        <a href="manage_users.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
            <i class='bx bx-community text-xl group-hover:scale-110 transition'></i>
            <span>Utilisateurs</span>
        </a>

        <a href="manage_animals.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
            <i class='bx bx-paw-print text-xl group-hover:scale-110 transition'></i>
            <span>Animaux</span>
        </a>

        <a href="manage_habitats.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
            <i class='bx bx-home text-xl group-hover:scale-110 transition'></i>
            <span>Habitats</span>
        </a>

        <a href="stats.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    bg-white/10 text-accent font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
            <i class='bx bx-chart-line text-xl group-hover:scale-110 transition'></i>
            <span>Statistiques</span>
        </a>

        </nav>
      </div>
    </aside>
    <main>   
    <main class="ml-64 w-full p-10">

  <!-- TITRE -->
  <h2 class="text-3xl font-extrabold mb-10 flex items-center gap-3">
    <i class='bx bx-chart text-accent'></i>
    Statistiques générales
  </h2>

  <!-- ================= CARTES PRINCIPALES ================= -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">

    <!-- Utilisateurs -->
    <div class="group relative p-8 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700
                text-white shadow-xl hover:-translate-y-2 hover:shadow-2xl
                transition-all duration-300">
      <i class='bx bx-user text-6xl opacity-20 absolute right-6 bottom-6'></i>
      <p class="text-5xl font-black"><?= $total_users ?></p>
      <span class="text-lg font-semibold mt-2 block">Utilisateurs</span>
    </div>

    <!-- Admin -->
    <div class="group relative p-8 rounded-2xl bg-gradient-to-br from-red-500 to-red-700
                text-white shadow-xl hover:-translate-y-2 hover:shadow-2xl
                transition-all duration-300">
      <i class='bx bx-shield-quarter text-6xl opacity-20 absolute right-6 bottom-6'></i>
      <p class="text-5xl font-black"><?= $total_admin ?></p>
      <span class="text-lg font-semibold mt-2 block">Admins</span>
    </div>

    <!-- Guides -->
    <div class="group relative p-8 rounded-2xl bg-gradient-to-br from-green-500 to-green-700
                text-white shadow-xl hover:-translate-y-2 hover:shadow-2xl
                transition-all duration-300">
      <i class='bx bx-map text-6xl opacity-20 absolute right-6 bottom-6'></i>
      <p class="text-5xl font-black"><?= $total_guide ?></p>
      <span class="text-lg font-semibold mt-2 block">Guides</span>
    </div>

    <!-- Visiteurs -->
    <div class="group relative p-8 rounded-2xl bg-gradient-to-br from-yellow-400 to-yellow-600
                text-white shadow-xl hover:-translate-y-2 hover:shadow-2xl
                transition-all duration-300">
      <i class='bx bx-group text-6xl opacity-20 absolute right-6 bottom-6'></i>
      <p class="text-5xl font-black"><?= $total_visiteur ?></p>
      <span class="text-lg font-semibold mt-2 block">Visiteurs</span>
    </div>

    <!-- Animaux -->
    <div class="group relative p-8 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-700
                text-white shadow-xl hover:-translate-y-2 hover:shadow-2xl
                transition-all duration-300">
      <i class='bx bx-paw text-6xl opacity-20 absolute right-6 bottom-6'></i>
      <p class="text-5xl font-black"><?= $total_animaux ?></p>
      <span class="text-lg font-semibold mt-2 block">Animaux</span>
    </div>

    <!-- Habitats -->
    <div class="group relative p-8 rounded-2xl bg-gradient-to-br from-teal-500 to-teal-700
                text-white shadow-xl hover:-translate-y-2 hover:shadow-2xl
                transition-all duration-300">
      <i class='bx bx-home text-6xl opacity-20 absolute right-6 bottom-6'></i>
      <p class="text-5xl font-black"><?= $total_habitats ?></p>
      <span class="text-lg font-semibold mt-2 block">Habitats</span>
    </div>

  </div>

  <!-- ================= ALIMENTATION ================= -->
  <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
    Animaux par type alimentaire
  </h3>

  <<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  <?php 
    $colors = [
      'Herbivore' => 'from-green-400 to-green-600',
      'Carnivore' => 'from-red-400 to-red-600',
      'Omnivore'  => 'from-yellow-400 to-yellow-600',
      'Autre'     => 'from-purple-400 to-purple-600'
    ];
  ?>
  <?php while($row = $animaux_alimentation->fetch_assoc()): ?>
    <?php 
      $type = ucfirst($row['alimentation']);
      $bg = $colors[$type] ?? 'from-gray-400 to-gray-600';
    ?>
    <div class="relative p-8 rounded-2xl text-white shadow-xl
                bg-gradient-to-br <?= $bg ?>
                hover:scale-105 hover:shadow-2xl
                transition-all duration-300 group overflow-hidden">
      
      <!-- Icon en arrière-plan -->
      <i class='bx bx-paw absolute text-8xl opacity-20 right-4 bottom-4'></i>
      
      <!-- Nombre d'animaux -->
      <p class="text-5xl font-extrabold mb-2"><?= $row['total'] ?></p>
      
      <!-- Type d'alimentation -->
      <span class="text-lg font-semibold"><?= $type ?></span>
      
      <!-- Petite animation de barre -->
      <div class="h-2 w-full bg-white/20 rounded-full mt-4 overflow-hidden">
        <div class="h-full bg-white rounded-full animate-[grow_1.5s_ease-in-out]"></div>
      </div>
    </div>
  <?php endwhile; ?>
</div>


</main>

    </main>

  </div>

</body>
</html>
