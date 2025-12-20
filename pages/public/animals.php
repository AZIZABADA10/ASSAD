<?php
require_once '../../config/db.php';

$animaux = $connexion
    ->query("SELECT * FROM animal")
    ->fetch_all(MYSQLI_ASSOC);

/** Header */
require_once '../layouts/header.php';
?>

<main class="mt-20 px-6 bg-gradient-to-b from-slate-50 to-slate-100 min-h-screen">
    <h1 class="text-4xl font-extrabold text-center text-emerald-800 mb-12">
        🐾 Nos Animaux
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 max-w-7xl mx-auto">
        <?php foreach ($animaux as $animal): ?>
            <div class="bg-white rounded-3xl shadow-md overflow-hidden 
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                <!-- Image -->
                <div class="relative h-60 overflow-hidden">
                    <img 
                        src="../../actions/uploads/<?= htmlspecialchars($animal['image_animal']) ?>" 
                        alt="<?= htmlspecialchars($animal['nom_animal']) ?>"
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                    >

                    <span class="absolute top-4 left-4 bg-amber-500 text-white 
                                 text-xs font-semibold px-3 py-1 rounded-full shadow">
                        <?= htmlspecialchars($animal['alimentation']) ?>
                    </span>
                </div>

                <!-- Contenu -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">
                        <?= htmlspecialchars($animal['nom_animal']) ?>
                    </h2>

                    <p class="text-gray-600 text-sm mb-4">
                        <?= htmlspecialchars($animal['description_courte']) ?>
                    </p>

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 flex items-center gap-1">
                            🌍 <?= htmlspecialchars($animal['pays_origine']) ?>
                        </span>

                        <span class="bg-emerald-100 text-emerald-700 
                                     font-semibold px-3 py-1 rounded-full">
                            <?= htmlspecialchars($animal['espace']) ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php
/** Footer */
require_once '../layouts/footer.php';
?>
