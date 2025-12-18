<?php

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../../pages/public/login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin | Gestion d'habitat</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../../assets/js/tailwind-config.js"></script>
  <link rel="shortcut icon" href="../../assets/images/assad_logo.png" type="image/x-icon">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-light text-dark font-sans">

  <!-- Header -->
  <header class="fixed top-0 w-full z-30 bg-dark/90 backdrop-blur-md border-b border-white/10">
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
                    transition-all duration-300 group  mb-2">
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
                    bg-white/10 text-accent font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
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
      <div class="flex justify-between">
        <h2 class="text-xl font-bold mb-4">Gestion des habitats</h2>
        <button
        onclick="afficher_modal('habitatModalAdd')"
         class="bg-red-700 text-white px-4 rounded-full font-semibold hover:scale-105 transition-all"
        >Ajouter habitat</button>
      </div>

    </main>

  </div>


<div id="habitatModalAdd" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-dark/90 backdrop-blur-lg">
  <div class="modal w-[700px] bg-dark/80 border border-white/10 rounded-2xl shadow-2xl p-8">
    <div class="flex justify-between">
      <h2 class="text-2xl font-bold mb-4 text-accent">Ajouter un Habitat</h2>
      <button onclick="Masquer_modal('habitatModalAdd')" class="text-gray-500 text-xl">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <form method="POST" action="actions/ajouter_habitat.php">
      <label class="text-white/70">Nom de l'habitat</label>
      <input type="text" name="nom_habitat" required 
      class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-accent focus:outline-none text-white">
      <label class="text-white/70">Type de climat</label>
       <select name="type_climat" required class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-accent focus:outline-none text-white">
        <option 
        class="w-full px-4 py-3 rounded-lg bg-transparent border text-white"
        value="">Sélectionner un type de climat</option>
        <option 
        class="bg-red border text-black"
        value="Tropical">Tropical</option>
        <option 
        class="w-full px-4 py-3 rounded-lg bg-transparent border text-black"
        value="Tempéré">Tempéré</option>
        <option 
        class="w-full px-4 py-3 rounded-lg bg-transparent border text-black"
        value="Désertique">Désertique</option>
        <option 
        class="w-full px-4 py-3 rounded-lg bg-transparent border text-black"
        value="Montagneux">Montagneux</option>
        
      </select> 
      <label class="text-white/70">Zone zoo</label>
      <input type="text" name="zonezoo" required 
      class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20  placeholder-gray-400 focus:ring-2 focus:ring-accent focus:outline-none text-white">
      <label class="text-white/70">Description</label>
      <textarea name="description_habitat" required class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-accent focus:outline-none text-white"></textarea>
      <div>
        <button type="submit" name="ajouter_habitat" class="w-full py-3 rounded-lg bg-accent text-dark font-semibold hover:opacity-90 transition">
          Ajouter
        </button>
        <button onclick="Masquer_modal('habitatModalAdd')" class="w-full mt-2 py-3 rounded-lg bg-transparent border border-white/20 text-white hover:bg-white/10 transition">
          Annuler
        </button>
      </div>
    </form>
  </div>
</div>

  <script>
    function afficher_modal(id_modal){
      document.getElementById(id_modal).classList.remove('hidden');
      // console.log("test function afficher modal!");
    }
    function Masquer_modal(id_modal){
      document.getElementById(id_modal).classList.add('hidden');
    }
  </script>
</body>
</html>
