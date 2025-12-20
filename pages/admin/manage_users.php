<?php
session_start();

require_once '../../config/db.php';

$users = $connexion->query("SELECT * FROM utilisateurs order by id_utilisateur desc");


$erreurs = [
  'email_error' => $_SESSION['register_errors']['email_error'] ?? '',
  'password_error' => $_SESSION['register_errors']['password_error'] ?? '',
  'email_existe' => $_SESSION['register_errors']['email_existe'] ?? ''
];

unset($_SESSION['register_errors']);

function afficher_erreurs($erreur)
{
  return !empty($erreur)
    ? "<p class='bg-red-500/20 border border-red-500 text-red-300 px-4 py-2 rounded-lg text-sm mb-4'>$erreur</p>"
    : '';
}

if (isset($_GET['modal']) && $_GET['modal'] === 's-inscrire-form') {
  echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            afficher_modal('s-inscrire-form');
        });
    </script>";
}


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../../pages/public/login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin | Gestion d'Utilisateurs</title>
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
                     bg-white/10 text-accent font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
          <i class='bx bx-community text-xl group-hover:scale-110 transition'></i>
          <span>Utilisateurs</span>
        </a>

        <a href="manage_animals.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
          <i class='bx bx-paw-print text-xl group-hover:scale-110 transition'></i>
          <span>Animaux</span>
        </a>

        <a href="manage_habitats.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
          <i class='bx bx-home text-xl group-hover:scale-110 transition'></i>
          <span>Habitats</span>
        </a>

        </nav>
      </div>
    </aside>

    <!-- Main content -->
    <main class="ml-64 w-full p-8">
      <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold mb-4">Gestion des utilisateurs</h2>
        <button onclick="afficher_modal('s-inscrire-form')"
          class="bg-red-700 text-white px-4 rounded-full font-semibold hover:scale-105 transition-all">Ajouter
          utilisateur</button>
      </div>

      <table class="w-full text-left border-collapse">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border border-gray-300">ID</th>
            <th class="px-4 py-2 border border-gray-300">Nom Complet</th>
            <th class="px-4 py-2 border border-gray-300">Email</th>
            <th class="px-4 py-2 border border-gray-300">Statut de compte</th>
            <th class="px-4 py-2 border border-gray-300">Role</th>
            <th class="px-4 py-2 border border-gray-300">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($user = $users->fetch_assoc()): ?>
            <tr class="hover:bg-gray-100">
              <td class="px-4 py-2 border border-gray-300"><?= $user['id_utilisateur']; ?></td>
              <td class="px-4 py-2 border border-gray-300"><?= $user['nom_complet']; ?></td>
              <td class="px-4 py-2 border border-gray-300"><?= $user['email']; ?></td>
              <td class="px-4 py-2 border border-gray-300">
                <form action="../../actions/user_crud.php?id=<?= $user['id_utilisateur']; ?>" method="POST"
                  class="flex justify-around">
                  <select <?= $user['role'] === 'admin' ? 'disabled' : '' ?> name="statut_de_compet">
                    <option value="active" <?= $user['statut_de_compet'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="en_attente" <?= $user['statut_de_compet'] === 'en_attente' ? 'selected' : '' ?>>
                        En attente
                    </option>
                    <option value="blocked" <?= $user['statut_de_compet'] === 'blocked' ? 'selected' : '' ?>>Blocked</option>
                  </select>
                  <button type="submit" name="changer_status"
                    style="<?= $user['role'] === 'admin' ? 'pointer-events:none; opacity:0.5; cursor:not-allowed;' : '' ?>"
                    class="bg-red-500 text-white px-2 py-1  rounded font-semibold hover:scale-105 transition-all">Changer
                    Statut</button>
                </form>
              </td>
              <td class="px-4 py-2 border border-gray-300"><?= $user['role']; ?></td>
              <td class="px-4 py-2 border border-gray-300">
                <div class="flex justify-between ">
                  <a href="../../actions/user_crud.php?id_supprimer=<?= $user['id_utilisateur'] ?> "
                    onclick="return confirm('Vous voullez vrément supprimer ce utilisateur?')"
                    style="<?= $user['role'] === 'admin' ? 'pointer-events:none; opacity:0.5; cursor:not-allowed;' : '' ?>">
                    <i class='bxr  bx-trash' style='color:#fa0d0d'></i></a>
                  <a style="<?= $user['role'] === 'admin' ? 'pointer-events:none; opacity:0.5; cursor:not-allowed;' : '' ?>"
                    href="../../actions/modifier_user.php?id=<?= $user['id_utilisateur']; ?>">
                    <i class='bxr  bx-edit ' style='color:#068b00'></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </main>
    <div id="s-inscrire-form"
      class="hidden fixed inset-0 z-50 flex justify-center items-center bg-dark/90 backdrop-blur-lg">
      <div class="z-60 bg-dark/90 backdrop-blur-lg border border-white/10 rounded-2xl shadow-2xl p-8">

        <h2 class="text-2xl font-bold text-center text-accent mb-6">
          Ajouter user
        </h2>
        <form action="../../actions/user_crud.php" method="POST" class="space-y-4">
          <input type="text" name="nom" placeholder="Nom complet" class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none text-white" required>
          <input type="email" name="email" placeholder="Email" class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none text-white" required>
          <?= afficher_erreurs($erreurs['email_existe']); ?>
          <?= afficher_erreurs($erreurs['email_error']); ?>
          <input type="password" name="password" placeholder="Mot de passe" class="w-full px-4 py-3 rounded-lg bg-transparent
                              border border-white/20 placeholder-gray-400
                              focus:ring-2 focus:ring-accent focus:outline-none text-white" required>
          <?= afficher_erreurs($erreurs['password_error']); ?>
          <select name="role" class="w-full px-4 py-3 rounded-lg bg-dark
                               border border-white/20 text-white
                               focus:ring-2 focus:ring-accent focus:outline-none text-white" required>
            <option value="">Sélectionner un rôle</option>
            <option value="visiteur">Visiteur</option>
            <option value="guide">Guide</option>
          </select>
          <button name="ajouter_user" class="w-full py-3 rounded-lg bg-accent text-dark
                               font-semibold hover:opacity-90 transition">
            Ajouter
          </button>
          <button type="button" onclick="masquer_modal('s-inscrire-form')"
            class="w-full py-3 rounded-lg bg-red-600 text-white font-semibold hover:opacity-90 transition">
            Annuler
          </button>
        </form>
      </div>
    </div>

  </div>
  <script>
    function afficher_modal(id_modal) {
      document.getElementById(id_modal).classList.remove('hidden');
    }
    function masquer_modal(id_modal) {
      document.getElementById(id_modal).classList.add('hidden');
    }
  </script>
</body>

</html>