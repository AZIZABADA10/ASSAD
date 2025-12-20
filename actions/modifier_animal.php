<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$id = $_GET['id'] ?? null;
$animal = null;

if ($id) {
    $stmt = $connexion->prepare("SELECT * FROM animal WHERE id_animal = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $animal = $stmt->get_result()->fetch_assoc();
}

$erreurs = $_SESSION['update_errors'] ?? [];
unset($_SESSION['update_errors']);

function afficher_erreurs($erreur) {
    return !empty($erreur) ? "<p class='text-red-400 text-sm mt-1'>$erreur</p>" : '';
}

if (isset($_POST['modifier_animal'])) {

    $nom = $_POST['nom_animal'];
    $espace = $_POST['espace'];
    $alimentation = $_POST['alimentation'];
    $pays = $_POST['pays_origine'];
    $description = $_POST['description_courte'];
    $id_habitat = $_POST['id_habitat'];

    $image_name = $animal['image_animal'];

    // Upload image (optionnel)
    if (!empty($_FILES['image_animal']['name'])) {
        $image_name = uniqid() . '_' . $_FILES['image_animal']['name'];
        move_uploaded_file(
            $_FILES['image_animal']['tmp_name'],
            "../uploads/$image_name"
        );
    }

    if (empty($erreurs)) {
        $stmt = $connexion->prepare("
            UPDATE animal SET
                nom_animal = ?,
                espace = ?,
                alimentation = ?,
                image_animal = ?,
                pays_origine = ?,
                description_courte = ?,
                id_habitat = ?
            WHERE id_animal = ?
        ");

        $stmt->bind_param(
            'ssssssii',
            $nom,
            $espace,
            $alimentation,
            $image_name,
            $pays,
            $description,
            $id_habitat,
            $id
        );

        $stmt->execute();
        header('Location: ../pages/admin/manage_animals.php');
        exit();
    } else {
        $_SESSION['update_errors'] = $erreurs;
        header("Location: modifier_animal.php?id=$id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier Animal</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">

<main class="ml-64 w-full p-8">
  <div class="fixed inset-0 z-50 flex justify-center items-center bg-gray-900/80 backdrop-blur-lg">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl p-8 w-full max-w-lg animate-fade-in">

      <h2 class="text-2xl font-bold text-center text-yellow-400 mb-6">
        Modifier Animal
      </h2>

      <form method="POST" enctype="multipart/form-data" class="space-y-4">

        <input type="text" name="nom_animal"
               value="<?= $animal['nom_animal'] ?>"
               placeholder="Nom de l’animal"
               class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white"
               required>

        <input type="text" name="espace"
               value="<?= $animal['espace'] ?>"
               placeholder="Type d’espace"
               class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white">

        <select name="alimentation"
                class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white">
          <option value="herbivore" <?= $animal['alimentation'] === 'herbivore' ? 'selected' : '' ?>>Herbivore</option>
          <option value="carnivore" <?= $animal['alimentation'] === 'carnivore' ? 'selected' : '' ?>>Carnivore</option>
          <option value="omnivore" <?= $animal['alimentation'] === 'omnivore' ? 'selected' : '' ?>>Omnivore</option>
        </select>

        <input type="file" name="image_animal"
               class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white">

        <input type="text" name="pays_origine"
               value="<?= $animal['pays_origine'] ?>"
               placeholder="Pays d’origine"
               class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white">

        <textarea name="description_courte"
                  placeholder="Description courte"
                  class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white"
                  rows="3"><?= $animal['description_courte'] ?></textarea>

        <input type="number" name="id_habitat"
               value="<?= $animal['id_habitat'] ?>"
               placeholder="ID Habitat"
               class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white">

        <button name="modifier_animal"
                class="w-full py-3 rounded-lg bg-yellow-400 text-gray-900 font-semibold hover:bg-yellow-500 hover:scale-105 transition">
          Modifier
        </button>

        <a href="../pages/admin/manage_animals.php"
           class="block text-center py-3 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
          Annuler
        </a>

      </form>
    </div>
  </div>
</main>

<style>
@keyframes fade-in {
  from {opacity:0; transform: translateY(-10px);}
  to {opacity:1; transform: translateY(0);}
}
.animate-fade-in {
  animation: fade-in 0.4s ease-out;
}
</style>

</body>
</html>
