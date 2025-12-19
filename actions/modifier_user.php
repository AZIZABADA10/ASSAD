<?php
session_start();
require_once __DIR__ .'/../config/db.php';

$id = $_GET['id'] ?? null;
$user = null;

if ($id) {
    $stmt = $connexion->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}

$erreurs = $_SESSION['update_errors'] ?? [];
unset($_SESSION['update_errors']);

function afficher_erreurs($erreur) {
    return !empty($erreur) ? "<p class='text-red-400 text-sm mt-1'>$erreur</p>" : '';
}

if (isset($_POST['modifier_user'])) {
    $erreurs = [];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $pattern_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";
    if (!preg_match($pattern_email, $email)) {
        $erreurs['email_error'] = "L'adresse email n'est pas valide (format attendu: nom@exemple.com).";
    }

    // Vérification email existant (exclut l'utilisateur actuel)
    $email_exist = $connexion->prepare("SELECT * FROM utilisateurs WHERE email = ? AND id_utilisateur != ?");
    $email_exist->bind_param('si', $email, $id);
    $email_exist->execute();
    if ($email_exist->get_result()->num_rows > 0) {
        $erreurs['email_existe'] = 'Email déjà existant';
    }

    // Mot de passe (facultatif)
    if (!empty($password)) {
        if (strlen($password) < 6) {
            $erreurs['password_error'] = "Le mot de passe doit faire au moins 6 caractères.";
        } else {
            $password_hache = password_hash($password, PASSWORD_DEFAULT);
        }
    } else {
        $password_hache = $user['mot_de_passe'];
    }

    if (empty($erreurs)) {
        $statut_de_compet = ($role === 'guide') ? 'en_attend' : 'active';
        $stmt = $connexion->prepare("UPDATE utilisateurs 
                                     SET nom_complet=?, mot_de_passe=?, email=?, `role`=?, statut_de_compet=? 
                                     WHERE id_utilisateur=?");
        $stmt->bind_param('sssssi', $nom, $password_hache, $email, $role, $statut_de_compet, $id);
        $stmt->execute();

        header('Location: ../pages/admin/manage_users.php');
        exit();
    } else {
        $_SESSION['update_errors'] = $erreurs;
        header("Location: ../actions/modifier_user.php?id=$id");
        exit();
    }
}
?>




?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier Utilisateur</title>
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

      <a href="manage_users.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-yellow-400/20 hover:text-yellow-400 transition-transform">
          <i class='bx bx-community text-xl'></i>
          <span>Utilisateurs</span>
      </a>

      <a href="manage_animals.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-yellow-400/20 hover:text-yellow-400 transition-transform">
          <i class='bx bx-paw-print text-xl'></i>
          <span>Animaux</span>
      </a>

      <a href="manage_habitats.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-yellow-400/20 hover:text-yellow-400 transition-transform">
          <i class='bx bx-home text-xl'></i>
          <span>Habitats</span>
      </a>

      <a href="stats.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-yellow-400/20 hover:text-yellow-400 transition-transform">
          <i class='bx bx-chart-line text-xl'></i>
          <span>Statistiques</span>
      </a>
    </div>
  </aside>

  <!-- Main content -->
  <main class="ml-64 w-full p-8">
    <!-- Modale Ajouter / Modifier utilisateur -->
    <div id="user-form-modal" class="fixed inset-0 z-50 flex justify-center items-center bg-gray-900/80 backdrop-blur-lg">
      <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl p-8 w-full max-w-md animate-fade-in">
          <h2 class="text-2xl font-bold text-center text-yellow-400 mb-6">
              Modifier Utilisateur
          </h2>
          <form action="modifier_user.php?id=<?= $user['id_utilisateur']?>" method="POST" class="space-y-4">
              <input type="text" name="nom" placeholder="Nom complet" value="<?= $user['nom_complet']?>"
                     class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-white" required>

              <input type="email" name="email" placeholder="Email" value="<?= $user['email'] ?>"
                     class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-white" required>
              <?= afficher_erreurs($erreurs['email_existe'] ?? ''); ?>
              <?= afficher_erreurs($erreurs['email_error'] ?? ''); ?>

              <input type="password" name="password" placeholder="Mot de passe"
                     class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-white" 
                     value="<?= $user['mot_de_passe']  ?>"
                     >
              <?= afficher_erreurs($erreurs['password_error'] ?? ''); ?>

              <select name="role" class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white focus:ring-2 focus:ring-yellow-400 focus:outline-none" required>
                  <option value="">Sélectionner un rôle</option>
                  <option value="visiteur" <?= ($user['role'] ?? '') === 'visiteur' ? 'selected' : '' ?>>Visiteur</option>
                  <option value="guide" <?= ($user['role'] ?? '') === 'guide' ? 'selected' : '' ?>>Guide</option>
              </select>

              <!-- Bouton Modifier -->
            <button 
                name="modifier_user" 
                class="w-full py-3 rounded-lg bg-yellow-400 text-gray-900 font-semibold shadow-lg hover:bg-yellow-500 hover:scale-105 transition-all duration-300">
                Modifier
            </button>

            <!-- Bouton Annuler -->
            <a href="../pages/admin/manage_users.php" 
                class="w-full mt-4 py-3 rounded-lg bg-red-600 text-white font-semibold shadow-lg hover:bg-red-700 hover:scale-105 transition-all duration-300 flex justify-center items-center">
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
