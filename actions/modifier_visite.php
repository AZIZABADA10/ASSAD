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
                                 SET titre=?,  date_heure=?, duree=?, prix=?, langue=?, capacite_max=? 
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
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-gray-100 text-gray-900 font-sans">

<main class="ml-64 w-full p-8">
  <h2 class="text-2xl font-bold mb-6">Modifier Visite</h2>

  <form action="" method="POST" class="space-y-4 max-w-lg bg-white p-6 rounded shadow">
      <input type="text" name="titre" value="<?= htmlspecialchars($visite['titre']) ?>" placeholder="Titre" required
             class="w-full px-4 py-2 border rounded">
      <input type="date" name="date" value="<?= date('Y-m-d', strtotime($visite['date_heure'])) ?>" required
             class="w-full px-4 py-2 border rounded">
      <input type="time" name="heure" value="<?= date('H:i', strtotime($visite['date_heure'])) ?>" required
             class="w-full px-4 py-2 border rounded">
      <input type="number" name="duree" value="<?= $visite['duree'] ?>" placeholder="Durée (h)" required
             class="w-full px-4 py-2 border rounded">
      <input type="number" name="prix" value="<?= $visite['prix'] ?>" placeholder="Prix (MAD)" required
             class="w-full px-4 py-2 border rounded">
      <input type="text" name="langue" value="<?= htmlspecialchars($visite['langue']) ?>" placeholder="Langue" required
             class="w-full px-4 py-2 border rounded">
      <input type="number" name="capacite_max" value="<?= $visite['capacite_max'] ?>" placeholder="Capacité max" required
             class="w-full px-4 py-2 border rounded">

      <button type="submit" name="modifier_visite"
              class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">Modifier</button>
      <a href="my_visits.php" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">Annuler</a>
  </form>
</main>

</body>
</html>
