<?php
session_start();
require_once '../../config/db.php';


/* Habitats depuis table habitats */
$habitats = $connexion->query("
    SELECT id_habitat, nom_habitat 
    FROM habitats
")->fetch_all(MYSQLI_ASSOC);

/* Types alimentaires depuis animal */
$alimentations = $connexion->query("
    SELECT DISTINCT alimentation 
    FROM animal
")->fetch_all(MYSQLI_ASSOC);



$filtre_habitat = $_GET['habitat'] ?? '';
$filtre_alimentation = $_GET['alimentation'] ?? '';



$sql = "
    SELECT 
        animal.*,
        habitats.nom_habitat
    FROM animal
    JOIN habitats ON animal.id_habitat = habitats.id_habitat
    WHERE 1
";

$params = [];
$types = "";

/* Filtre par habitat */
if (!empty($filtre_habitat)) {
    $sql .= " AND animal.id_habitat = ?";
    $params[] = $filtre_habitat;
    $types .= "i";
}

/* Filtre par alimentation */
if (!empty($filtre_alimentation)) {
    $sql .= " AND animal.alimentation = ?";
    $params[] = $filtre_alimentation;
    $types .= "s";
}



$stmt = $connexion->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$animaux = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

/* Header */
require_once '../layouts/header.php';
?>

<main class="mt-24 px-6 bg-[#f8fafc] min-h-screen">

    <!-- Titre -->
    <h1 class="mt-16 text-4xl font-extrabold text-center text-[#14532d] mb-10">
        🐾 Nos Animaux
    </h1>

    <!-- Filtres -->
    <form method="GET" class="max-w-5xl mx-auto mb-14 bg-white p-6 rounded-3xl shadow-lg">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">

            <!-- Habitat -->
            <div>
                <label class="block text-sm font-semibold text-[#0f172a] mb-2">
                    Habitat
                </label>
                <select name="habitat" class="w-full rounded-xl border-gray-300
                               focus:ring-[#16a34a] focus:border-[#16a34a]">
                    <option value="">Tous les habitats</option>
                    <?php foreach ($habitats as $h): ?>
                        <option value="<?= $h['id_habitat'] ?>" <?= $filtre_habitat == $h['id_habitat'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($h['nom_habitat']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Alimentation -->
            <div>
                <label class="block text-sm font-semibold text-[#0f172a] mb-2">
                    Type alimentaire
                </label>
                <select name="alimentation" class="w-full rounded-xl border-gray-300
                               focus:ring-[#16a34a] focus:border-[#16a34a]">
                    <option value="">Tous les types</option>
                    <?php foreach ($alimentations as $a): ?>
                        <option value="<?= htmlspecialchars($a['alimentation']) ?>"
                            <?= $filtre_alimentation === $a['alimentation'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['alimentation']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Bouton -->
            <div>
                <button type="submit" class="w-full bg-blue-600  text-white py-3 rounded-xl
                               font-semibold hover:bg-[#16a34a]
                               transition duration-300 shadow-md">
                    Filtrer
                </button>
            </div>

        </div>
    </form>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10
                max-w-7xl mx-auto mb-20">

        <?php foreach ($animaux as $animal): ?>
            <div class="bg-white rounded-3xl shadow-md overflow-hidden
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                <!-- Image -->
                <div class="relative h-60 overflow-hidden">
                    <img src="../../actions/uploads/<?= htmlspecialchars($animal['image_animal']) ?>"
                        class="w-full h-full object-cover">

                    <span class="absolute top-4 left-4 bg-[#f59e0b] text-white
                                 text-xs font-semibold px-4 py-1 rounded-full shadow">
                        <?= htmlspecialchars($animal['alimentation']) ?>
                    </span>
                </div>

                <!-- Contenu -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-[#0f172a] mb-2">
                        <?= htmlspecialchars($animal['nom_animal']) ?>
                    </h2>

                    <p class="text-gray-600 text-sm mb-4">
                        <?= htmlspecialchars($animal['description_courte']) ?>
                    </p>

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">
                            <?= htmlspecialchars($animal['pays_origine']) ?>
                        </span>

                        <span class="bg-[#16a34a]/10 text-[#14532d]
                                     font-semibold px-3 py-1 rounded-full">
                            <?= htmlspecialchars($animal['nom_habitat']) ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</main>

<?php require_once '../layouts/footer.php'; ?>