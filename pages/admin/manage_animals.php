<?php

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../../actions/logout.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin | gestion d'animaux</title>
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

        
         <button class="bg-red-700 text-white px-5 py-2 rounded-full font-semibold hover:scale-105 transition-all" type="submit" onclick="window.location.href='../../actions/logout.php'">Logout</button>
    </div>
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
                    transition-all duration-300 group">
            <i class='bx bx-dashboard text-xl group-hover:scale-110 transition'></i>
            <span>Page principale</span>
        </a>

        <a href="manage_users.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group">
            <i class='bx bx-community text-xl group-hover:scale-110 transition'></i>
            <span>Utilisateurs</span>
        </a>

        <a href="manage_animals.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    bg-white/10 text-accent font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group">
            <i class='bx bx-paw-print text-xl group-hover:scale-110 transition'></i>
            <span>Animaux</span>
        </a>

        <a href="manage_habitats.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group">
            <i class='bx bx-home text-xl group-hover:scale-110 transition'></i>
            <span>Habitats</span>
        </a>

        <a href="stats.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group">
            <i class='bx bx-chart-line text-xl group-hover:scale-110 transition'></i>
            <span>Statistiques</span>
        </a>

        </nav>
      </div>
    </aside>

    <!-- Main content -->
    <main class="ml-64 w-full p-8">
      <h1 class="text-2xl font-bold mb-4">Bienvenue sur le Dashboard</h1>

      

    </main>

  </div>

</body>
</html>
