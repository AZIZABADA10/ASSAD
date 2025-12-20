<?php

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: ../../pages/public/login.php');
  exit();
}

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
<?php
  require '../layouts/header.php';
  ?>


  <!-- Layout -->
  <div class="flex pt-24">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-24 h-[calc(100vh-6rem)]  w-64 bg-dark text-white border-r border-white/10">
      <div class="p-6 ">

        <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    font-medium bg-white/10 text-accent
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group mb-2">
          <i class='bx bx-dashboard text-xl group-hover:scale-110 transition'></i>
          <span>Page principale</span>
        </a>

        <a href="my_visits.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
                    hover:bg-white/10 hover:text-accent
                    transition-all duration-300 group  mb-2">
          <i class='bx bx-community text-xl group-hover:scale-110 transition'></i>
          <span>Mes Visites</span>
        </a>

        <a href="reservations.php" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-white/90 font-medium
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
      <h1 class="text-2xl font-bold mb-4">Bienvenue sur le Dashboard Guide</h1>



    </main>

  </div>

</body>

</html>