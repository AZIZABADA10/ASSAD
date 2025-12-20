<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../../pages/public/login.php');
    exit();
}

$user_id = $_SESSION['user']['id_utilisateur'] ?? null;

// Récupérer les visites ouvertes
$visites = $connexion->query("SELECT * FROM visitesguidees WHERE statut = 'ouverte' ORDER BY date_heure DESC");

require_once '../layouts/header.php';
?>

<main class="mt-10 max-w-7xl mx-auto px-6 py-16">

    <h1 class="text-4xl font-extrabold text-center mb-12">Visites Guidées</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php while ($visite = $visites->fetch_assoc()): ?>

            <?php
            // Vérifier si l'utilisateur a déjà réservé cette visite
            $stmt_check = $connexion->prepare("SELECT * FROM reservations WHERE id_visite = ? AND id_utilisateur = ?");
            $stmt_check->bind_param("ii", $visite['id_visite'], $user_id);
            $stmt_check->execute();
            $already_reserved = $stmt_check->get_result()->num_rows > 0;

            // Récupérer les commentaires pour cette visite
            $stmt_comments = $connexion->prepare("
                SELECT c.texte, c.date_commentaire, u.nom_complet
                FROM commentaires c
                JOIN utilisateurs u ON c.id_utilisateur = u.id_utilisateur
                WHERE c.id_visite = ?
                ORDER BY c.date_commentaire DESC
            ");
            $stmt_comments->bind_param("i", $visite['id_visite']);
            $stmt_comments->execute();
            $commentaires = $stmt_comments->get_result();
            ?>

            <div
                class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:scale-105 hover:shadow-2xl transition-transform duration-300">
                <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($visite['titre']) ?></h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3"><?= htmlspecialchars($visite['description']) ?></p>

                <div class="flex flex-col gap-1 text-gray-700 text-sm mb-4">
                    <div><i class='bx bx-calendar'></i> <strong>Date & Heure:</strong>
                        <?= date('d/m/Y H:i', strtotime($visite['date_heure'])) ?></div>
                    <div><i class='bx bx-time-five'></i> <strong>Durée:</strong> <?= $visite['duree'] ?> min</div>
                    <div><i class='bx bx-money'></i> <strong>Prix:</strong> <?= $visite['prix'] ?> MAD</div>
                    <div><i class='bx bx-globe'></i> <strong>Langue:</strong> <?= htmlspecialchars($visite['langue']) ?></div>
                    <div><i class='bx bx-group'></i> <strong>Capacité:</strong> <?= $visite['capacite_max'] ?></div>
                </div>

                <?php if ($user_id): ?>
                    <?php if ($already_reserved): ?>
                        <div
                            class="mt-auto flex items-center justify-center gap-2 bg-green-100 text-green-800 px-5 py-2 rounded-full font-semibold shadow-md border border-green-200 hover:scale-105 transition-transform duration-300">
                            <i class='bx bx-check-circle text-green-600 text-lg'></i>
                            Déjà réservé
                        </div>
                    <?php else: ?>
                        <button onclick="openModal(<?= $visite['id_visite'] ?>, '<?= htmlspecialchars($visite['titre']) ?>')"
                            class="mt-auto bg-yellow-400 text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-yellow-500 transition">
                            Réserver
                        </button>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="login.php"
                        class="mt-auto bg-red-600 text-white px-4 py-2 rounded-full font-semibold hover:bg-red-700 transition">
                        Connectez-vous pour réserver
                    </a>
                <?php endif; ?>

                <?php if ($commentaires->num_rows > 0): ?>
                    <button onclick="toggleComments(<?= $visite['id_visite'] ?>)"
                        class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-blue-600 transition">
                        Voir commentaires
                    </button>

                    <div id="comments-<?= $visite['id_visite'] ?>" class="mt-4 hidden bg-gray-50 p-4 rounded-lg max-h-48 overflow-y-auto">
                        <?php while ($com = $commentaires->fetch_assoc()): ?>
                            <div class="mb-3 border-b pb-2">
                                <p class="text-sm font-semibold"><?= htmlspecialchars($com['nom_complet']) ?></p>
                                <p class="text-sm text-gray-600"><?= htmlspecialchars($com['texte']) ?></p>
                                <p class="text-xs text-gray-400"><?= date('d/m/Y H:i', strtotime($com['date_commentaire'])) ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endwhile; ?>
    </div>
</main>

<!-- Modal Réservation -->
<div id="reservationModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full relative">
        <h2 class="text-2xl font-bold mb-4 text-center" id="modalTitle">Réserver la visite</h2>

        <form action="../../actions/reservation.php" method="POST" class="space-y-4">
            <input type="hidden" name="id_visite" id="modal_visite_id">

            <label class="block">
                <span class="text-gray-700">Nombre de personnes</span>
                <input type="number" name="nb_personnes" min="1" required class="w-full px-4 py-2 border rounded" placeholder="Ex: 2">
            </label>

            <div class="flex justify-between gap-4">
                <button type="submit"
                    class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-full font-semibold hover:bg-yellow-500 transition w-full">
                    Confirmer
                </button>
                <button type="button" onclick="closeModal()"
                    class="bg-gray-400 text-white px-4 py-2 rounded-full hover:bg-gray-500 transition w-full">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id, titre) {
    document.getElementById('reservationModal').classList.remove('hidden');
    document.getElementById('modal_visite_id').value = id;
    document.getElementById('modalTitle').textContent = "Réserver : " + titre;
}

function closeModal() {
    document.getElementById('reservationModal').classList.add('hidden');
}

function toggleComments(visiteId) {
    const div = document.getElementById('comments-' + visiteId);
    div.classList.toggle('hidden');
}
</script>

<?php
require_once '../layouts/footer.php';
?>
