<?php
session_start();
require_once '../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: my_visits.php');
    exit();
}

// Récupérer la visite
$stmt = $connexion->prepare("SELECT * FROM visitesguidees WHERE id_visite = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$visite = $stmt->get_result()->fetch_assoc();

if (!$visite) {
    header('Location: my_visits.php');
    exit();
}

// Traitement du formulaire
if (isset($_POST['modifier_visite'])) {
    $titre = $_POST['titre'];
    $date_heure = $_POST['date'] . ' ' . $_POST['heure'];
    $duree = $_POST['duree'];
    $prix = $_POST['prix'];
    $langue = $_POST['langue'];
    $capacite_max = $_POST['capacite_max'];

    $stmt = $connexion->prepare("UPDATE visitesguidees 
                                 SET titre=?, date_heure=?, duree=?, prix=?, langue=?, capacite_max=? 
                                 WHERE id_visite=?");
    $stmt->bind_param("ssidsii", $titre, $date_heure, $duree, $prix, $langue, $capacite_max, $id);
    $stmt->execute();

    header('Location: ../pages/guide/my_visits.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier Visite</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="shortcut icon" href="../assets/images/assad_logo.png" type="image/x-icon">
<link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-gray-100 text-gray-900 font-sans">

<!-- Header -->
<header class="fixed top-0 w-full z-50 bg-gray-900/90 backdrop-blur-md border-b border-gray-200/10">
  <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4 text-white">
      <div class="flex items-center gap-3 group cursor-pointer">
          <div class="relative w-12 h-12">
              <img src="../assets/images/assad_logo.png" alt="Logo Zoo ASSAD" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105">
          </div>
          <h1 class="text-xl font-bold tracking-wide transition-colors duration-300 group-hover:text-yellow-400">
              Zoo ASSAD
          </h1>
      </div>

      <nav class="hidden md:flex gap-8 font-medium">
          <a href="../index.php" class="hover:text-yellow-400 transition">Accueil</a>
          <a href="../public/animals.php" class="hover:text-yellow-400 transition">Animaux</a>
          <a href="../public/visits.php" class="hover:text-yellow-400 transition">Visites Guidées</a>
          <a href="../public/lion.php" class="hover:text-yellow-400 transition">Lion de l'Atlas</a>
      </nav>

      <button class="bg-red-600 text-white px-5 py-2 rounded-full font-semibold hover:scale-105 transition-transform" type="button" onclick="window.location.href='../actions/logout.php'">Logout</button>
  </div>
</header>

<!-- Sidebar -->
<aside class="fixed left-0 top-24 h-[calc(100vh-6rem)] w-64 bg-gray-900 text-white border-r border-gray-200/10">
  <div class="p-6 flex flex-col gap-2">
    <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-yellow-400/20 text-yellow-400 font-medium hover:scale-105 transition-transform">
        <i class='bx bx-dashboard text-xl'></i>
        <span>Page principale</span>
    </a>

    <a href="my_visits.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-yellow-400/20 hover:text-yellow-400 transition-transform">
        <i class='bx bx-calendar text-xl'></i>
        <span>Mes Visites</span>
    </a>
  </div>
</aside>

<!-- Main content -->
<main class="ml-64 w-full p-8">
  <!-- Modale Modifier visite -->
  <div id="visit-form-modal" class="fixed inset-0 z-50 flex justify-center items-center bg-gray-900/80 backdrop-blur-lg">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl p-8 w-full max-w-md animate-fade-in">
        <h2 class="text-2xl font-bold text-center text-yellow-400 mb-6">
            Modifier Visite Guidée
        </h2>
        <form action="modifier_visite.php?id=<?= $visite['id_visite']?>" method="POST" class="space-y-4">
            <input type="text" name="titre" placeholder="Titre" value="<?= htmlspecialchars($visite['titre']) ?>"
                   class="w-full px-4 py-2 rounded-lg bg-gray-900 border border-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-white" required>

            <input type="date" name="date" value="<?= date('Y-m-d', strtotime($visite['date_heure'])) ?>" required
                   class="w-full px-4 py-2 rounded-lg bg-gray-900 border border-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-white">
            <input type="time" name="heure" value="<?= date('H:i', strtotime($visite['date_heure'])) ?>" required
                   class="w-full px-4 py-2 rounded-lg bg-gray-900 border border-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-white">

            <input type="number" name="duree" placeholder="Durée (h)" value="<?= $visite['duree'] ?>" required
                   class="w-full px-4 py-2 rounded-lg bg-gray-900 border border-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-white">
            <input type="number" name="prix" placeholder="Prix (MAD)" value="<?= $visite['prix'] ?>" required
                   class="w-full px-4 py-2 rounded-lg bg-gray-900 border border-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-white">
            <input type="text" name="langue" placeholder="Langue" value="<?= htmlspecialchars($visite['langue']) ?>" required
                   class="w-full px-4 py-2 rounded-lg bg-gray-900 border border-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-white">
            <input type="number" name="capacite_max" placeholder="Capacité max" value="<?= $visite['capacite_max'] ?>" required
                   class="w-full px-4 py-2 rounded-lg bg-gray-900 border border-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-white">

            <!-- Bouton Modifier -->
            <button type="submit" name="modifier_visite"
                class="w-full py-2 rounded-lg bg-yellow-400 text-gray-900 font-semibold shadow-lg hover:bg-yellow-500 hover:scale-105 transition-all duration-300">
                Modifier
            </button>

            <!-- Bouton Annuler -->
            <a href="../pages/guide/my_visits.php"
               class="w-full mt-4 py-2 rounded-lg bg-red-600 text-white font-semibold shadow-lg hover:bg-red-700 hover:scale-105 transition-all duration-300 flex justify-center items-center">
               Annuler
            </a>
        </form>
    </div>
  </div>
</main>

<style>
@keyframes fade-in { from {opacity:0; transform: translateY(-10px);} to {opacity:1; transform: translateY(0);} }
.animate-fade-in { animation: fade-in 0.4s ease-out; }
</style>
</body>
</html>
