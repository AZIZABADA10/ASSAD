<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lion de l'Atlas | Dashboard Admin</title>
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

        
         <button class="bg-red-700 text-white px-5 py-2 rounded-full font-semibold hover:scale-105 transition-all" type="submit" onclick="window.location.href='../../actions/logout.php'">Logout</button>
    </div>
  </header>

  <!-- Layout -->
  <div class="flex pt-24">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-24 h-[calc(100vh-6rem)] w-64 bg-dark text-white border-r border-white/10">
      <div class="p-6">
        <h2 class="text-lg font-semibold mb-6 text-accent">Dashboard Admin</h2>
        <nav class="space-y-1">

        <a href="dashboard.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group">
            <i class='bx bx-dashboard text-xl group-hover:scale-110 transition'></i>
            <span>Page principale</span>
        </a>

        <a href="users.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group">
            <i class='bx bx-community text-xl group-hover:scale-110 transition'></i>
            <span>Utilisateurs</span>
        </a>

        <a href="animals.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group">
            <i class='bx bx-paw-print text-xl group-hover:scale-110 transition'></i>
            <span>Animaux</span>
        </a>

        <a href="habitats.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group">
            <i class='bx bx-home text-xl group-hover:scale-110 transition'></i>
            <span>Habitats</span>
        </a>

        <a href="stats.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group">
            <i class='bx bx-chart-line text-xl group-hover:scale-110 transition'></i>
            <span>Statistiques</span>
        </a>

        </nav>
      </div>
    </aside>

    <!-- Main content -->
    <main class="ml-64 w-full p-8">
      <h1 class="text-2xl font-bold mb-4">Bienvenue sur le Dashboard</h1>
      <p class="text-gray-600">
        Sélectionnez une section depuis la barre latérale pour gérer le zoo.
      </p>

      <!-- Exemple de cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        <div class="bg-white rounded-xl shadow p-6">
          <h3 class="font-semibold">Utilisateurs</h3>
          <p class="text-2xl font-bold mt-2">24</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
          <h3 class="font-semibold">Animaux</h3>
          <p class="text-2xl font-bold mt-2">58</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
          <h3 class="font-semibold">Habitats</h3>
          <p class="text-2xl font-bold mt-2">12</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
          <h3 class="font-semibold">Visites</h3>
          <p class="text-2xl font-bold mt-2">7</p>
        </div>
      </div>
    </main>

  </div>

</body>
</html>
