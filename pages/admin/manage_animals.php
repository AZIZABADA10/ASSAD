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
        onclick="afficher_modal('s-inscrire-form')"
         class="bg-red-700 text-white px-4 rounded-full font-semibold hover:scale-105 transition-all"
        >Ajouter animal</button>
      </div>
            <div id="addAnimalModal" class="modal">
                <div class="modal-content bg-white rounded-3xl shadow-2xl p-8 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-3xl font-bold text-gray-800">
                            <i class="fas fa-paw text-purple-500 mr-3"></i>
                            <span id="modalTitle">Ajouter un Animal</span>
                        </h2>
                        <button onclick="closeModal('addAnimalModal')" class="text-gray-500 hover:text-gray-700 text-2xl">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <form id="animalForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="animalId" name="id">
            
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-tag mr-2"></i>Nom de l'animal
                            </label>
                            <input type="text" name="nom" id="animalNom" required 
                                class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition"
                                placeholder="Ex: Lion, Éléphant...">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-utensils mr-2"></i>Type Alimentaire
                            </label>
                            <select name="type_alimentaire" id="animalType" required 
                                    class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition">
                                <option value="">Sélectionner...</option>
                                <option value="carnivore">🥩 Carnivore</option>
                                <option value="herbivore">🌿 Herbivore</option>
                                <option value="omnivore">🍽️ Omnivore</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-tree mr-2"></i>Habitat
                            </label>
                            <select name="habitat" id="animalHabitat" required 
                                    class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition">
                                <option value="" disabled selected>Sélectionner...</option>
                                <?php foreach ($habitats as $h): ?>
                                    <option value="<?= $h['id'] ?>"><?= $h['nom_habitat'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-image mr-2"></i>Image de l'animal
                            </label>
                            <div class="border-2 border-dashed border-purple-300 rounded-xl p-6 text-center hover:border-purple-500 transition">
                                <input type="file" name="image" id="animalImage" accept="image/*" 
                                    class="hidden" onchange="previewImage(event)">
                                <label for="animalImage" class="cursor-pointer">
                                    <div id="imagePreview" class="mb-4">
                                        <i class="fas fa-cloud-upload-alt text-6xl text-purple-300 mb-2"></i>
                                        <p class="text-gray-600">Cliquez pour télécharger une image</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 btn-primary bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg">
                                <i class="fas fa-save mr-2"></i>Enregistrer
                            </button>
                            <button type="button" onclick="closeModal('addAnimalModal')" 
                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 rounded-xl transition">
                                <i class="fas fa-times mr-2"></i>Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
      

    </main>

  </div>


  

</body>
</html>
