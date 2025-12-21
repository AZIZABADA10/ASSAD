<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guide') {
    header('Location: ../pages/public/login.php');
    exit();
}

$id_visite = $_GET['id'] ?? null;
$id_guide  = $_SESSION['user']['id_utilisateur'];

if (!$id_visite) {
    header('Location: my_visits.php');
    exit();
}

$stmt = $connexion->prepare("
    SELECT * FROM visitesguidees 
    WHERE id_visite = ? AND id_guide = ?
");
$stmt->bind_param("ii", $id_visite, $id_guide);
$stmt->execute();
$visite = $stmt->get_result()->fetch_assoc();

if (!$visite) {
    header('Location: my_visits.php');
    exit();
}

if (isset($_POST['modifier_visite'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_heure = $_POST['date'] . ' ' . $_POST['heure'];
    $duree = $_POST['duree'];
    $prix = $_POST['prix'];
    $langue = $_POST['langue'];
    $capacite_max = $_POST['capacite_max'];

    $stmt = $connexion->prepare("
        UPDATE visitesguidees 
        SET titre=?, description=?, date_heure=?, duree=?, prix=?, langue=?, capacite_max=?
        WHERE id_visite=? AND id_guide=?
    ");
    $stmt->bind_param(
        "sssidsiii",
        $titre,
        $description,
        $date_heure,
        $duree,
        $prix,
        $langue,
        $capacite_max,
        $id_visite,
        $id_guide
    );
    $stmt->execute();

    header('Location: ../pages/guide/my_visits.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Visite</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-gray-900 text-white">

<div class="flex justify-center items-center min-h-screen">
<div class="bg-gray-800 p-8 rounded-2xl w-full max-w-lg shadow-2xl">

<h2 class="text-2xl font-bold text-yellow-400 text-center mb-6">
Modifier la visite guidée
</h2>

<form method="POST" class="space-y-4">

<input type="text" name="titre" value="<?= htmlspecialchars($visite['titre']) ?>" required
class="w-full px-4 py-2 rounded bg-gray-900 border border-gray-700">

<textarea name="description" placeholder="Description"
class="w-full px-4 py-2 rounded bg-gray-900 border border-gray-700"><?= htmlspecialchars($visite['description']) ?></textarea>

<input type="date" name="date" value="<?= date('Y-m-d', strtotime($visite['date_heure'])) ?>" required
class="w-full px-4 py-2 rounded bg-gray-900 border border-gray-700">

<input type="time" name="heure" value="<?= date('H:i', strtotime($visite['date_heure'])) ?>" required
class="w-full px-4 py-2 rounded bg-gray-900 border border-gray-700">

<input type="number" name="duree" value="<?= $visite['duree'] ?>" required
class="w-full px-4 py-2 rounded bg-gray-900 border border-gray-700">

<input type="number" name="prix" value="<?= $visite['prix'] ?>" required
class="w-full px-4 py-2 rounded bg-gray-900 border border-gray-700">

<input type="text" name="langue" value="<?= htmlspecialchars($visite['langue']) ?>" required
class="w-full px-4 py-2 rounded bg-gray-900 border border-gray-700">

<input type="number" name="capacite_max" value="<?= $visite['capacite_max'] ?>" required
class="w-full px-4 py-2 rounded bg-gray-900 border border-gray-700">

<button type="submit" name="modifier_visite"
class="w-full bg-yellow-400 text-gray-900 font-semibold py-2 rounded hover:bg-yellow-500">
Modifier
</button>

<a href="../pages/guide/my_visits.php"
class="block text-center bg-red-600 py-2 rounded hover:bg-red-700">
Annuler
</a>

</form>
</div>
</div>

</body>
</html>
