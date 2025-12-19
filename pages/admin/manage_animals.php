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
                    transition-all duration-300 group  mb-2">
            <i class='bx bx-dashboard text-xl group-hover:scale-110 transition'></i>
            <span>Page principale</span>
        </a>

        <a href="manage_users.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
            <i class='bx bx-community text-xl group-hover:scale-110 transition'></i>
            <span>Utilisateurs</span>
        </a>

        <a href="manage_animals.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    bg-white/10 text-accent font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
            <i class='bx bx-paw-print text-xl group-hover:scale-110 transition'></i>
            <span>Animaux</span>
        </a>

        <a href="manage_habitats.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
            <i class='bx bx-home text-xl group-hover:scale-110 transition'></i>
            <span>Habitats</span>
        </a>

        <a href="stats.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
            <i class='bx bx-chart-line text-xl group-hover:scale-110 transition'></i>
            <span>Statistiques</span>
        </a>

        </nav>
      </div>
    </aside>

    <!-- Main content -->
    <main class="ml-64 w-full p-8">
      <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold mb-4">Gestion des animaux</h2>
        <button
  onclick="openModal('addAnimalModal')"
  class="bg-red-700 text-white px-4 py-2 rounded-full
         font-semibold hover:scale-105 transition-all">
  Ajouter animal
</button>

      </div>
      <!-- MODAL AJOUT ANIMAL -->
<div id="addAnimalModal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center
            bg-black/60 backdrop-blur-sm">

  <div
    class="bg-dark/90 backdrop-blur-lg border border-white/10
           rounded-2xl shadow-2xl p-8
           w-full max-w-2xl mx-4">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-accent">
        Ajouter un Animal
      </h2>

      <button onclick="closeModal('addAnimalModal')"
              class="text-white hover:text-red-500 text-2xl">
        ✕
      </button>
    </div>

    <!-- FORM -->
    <form method="POST" enctype="multipart/form-data" class="space-y-4">

      <input type="text" name="nom" placeholder="Nom de l'animal" required
        class="w-full px-4 py-3 rounded-lg bg-transparent
               border border-white/20 placeholder-gray-400
               focus:ring-2 focus:ring-accent focus:outline-none text-white">

      <select name="type_alimentaire" required
        class="w-full px-4 py-3 rounded-lg bg-dark
               border border-white/20 text-white
               focus:ring-2 focus:ring-accent focus:outline-none">
        <option value="">Type alimentaire</option>
        <option value="carnivore">🥩 Carnivore</option>
        <option value="herbivore">🌿 Herbivore</option>
        <option value="omnivore">🍽️ Omnivore</option>
      </select>

      <select name="habitat" required
        class="w-full px-4 py-3 rounded-lg bg-dark
               border border-white/20 text-white
               focus:ring-2 focus:ring-accent focus:outline-none">
        <option value="">Habitat</option>
        <?php foreach ($habitats as $h): ?>
          <option value="<?= $h['id'] ?>">
            <?= $h['nom_habitat'] ?>
          </option>
        <?php endforeach; ?>
      </select>

      <input type="file" name="image"
        class="w-full px-4 py-2 rounded-lg text-white
               border border-white/20 bg-transparent">

      <button type="submit"
        class="w-full py-3 rounded-lg bg-accent text-dark
               font-semibold hover:opacity-90 transition">
        Enregistrer
      </button>

    </form>
  </div>
</div>

      

    </main>

  </div>


  <script>
  function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
  }

  function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
  }
</script>


</body>
</html>
