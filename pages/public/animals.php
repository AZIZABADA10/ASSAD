<?php

require_once '../../config/db.php';

$animaux = $connexion->query("SELECT * FROM animal")->fetch_all(MYSQLI_ASSOC);



 /** Header  */
require_once '../layouts/header.php';
?>

<main class="mt-20 px-6 bg-[#f8fafc] min-h-screen">
    <h1 class="text-3xl font-bold text-center text-[#14532d] mb-10">
        🐾 Nos Animaux
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($animaux as $animal): ?>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden 
                        hover:shadow-2xl transition duration-300">

                <!-- Image -->
                <div class="h-56 overflow-hidden">
                    <img 
                        src="../../actions/uploads/<?= htmlspecialchars($animal['image_animal']) ?>" 
                        alt="<?= htmlspecialchars($animal['nom']) ?>"
                        class="w-full h-full object-cover hover:scale-110 transition duration-500"
                    >
                </div>

                <!-- Contenu -->
                <div class="p-5">
                    <h2 class="text-2xl font-semibold text-[#0f172a] mb-2">
                        <?= htmlspecialchars($animal['nom']) ?>
                    </h2>

                    <span class="inline-block bg-[#f59e0b] text-white text-xs px-3 py-1 rounded-full mb-3">
                        <?= htmlspecialchars($animal['alimentation']) ?>
                    </span>

                    <p class="text-gray-600 text-sm mb-4">
                        <?= htmlspecialchars($animal['description_courte']) ?>
                    </p>

                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span>🌍 <?= htmlspecialchars($animal['pays_origine']) ?></span>
                        <span class="font-semibold text-[#16a34a]">
                            <?= $animal['espace'] == 1 ? 'Grand espace' : 'Espace réduit' ?>
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
