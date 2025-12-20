
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

$habitats = $connexion
    ->query("SELECT id_habitat, nom_habitat FROM habitats")->fetch_all(MYSQLI_ASSOC);

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

    if (!empty($_FILES['image_animal']['name'])) {
        $image_name = uniqid() . '.' . $_FILES['image_animal']['name'];
        move_uploaded_file(
            $_FILES['image_animal']['tmp_name'],
            "../actions/uploads/$image_name"
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier Habitat</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../assets/js/tailwind-config.js"></script>
  <link rel="shortcut icon" href="../assets/images/assad_logo.png" type="image/x-icon">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-light text-dark font-sans">

  <!-- Header -->
  <header class="fixed top-0 w-full z-50 bg-dark/90 backdrop-blur-md border-b border-white/10">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4 text-white">
        <div class="flex items-center gap-3 group cursor-pointer">
            <div class="relative w-15 h-16">
                <img 
                    src="../assets/images/assad_logo.png" 
                    alt="Logo Zoo ASSAD"
                    class="w-full h-full object-contain logo-anim"
                >
            </div>
            <h1 class="text-xl font-bold tracking-wide transition-colors duration-300 group-hover:text-accent">
                Zoo ASSAD
            </h1>
        </div>

        <nav class="hidden md:flex gap-8 font-medium">
            <a href="../index.php" class="hover:text-accent transition">Accueil</a>
            <a href="../public/animals.php" class="hover:text-accent transition">Animaux</a>
            <a href="../public/visits.php" class="hover:text-accent transition">Visites Guidées</a>
            <a href="../public/lion.php" class="hover:text-accent transition">Lion de l'Atlas</a>
        </nav>

        
         <button class="bg-red-700 text-white px-5 py-2 rounded-full font-semibold hover:scale-105 transition-all" type="submit" onclick="window.location.href='../actions/logout.php'">Logout</button>
    </div>
  </header>

  <!-- Layout -->
  <div class="flex pt-24">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-24 h-[calc(100vh-6rem)]  w-64 bg-dark text-white border-r border-white/10">
      <div class="p-6 ">

        <a href="dashboard.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    font-medium bg-white/10 text-accent
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
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
                    text-white/90 font-medium
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

    <!-- Overlay sans scroll, centré verticalement -->
    <div class="fixed inset-0  z-50 flex justify-center items-center bg-gray-900/80 backdrop-blur-lg"> 
        <!-- Container du formulaire avec scroll interne -->
        <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto animate-fade-in"> 
            <div class="p-6">
                <h2 class="text-2xl font-bold text-center text-yellow-400 mb-4">Modifier Animal</h2> 
                
                <form method="POST" enctype="multipart/form-data" class="space-y-3"> 
                    <!-- Ligne 1: Nom et Espace (2 colonnes) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1">Nom de l'animal</label>
                            <input type="text" name="nom_animal" value="<?= htmlspecialchars($animal['nom_animal']) ?>" 
                            placeholder="Nom de l'animal" 
                            class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-700 text-white focus:ring-2 focus:ring-yellow-400 focus:outline-none" required>
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1">Type d'espace</label>
                            <input type="text" name="espace" value="<?= htmlspecialchars($animal['espace']) ?>" 
                            placeholder="Type d'espace" 
                            class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-700 text-white focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        </div>
                    </div>

                    <!-- Ligne 2: Alimentation et Pays (2 colonnes) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1">Alimentation</label>
                            <select name="alimentation" 
                            class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-700 text-white focus:ring-2 focus:ring-yellow-400 focus:outline-none"> 
                                <option value="herbivore" <?= $animal['alimentation'] === 'herbivore' ? 'selected' : '' ?>>Herbivore</option> 
                                <option value="carnivore" <?= $animal['alimentation'] === 'carnivore' ? 'selected' : '' ?>>Carnivore</option> 
                                <option value="omnivore" <?= $animal['alimentation'] === 'omnivore' ? 'selected' : '' ?>>Omnivore</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1">Pays d'origine</label>
                            <input type="text" name="pays_origine" value="<?= htmlspecialchars($animal['pays_origine']) ?>" 
                            placeholder="Pays d'origine" 
                            class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-700 text-white focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        </div>
                    </div>

                    <!-- Image (pleine largeur) -->
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-1">Image de l'animal</label>
                        <input type="file" name="image_animal" accept="image/*"
                        class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-700 text-white text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-yellow-400 file:text-gray-900 file:text-sm file:font-semibold hover:file:bg-yellow-500">
                        <?php if ($animal['image_animal']): ?>
                            <p class="text-gray-400 text-xs mt-1">Image actuelle: <?= htmlspecialchars($animal['image_animal']) ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Habitat (pleine largeur) -->
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-1">Habitat</label>
                        <select name="id_habitat" 
                        class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-700 text-white focus:ring-2 focus:ring-yellow-400 focus:outline-none" required>
                            <option value="">Sélectionner un habitat</option>
                            <?php foreach ($habitats as $habitat): ?> 
                                <option value="<?= $habitat['id_habitat'] ?>" 
                                    <?= $habitat['id_habitat'] == $animal['id_habitat'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($habitat['nom_habitat']) ?>
                                </option>
                            <?php endforeach; ?> 
                        </select>
                    </div>

                    <!-- Description (pleine largeur) -->
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-1">Description courte</label>
                        <textarea name="description_courte" placeholder="Description courte" 
                        class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-700 text-white h-12 focus:ring-2 focus:ring-yellow-400 focus:outline-none  resize-none" 
                        rows="3"><?= htmlspecialchars($animal['description_courte']) ?></textarea>
                    </div>

                    <!-- Boutons (2 colonnes) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-2">
                        <button type="submit" name="modifier_animal" 
                        class="w-full py-2.5 rounded-lg bg-yellow-400 text-gray-900 font-semibold hover:bg-yellow-500 hover:scale-105 transition-all">
                            Modifier
                        </button>

                        <a href="../pages/admin/manage_animals.php" 
                        class="flex items-center justify-center py-2.5 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition-all">
                            Annuler
                        </a>
                    </div>
                </form> 
            </div>
        </div> 
    </div> 
</main>

<style> 
@keyframes fade-in { 
    from {
        opacity: 0; 
        transform: translateY(-10px);
    } 
    to {
        opacity: 1; 
        transform: translateY(0);
    } 
}

.animate-fade-in { 
    animation: fade-in 0.4s ease-out; 
}

/* Custom scrollbar pour le formulaire */
.overflow-y-auto::-webkit-scrollbar {
    width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #1f2937;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #4b5563;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
}
</style>

</body>
</html>
      
