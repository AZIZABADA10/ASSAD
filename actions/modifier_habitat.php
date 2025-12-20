<?php
    require_once __DIR__ .'/../config/db.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../pages/admin/manage_habitats.php');
    exit();
}


$id = $_GET['id'] ?? null;

// Récupération des informations
if ($id) {
    $stmt = $connexion->prepare("SELECT * FROM habitats WHERE id_habitat = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $habitat = $stmt->get_result()->fetch_assoc();
    
}

if (isset($_POST['modifier_habitat'])) {
    $id = $_GET['id'];
    $nom = $_POST['nom_habitat'];
    $description = $_POST['description_habitat'];
    $type_climat = $_POST['type_climat'];
    $zonezoo = $_POST['zonezoo'];

    $sql = "UPDATE habitats SET nom_habitat=?,type_climat=?,zonezoo=?,description_habitat=? WHERE id_habitat=?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("ssssi",$nom,$type_climat,$zonezoo,$description,$id);

    if ($stmt->execute()) {
        // var_dump($sql);
        echo "<script> window.location.href='../pages/admin/manage_habitats.php';</script>";
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
        

<div id="habitat_update_habitat" class="fixed inset-0 z-50 flex justify-center items-center bg-dark/90 backdrop-blur-lg">
  <div class="modal w-[700px] bg-dark/80 border border-white/10 rounded-2xl shadow-2xl p-8">
    <div class="flex justify-between">
      <h2 class="text-2xl font-bold mb-4 text-accent">Modifier un Habitat </h2>
    </div>
    <form action="modifier_habitat.php?id=<?= $habitat['id_habitat'] ?>" method="POST">
      <label class="text-white/70">Nom de l'habitat</label>
      <input type="text" name="nom_habitat" required value="<?= $habitat['nom_habitat'] ?>" 
      class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-accent focus:outline-none text-white">
      <label class="text-white/70">Type de climat</label>
       <select name="type_climat" required class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-accent focus:outline-none text-white">
        <option 
        class="bg-dark text-white"
        value="" class="bg-dark text-white">Sélectionner un type de climat</option>
        <option 
        class="bg-dark text-white"
        value="Tropical" <?= $habitat['type_climat']==='Tropical'?'selected':'' ?> >Tropical</option>
        <option 
        class="bg-dark text-white"
        value="Tempéré" <?= $habitat['type_climat']==='Tempéré'?'selected':'' ?>>Tempéré</option>
        <option 
        class="bg-dark text-white"
        value="Désertique" <?= $habitat['type_climat']==='Désertique'?'selected':'' ?>>Désertique</option>
        <option 
        class="bg-dark text-white"
        value="Montagneux" <?= $habitat['type_climat']==='Montagneux'?'selected':'' ?>>Montagneux</option>
        
      </select> 
      <label class="text-white/70">Zone zoo</label>
      <input type="text" name="zonezoo" required value="<?= $habitat['zonezoo'] ?>" 
      class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20  placeholder-gray-400 focus:ring-2 focus:ring-accent focus:outline-none text-white">
      <label class="text-white/70">Description</label>
      <textarea name="description_habitat" required class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 placeholder-gray-400 focus:ring-2 focus:ring-accent focus:outline-none text-white">
        <?= $habitat['description_habitat'] ?></textarea>
      <div>
        <button type="submit" name="modifier_habitat" class="w-full mb-4 py-3 rounded-lg bg-accent text-dark font-semibold hover:opacity-90 transition">
          Modifier
        </button>
        <a href="../pages/admin/manage_habitats.php" class="w-full px-[288px] mt-2 py-3 rounded-lg bg-transparent border border-white/20 text-white hover:bg-white/10 transition">
          Annuler
        </a>
      </div>
    </form>
  </div>
</div>
      

    </main>

 <script>
    
  </script>

</body>
</html>