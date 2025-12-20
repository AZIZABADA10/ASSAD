<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'visiteur') {
    header('Location: ../public/login.php');
    exit();
}

$id_visiteur = $_SESSION['user']['id_utilisateur'];

$sql = "
SELECT r.nb_personnes, r.date_reservation, r.statut,
       v.titre AS visite, u.nom_complet AS guide
FROM reservations r
JOIN visitesguidees v ON r.id_visite = v.id_visite
JOIN utilisateurs u ON v.id_guide = u.id_utilisateur
WHERE r.id_utilisateur = ?
ORDER BY r.date_reservation DESC
";

$stmt = $connexion->prepare($sql);
$stmt->bind_param("i", $id_visiteur);
$stmt->execute();
$reservations = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lion de l'Atlas | Zoo ASSAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/tailwind-config.js"></script>
    <link rel="shortcut icon" href="../../assets/images/assad_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="bg-light text-dark font-sans">

    <!-- Header -->
    <header class="fixed top-0 w-full z-50 bg-dark/90 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4 text-white">
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="relative w-15 h-16">
                    <img src="../../assets/images/assad_logo.png" alt="Logo Zoo ASSAD"
                        class="w-full h-full object-contain logo-anim">
                </div>
                <h1 class="text-xl font-bold tracking-wide transition-colors duration-300 group-hover:text-accent">
                    Zoo ASSAD
                </h1>
            </div>
            <nav class="hidden md:flex gap-8 font-medium items-center">
                <a href="../../index.php" class="hover:text-accent transition">Accueil</a>
                <a href="../public/animals.php" class="hover:text-accent transition">Animaux</a>
                <a href="../public/visits.php" class="hover:text-accent transition">Visites Guidées</a>
                <a href="../public/lion.php" class="hover:text-accent transition">Lion de l'Atlas</a>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'visiteur'): ?>
                    <a href="../visitor/dashboard.php" class="hover:text-accent transition font-semibold">
                        Mes réservations
                    </a>
                <?php endif; ?>
                <?php if (!isset($_SESSION['user'])): ?>
                    <a href="../public/login.php"
                      class="px-4 py-2 rounded-full bg-accent text-white hover:bg-accent/80 transition">
                        Login
                    </a>
                <?php endif; ?>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="../public/logout.php"
                      class="px-4 py-2 rounded-full border border-white/20 hover:bg-white/10 transition">
                        Logout
                    </a>
                <?php endif; ?>
            </nav>

        </nav>


        </div>
    </header>
    <!-- MAIN -->
     <main class="pt-32 max-w-6xl mx-auto px-6 mb-16">

  <h2 class="text-2xl font-bold mb-6 text-center">
    Mes réservations
  </h2>

  <?php if ($reservations->num_rows > 0): ?>
    <div class="overflow-x-auto bg-white rounded-2xl shadow-lg">
      <table class="w-full text-sm text-left">
        <thead class="bg-gray-100 uppercase text-xs text-gray-600">
          <tr>
            <th class="px-6 py-4">Visite</th>
            <th class="px-6 py-4">Guide</th>
            <th class="px-6 py-4">Personnes</th>
            <th class="px-6 py-4">Date</th>
            <th class="px-6 py-4">Statut</th>
          </tr>
        </thead>

        <tbody class="divide-y">
          <?php while ($row = $reservations->fetch_assoc()): ?>
            <tr class="hover:bg-gray-50 transition">

              <td class="px-6 py-4 font-semibold">
                <?= htmlspecialchars($row['visite']) ?>
              </td>

              <td class="px-6 py-4">
                <?= htmlspecialchars($row['guide']) ?>
              </td>

              <td class="px-6 py-4 text-center">
                <?= $row['nb_personnes'] ?>
              </td>

              <td class="px-6 py-4">
                <?= date('d/m/Y H:i', strtotime($row['date_reservation'])) ?>
              </td>

              <td class="px-6 py-4">
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                  <?= $row['statut'] === 'en_attente' ? 'bg-yellow-100 text-yellow-700' : '' ?>
                  <?= $row['statut'] === 'confirmee' ? 'bg-green-100 text-green-700' : '' ?>
                  <?= $row['statut'] === 'refusee' ? 'bg-red-100 text-red-700' : '' ?>">
                  
                  <?= ucfirst(str_replace('_',' ', $row['statut'])) ?>
                </span>
              </td>

            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

  <?php else: ?>
    <p class="text-center text-gray-500 mt-10">
      Aucune réservation trouvée.
    </p>
  <?php endif; ?>

</main>

<?php require_once '../layouts/footer.php'; ?>