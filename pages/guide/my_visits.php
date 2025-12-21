<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../../pages/public/login.php');
    exit();
}

// Récupérer les visites du guide connecté
$id_guide = $_SESSION['user']['id_utilisateur'];
$visites = $connexion->query("SELECT * FROM visitesguidees WHERE id_guide = $id_guide ORDER BY date_heure DESC");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Guide | Mes Visites</title>
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
              <img src="../../assets/images/assad_logo.png" alt="Logo Zoo ASSAD" class="w-full h-full object-contain logo-anim">
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

      <button onclick="window.location.href='../../actions/logout.php'" 
              class="group flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-2 rounded-full font-semibold shadow-lg shadow-red-900/30 hover:scale-105 hover:shadow-xl transition-all duration-300">
          <i class='bxr bx-arrow-out-right-square-half' style='color:#fa0d0d'></i>
          <span>Logout</span>
      </button>
  </div>
</header>

<!-- Layout -->
<div class="flex pt-24">

  <!-- Sidebar -->
  <aside class="fixed left-0 top-24 h-[calc(100vh-6rem)] w-64 bg-dark text-white border-r border-white/10">
    <div class="p-6">
      <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-white/90 hover:bg-white/10 hover:text-accent transition-all duration-300 group mb-2">
        <i class='bx bx-dashboard text-xl group-hover:scale-110 transition'></i>
        <span>Page principale</span>
      </a>
      <a href="my_visits.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-accent font-medium hover:bg-white/10 hover:text-accent transition-all duration-300 group mb-2">
        <i class='bx bx-calendar text-xl group-hover:scale-110 transition'></i>
        <span>Mes Visites</span>
      </a>
      <a href="reservations.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
            <i class='bx bx-paw-print text-xl group-hover:scale-110 transition'></i>
            <span>Réservations</span>
        </a>
    </div>
    
  </aside>

  <!-- Main content -->
  <main class="ml-64 w-full p-8">
    <div class="flex justify-between mb-4">
      <h2 class="text-xl font-bold mb-4">Mes Visites Guidées</h2>
      <button onclick="afficher_modal('ajouter-visite-modal')" 
              class="bg-red-700 text-white px-4 rounded-full font-semibold hover:scale-105 transition-all">
        Ajouter visite
      </button>
    </div>

    <table class="w-full text-left border-collapse">
      <thead class="bg-gray-200">
        <tr>
          <th class="px-4 py-2 border border-gray-300">Titre</th>
          <th class="px-4 py-2 border border-gray-300">Date et Heure</th>
          <th class="px-4 py-2 border border-gray-300">Durée</th>
          <th class="px-4 py-2 border border-gray-300">Prix</th>
          <th class="px-4 py-2 border border-gray-300">Langue</th>
          <th class="px-4 py-2 border border-gray-300">Capacité</th>
          <th class="px-4 py-2 border border-gray-300">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($visite = $visites->fetch_assoc()): ?>
        <tr class="hover:bg-gray-100">
          <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($visite['titre']) ?></td>
          <td class="px-4 py-2 border border-gray-300"><?= date('Y-m-d H:i', strtotime($visite['date_heure'])) ?></td>
          <td class="px-4 py-2 border border-gray-300"><?= $visite['duree'] ?> h</td>
          <td class="px-4 py-2 border border-gray-300"><?= $visite['prix'] ?> MAD</td>
          <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($visite['langue']) ?></td>
          <td class="px-4 py-2 border border-gray-300"><?= $visite['capacite_max'] ?></td>
          <td class="px-4 py-2 border border-gray-300 flex gap-2">
            <a href="../../actions/modifier_visite.php?id=<?= $visite['id_visite'] ?>" 
               class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 transition">Modifier</a>
            <a href="../../actions/crud_visite.php?id_supprimer=<?= $visite['id_visite'] ?>" 
               onclick="return confirm('Voulez-vous vraiment supprimer cette visite ?')" 
               class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 transition">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>
</div>

<!-- Modal Ajouter Visite -->
<div id="ajouter-visite-modal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-dark/90 backdrop-blur-lg">
  <div class="z-60 bg-dark/90 backdrop-blur-lg border border-white/10 rounded-2xl shadow-2xl p-8 max-w-md w-full">
    <h2 class="text-2xl font-bold text-center text-accent mb-6">Ajouter Visite</h2>
    <form action="../../actions/crud_visite.php" method="POST" class="space-y-4">
      <input type="text" name="titre" placeholder="Titre" required
             class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-accent focus:outline-none text-white">
      <input type="date" name="date" required
             class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-accent focus:outline-none text-white">
      <input type="time" name="heure_debut" required
             class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-accent focus:outline-none text-white">
      <input type="number" name="duree" placeholder="Durée (h)" required
             class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 focus:ring-2 focus:ring-accent focus:outline-none text-white">
      <input type="number" name="prix" placeholder="Prix (MAD)" required
             class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 focus:ring-2 focus:ring-accent focus:outline-none text-white">
      <input type="text" name="langue" placeholder="Langue" required
             class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 focus:ring-2 focus:ring-accent focus:outline-none text-white">
      <input type="number" name="capacite_max" placeholder="Capacité max" required
             class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 focus:ring-2 focus:ring-accent focus:outline-none text-white">
      <button type="submit" name="ajouter_visite" class="w-full py-3 rounded-lg bg-red-700 text-white font-semibold hover:opacity-90 transition">Ajouter</button>
      <button type="button" onclick="masquer_modal('ajouter-visite-modal')" class="w-full py-3 rounded-lg bg-gray-500 text-white font-semibold hover:opacity-90 transition">Annuler</button>
    </form>
  </div>
</div>

<script>
function afficher_modal(id_modal){
    document.getElementById(id_modal).classList.remove('hidden');
}
function masquer_modal(id_modal){
    document.getElementById(id_modal).classList.add('hidden');
}
</script>

</body>
</html>
