<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guide') {
    header('Location: ../../pages/public/login.php');
    exit();
}

$id_guide = $_SESSION['user']['id_utilisateur'];

$visites = $connexion->query("
    SELECT * FROM visitesguidees
    WHERE id_guide = $id_guide
    ORDER BY date_heure DESC
");


$zones = $connexion->query("
    SELECT DISTINCT h.zone_zoo 
    FROM habitats h
    JOIN animal a ON a.id_habitat = h.id_habitat
    ORDER BY h.zone_zoo ASC
");

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Guide | Mes Visites</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../../assets/js/tailwind-config.js"></script>

  <link rel="shortcut icon" href="../../assets/images/assad_logo.png">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-light text-dark font-sans">

  <!-- ================= HEADER ================= -->
  <?php require_once '../layouts/header.php'; ?>


  <!-- ================= LAYOUT ================= -->
  <div class="flex pt-24">

    <aside class="fixed left-0 top-24 h-[calc(100vh-6rem)]  w-64 bg-dark text-white border-r border-white/10">
      <div class="p-6 ">

        <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    font-medium 
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
          <i class='bx bx-dashboard text-xl group-hover:scale-110 transition'></i>
          <span>Page principale</span>
        </a>

        <a href="my_visits.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                     bg-white/10 text-accent font-medium 
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
          <i class='bx bx-community text-xl group-hover:scale-110 transition'></i>
          <span>Mes Visites</span>
        </a>

        <a href="reservations.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
          <i class='bx bx-paw-print text-xl group-hover:scale-110 transition'></i>
          <span>Réservations</span>
        </a>




        </nav>
      </div>
    </aside>

    <!-- ================= MAIN ================= -->
    <main class="ml-64 w-full p-8">

      <div class="flex justify-between mb-6">
        <h2 class="text-xl font-bold">Mes Visites Guidées</h2>
        <button onclick="afficher_modal('ajouter-visite-modal')"
          class="bg-red-700 text-white px-4 py-2 rounded-full hover:scale-105 transition">
          Ajouter visite
        </button>
      </div>

      <!-- ================= TABLE ================= -->
      <table class="w-full border-collapse text-left">
        <thead class="bg-gray-200">
          <tr>
            <th class="border px-4 py-2">Titre</th>
            <th class="border px-4 py-2">Description</th>
            <th class="border px-4 py-2">Date</th>
            <th class="border px-4 py-2">Durée</th>
            <th class="border px-4 py-2">Prix</th>
            <th class="border px-4 py-2">Langue</th>
            <th class="border px-4 py-2">Capacité</th>
            <th class="border px-4 py-2">Statut</th>
            <th class="border px-4 py-2 text-center">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php while ($visite = $visites->fetch_assoc()): ?>
            <tr class="hover:bg-gray-100">
              <td class="border px-4 py-2"><?= htmlspecialchars($visite['description']) ?></td>
              <td class="border px-4 py-2"><?= htmlspecialchars($visite['titre']) ?></td>
              <td class="border px-4 py-2"><?= date('Y-m-d H:i', strtotime($visite['date_heure'])) ?></td>
              <td class="border px-4 py-2"><?= $visite['duree'] ?> h</td>
              <td class="border px-4 py-2"><?= $visite['prix'] ?> MAD</td>
              <td class="border px-4 py-2"><?= htmlspecialchars($visite['langue']) ?></td>
              <td class="border px-4 py-2"><?= $visite['capacite_max'] ?></td>

              <td class="border px-4 py-2">
                <div class="flex items-center gap-2">

                  <span class="px-3 py-1 rounded-full text-sm
                    <?= $visite['statut'] == 'ouverte' ? 'bg-green-200 text-green-800' : '' ?>
                    <?= $visite['statut'] == 'annulee' ? 'bg-red-200 text-red-800' : '' ?>
                    <?= $visite['statut'] == 'complete' ? 'bg-gray-300 text-gray-700' : '' ?>">
                    <?= ucfirst($visite['statut']) ?>
                  </span>

                  <?php if ($visite['statut'] !== 'annulee'): ?>
                    <form method="GET" action="../../actions/crud_visite.php">
                      <input type="hidden" name="id_annuler" value="<?= $visite['id_visite'] ?>">
                      <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700"
                        onclick="return confirm('Annuler cette visite ?')">
                        Annuler
                      </button>
                    </form>
                  <?php endif; ?>

                </div>
              </td>
            <td class="border px-4 py-2 text-center">
              <div class="flex justify-center items-center gap-3">

                <!-- Modifier -->
                <a href="../../actions/modifier_visite.php?id=<?= $visite['id_visite'] ?>"
                  title="Modifier la visite"
                  class="group flex items-center justify-center
                          w-10 h-10 rounded-full
                          bg-green-100 text-green-700
                          hover:bg-green-600 hover:text-white
                          transition-all duration-300">
                  <i class='bx bx-edit text-xl group-hover:scale-110 transition'></i>
                </a>
                   <button onclick="ouvrirModalEtape(<?= $visite['id_visite'] ?>)" 
                    class="group flex items-center justify-center
                        w-10 h-10 rounded-full
                        bg-gradient-to-r from-blue-600 to-blue-700
                        text-white
                        shadow-md shadow-blue-900/30
                        hover:scale-110 hover:shadow-xl
                        transition-all duration-300">
                    <i class='bx bx-plus-circle text-xl
                            group-hover:rotate-90
                            transition-transform duration-300'></i>
                          </button>
              </div>
            </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

    </main>
  </div>

  <div id="ajouter-visite-modal" class="hidden fixed inset-0 bg-dark/90 flex justify-center items-center z-50">

    <div class="bg-dark p-8 rounded-xl w-full max-w-md text-white">
      <h2 class="text-xl font-bold mb-4 text-accent text-center">Ajouter Visite</h2>
      <form action="../../actions/crud_visite.php" method="POST" class="space-y-3">

        <input type="text" name="titre" placeholder="Titre" required
          class="w-full px-4 py-2 rounded bg-transparent border">

        <textarea name="description" required placeholder="Description de la visite (contenu, thèmes, animaux, etc.)"
          class="w-full px-4 py-2 rounded bg-transparent border text-white placeholder-gray-400">
        </textarea>

        <input type="date" name="date" required class="w-full px-4 py-2 rounded bg-transparent border">
        <input type="time" name="heure_debut" required class="w-full px-4 py-2 rounded bg-transparent border">
        <input type="number" name="duree" placeholder="Durée (h)" required
          class="w-full px-4 py-2 rounded bg-transparent border">
        <input type="number" name="prix" placeholder="Prix (MAD)" required
          class="w-full px-4 py-2 rounded bg-transparent border">
        <input type="text" name="langue" placeholder="Langue" required
          class="w-full px-4 py-2 rounded bg-transparent border">
        <input type="number" name="capacite_max" placeholder="Capacité max" required
          class="w-full px-4 py-2 rounded bg-transparent border">

        <button type="submit" name="ajouter_visite" class="w-full bg-red-700 py-2 rounded font-semibold">
          Ajouter
        </button>

        <button type="button" onclick="masquer_modal('ajouter-visite-modal')"
          class="w-full bg-gray-600 py-2 rounded font-semibold">
          Annuler
        </button>

      </form>
    </div>
  </div>

  <div id="modal-etape" class="hidden fixed inset-0 bg-dark/90 flex items-center justify-center z-50">
      <div class="bg-dark p-8 rounded-xl w-full max-w-md text-white">
          <h2 class="text-xl font-bold mb-4 text-accent text-center">Ajouter une Étape</h2>
          <form action="../../actions/crud_etape_visite.php" method="POST" class="space-y-3">
              <input type="hidden" name="id_visite" id="id_visite_etape">
              <input type="text" name="titre_etape" placeholder="Titre de l'étape" required class="w-full px-4 py-2 rounded bg-transparent border">
              <textarea name="description_etape" placeholder="Description de l'étape" required class="w-full px-4 py-2 rounded bg-transparent border text-white"></textarea>

              <label for="zone_etape">Zone zoo</label>
              <select name="zone_etape" required class="w-full px-4 py-2 rounded bg-transparent border text-white">
                  <option value="">Sélectionner une zone du zoo</option>
                  <?php
                  $zones->data_seek(0); 
                  while($zone = $zones->fetch_assoc()):
                  ?>
                      <option value="<?= htmlspecialchars($zone['zone_zoo']); ?>"><?= htmlspecialchars($zone['zone_zoo']); ?></option>
                  <?php endwhile; ?>
              </select>

              <input type="number" name="ordre_etape" placeholder="Ordre (1,2,3...)" required class="w-full px-4 py-2 rounded bg-transparent border">
              <button type="submit" name="ajouter_etape" class="w-full bg-blue-600 py-2 rounded font-semibold hover:bg-blue-700">Ajouter Étape</button>
              <button type="button" onclick="fermerModalEtape()" class="w-full bg-gray-600 py-2 rounded font-semibold">Annuler</button>
          </form>
      </div>
  </div>


  <script>
    function afficher_modal(id) {
      document.getElementById(id).classList.remove('hidden');
    }
    function masquer_modal(id) {
      document.getElementById(id).classList.add('hidden');
     }
    function ouvrirModalEtape(idVisite) {
      document.getElementById('id_visite_etape').value = idVisite;
      document.getElementById('modal-etape').classList.remove('hidden');
    }

    function fermerModalEtape() {
      document.getElementById('modal-etape').classList.add('hidden');
    }
  function afficher_modal(id) { document.getElementById(id).classList.remove('hidden'); }
  function masquer_modal(id) { document.getElementById(id).classList.add('hidden'); }
  function ouvrirModalEtape(idVisite) {
      document.getElementById('id_visite_etape').value = idVisite;
      document.getElementById('modal-etape').classList.remove('hidden');
  }
  function fermerModalEtape() { document.getElementById('modal-etape').classList.add('hidden'); }
  </script>

</body>

</html>