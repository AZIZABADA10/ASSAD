<?php

session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['user'])) {
  header('Location: ../../pages/public/login.php');
  exit();
}




$habitats = $connexion->query("SELECT * FROM habitats ORDER BY id_habitat DESC");
$aminaux = $connexion->query("SELECT * FROM animal ORDER BY id_animal DESC");

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
 <?php
  require '../layouts/header.php';
  ?>


  <!-- Layout -->
  <div class="flex pt-24">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-24 h-[calc(100vh-6rem)] w-64 bg-dark text-white border-r border-white/10">
      <div class="p-6">

        <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    font-medium text-white/90
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
          <i class='bx bx-dashboard text-xl group-hover:scale-110 transition'></i>
          <span>Page principale</span>
        </a>

        <a href="manage_users.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
          <i class='bx bx-community text-xl group-hover:scale-110 transition'></i>
          <span>Utilisateurs</span>
        </a>

        <a href="manage_animals.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    bg-white/10 text-accent font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
          <i class='bx bx-paw-print text-xl group-hover:scale-110 transition'></i>
          <span>Animaux</span>
        </a>

        <a href="manage_habitats.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
          <i class='bx bx-home text-xl group-hover:scale-110 transition'></i>
          <span>Habitats</span>
        </a>

        </nav>
      </div>
    </aside>

    <!-- Main content -->
    <main class="ml-64 w-full p-8">
      <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold mb-4">Gestion des animaux</h2>
        <button onclick="openModal('addAnimalModal')" class="bg-red-700 text-white px-4 py-2 rounded-full
                font-semibold hover:scale-105 transition-all">
          Ajouter animal
        </button>
      </div>
      <table class="w-full text-left border-collapse">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border border-gray-300">Nom animal</th>
            <th class="px-4 py-2 border border-gray-300">Espace</th>
            <th class="px-4 py-2 border border-gray-300">Alimentation</th>
            <th class="px-4 py-2 border border-gray-300">Image</th>
            <th class="px-4 py-2 border border-gray-300">Pays origine</th>
            <th class="px-4 py-2 border border-gray-300">Description</th>
            <th class="px-4 py-2 border border-gray-300">Id habitat</th>
            <th class="px-4 py-2 border border-gray-300">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($animal = $aminaux->fetch_assoc()): ?>
            <tr class="hover:bg-gray-100">
              <td class="px-4 py-2 border border-gray-300"><?= $animal['nom_animal']; ?></td>
              <td class="px-4 py-2 border border-gray-300"><?= $animal['espace']; ?></td>
              <td class="px-4 py-2 border border-gray-300"><?= $animal['alimentation']; ?></td>
              <td class="px-4 py-2 border border-gray-300"><img
                  src="../../actions/uploads/<?= $animal['image_animal']; ?>" class="w-20 h-16 object-cover rounded"></td>
              <td class="px-4 py-2 border border-gray-300"><?= $animal['pays_origine']; ?></td>
              <td class="px-4 py-2 border border-gray-300"><?= $animal['description_courte']; ?></td>
              <td class="px-4 py-2 border border-gray-300"><?= $animal['id_habitat']; ?></td>
              <td class="px-4 py-2 border border-gray-300">
                <div class="flex justify-between ">
                  <a href="../../actions/animals_crud.php?id_supprimer=<?= $animal['id_animal'] ?> "
                    onclick="return confirm('Vous voullez vrément supprimer ce utilisateur?')"> <i class='bxr  bx-trash'
                      style='color:#fa0d0d'></i></a>
                  <a href="../../actions/modifier_animal.php?id=<?= $animal['id_animal']; ?>">
                    <i class='bxr  bx-edit ' style='color:#068b00'></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </main>

  </div>
  <!-- MODAL AJOUT ANIMAL -->
  <div id="addAnimalModal" class="hidden fixed inset-0 z-50 flex items-center justify-center
            bg-black/60 backdrop-blur-sm">

    <div class="bg-dark/90 backdrop-blur-lg border border-white/10
           rounded-2xl shadow-2xl p-8
           w-full max-w-2xl mx-4">

      <!-- HEADER -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-accent">
          Ajouter un Animal
        </h2>

        <button onclick="closeModal('addAnimalModal')" class="text-white hover:text-red-500 text-2xl">
          ✕
        </button>
      </div>

      <!-- FORM -->
      <form method="POST" action="../../actions/animals_crud.php" enctype="multipart/form-data" class="space-y-4">

        <input type="text" name="nom" placeholder="Nom de l'animal" required class="w-full px-4 py-3 rounded-lg bg-transparent
                border border-white/20 placeholder-gray-400
                focus:ring-2 focus:ring-accent focus:outline-none text-white">

        <input type="text" name="espace" placeholder="espace de l'animal" required class="w-full px-4 py-3 rounded-lg bg-transparent
                border border-white/20 placeholder-gray-400
                focus:ring-2 focus:ring-accent focus:outline-none text-white">


        <select name="alimentation" required class="w-full px-4 py-3 rounded-lg bg-dark
                border border-white/20 text-white
                focus:ring-2 focus:ring-accent focus:outline-none">
          <option value="">Type alimentaire</option>
          <option value="carnivore">🥩 Carnivore</option>
          <option value="herbivore">🌿 Herbivore</option>
          <option value="omnivore">🍽️ Omnivore</option>
        </select>

        <select name="habitat" required class="w-full px-4 py-3 rounded-lg bg-dark
                border border-white/20 text-white
                focus:ring-2 focus:ring-accent focus:outline-none">
          <option value="">Habitat</option>
          <?php foreach ($habitats as $h): ?>
            <option value="<?= intval($h['id_habitat']) ?>">
              <?= $h['nom_habitat'] ?>
            </option>
          <?php endforeach; ?>
        </select>

        <input type="text" name="pays_origine" placeholder="espace de l'animal" required class="w-full px-4 py-3 rounded-lg bg-transparent
                border border-white/20 placeholder-gray-400
                focus:ring-2 focus:ring-accent focus:outline-none text-white">

        <input type="text" name="description_courte" placeholder="espace de l'animal" required class="w-full px-4 py-3 rounded-lg bg-transparent
          border border-white/20 placeholder-gray-400
          focus:ring-2 focus:ring-accent focus:outline-none text-white">

        <input type="file" name="image" class="w-full px-4 py-2 rounded-lg text-white
          border border-white/20 bg-transparent">

        <button type="submit" name="ajouter_animal" class="w-full py-3 rounded-lg bg-accent text-dark
        font-semibold hover:opacity-90 transition">
          Enregistrer
        </button>

      </form>
    </div>
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