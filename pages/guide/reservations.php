<?php
session_start();
require_once __DIR__ .'/../../config/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../../pages/public/login.php');
    exit();
}

$guide_id = $_SESSION['user']['id_utilisateur'] ?? null;

$sql = "
SELECT 
    r.id_reservation,
    r.statut,
    r.nb_personnes,
    r.date_reservation,
    u.nom_complet AS visiteur,
    v.titre AS visite
FROM reservations r
JOIN visitesguidees v ON r.id_visite = v.id_visite
JOIN utilisateurs u ON r.id_utilisateur = u.id_utilisateur
WHERE v.id_guide = ?
ORDER BY r.date_reservation DESC
";
$stmt = $connexion->prepare($sql);
$stmt->bind_param("i", $guide_id);
$stmt->execute();
$reservations = $stmt->get_result();



require_once '../layouts/header.php';



?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
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
                <img 
                    src="../../assets/images/assad_logo.png" 
                    alt="Logo Zoo ASSAD"
                    class="w-full h-full object-contain logo-anim"
                >
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

        
<button
  onclick="window.location.href='../../actions/logout.php'"
  class="group flex items-center gap-2
         bg-gradient-to-r from-red-600 to-red-700
         text-white px-6 py-2 rounded-full font-semibold
         shadow-lg shadow-red-900/30
         hover:scale-105 hover:shadow-xl
         transition-all duration-300">

    <i class='bxr  bx-arrow-out-right-square-half' style='color:#fa0d0d'></i> 

    <span>Logout</span>
</button>    </div>
  </header>

  <!-- Layout -->
  <div class="flex pt-24">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-24 h-[calc(100vh-6rem)]  w-64 bg-dark text-white border-r border-white/10">
      <div class="p-6 ">

        <a href="dashboard.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    font-medium 
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
            <i class='bx bx-dashboard text-xl group-hover:scale-110 transition'></i>
            <span>Page principale</span>
        </a>

        <a href="my_visits.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium 
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
            <i class='bx bx-community text-xl group-hover:scale-110 transition'></i>
            <span>Mes Visites</span>
        </a>

        <a href="reservations.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    bg-white/10 text-accent font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
            <i class='bx bx-paw-print text-xl group-hover:scale-110 transition'></i>
            <span>Réservations</span>
        </a>




        </nav>
      </div>
    </aside>

    <!-- Main content -->
    <main class="ml-64 w-full p-8">
      <h2 class="text-2xl font-bold mb-6">Mes Réservations</h2>

    <?php
    //var_dump($reservations);
     if ($reservations->num_rows > 0): ?>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">Visite</th>
                    <th class="border px-4 py-2">Visiteur</th>
                    <th class="border px-4 py-2">Nombre de personnes</th>
                    <th class="border px-4 py-2">Date de réservation</th>
                    <th class="border px-4 py-2">Statut</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $reservations->fetch_assoc()): ?>
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['visite']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['visiteur']) ?></td>
                    <td class="border px-4 py-2"><?= $row['nb_personnes'] ?></td>
                    <td class="border px-4 py-2"><?= date('d/m/Y H:i', strtotime($row['date_reservation'])) ?></td>
                    <td class="border px-4 py-2">
                    <span class="px-3 py-1 rounded-full text-sm
                        <?= $row['statut']=='en_attente' ? 'bg-yellow-200 text-yellow-800' : '' ?>
                        <?= $row['statut']=='confirmee' ? 'bg-green-200 text-green-800' : '' ?>
                        <?= $row['statut']=='annulee' ? 'bg-red-200 text-red-800' : '' ?>">
                        <?= ucfirst($row['statut']) ?>
                    </span>
                </td>

                <td class="border px-4 py-2 text-center">
                <?php if($row['statut']=='en_attente'): ?>
                    <form method="POST" action="../../actions/update_reservation.php" class="inline">
                        <input type="hidden" name="id_reservation" value="<?= $row['id_reservation'] ?>">
                        <input type="hidden" name="statut" value="confirmee">
                        <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Confirmer</button>
                    </form>
                    <form method="POST" action="../../actions/update_reservation.php" class="inline">
                        <input type="hidden" name="id_reservation" value="<?= $row['id_reservation'] ?>">
                        <input type="hidden" name="statut" value="annulee">
                        <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Annuler</button>
                    </form>
                <?php endif; ?>
                </td>

                </tr>
                <?php  endwhile;  ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p class="text-gray-600">Aucune réservation pour vos visites.</p>
    <?php endif; ?>
</main>
      

    </main>

  </div>

</body>
</html>
