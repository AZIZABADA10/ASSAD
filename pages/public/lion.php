<?php
session_start();?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lion de l'Atlas | Zoo ASSAD</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../../assets/js/tailwind-config.js"></script>
  <link rel="shortcut icon" href="../../assets/images/assad_logo.png" type="image/x-icon">
  <link rel="stylesheet" href="../../assets/css/style.css">

</head>
  <?php
  require '../layouts/header.php';
  ?>
<body class="bg-light text-dark font-sans">

  <!-- Header -->
>

  <!-- HERO SECTION -->
  <section class="relative h-screen parallax-bg"
    style="background-image: url('../../assets/images/lion-male-roar.avif');">
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/70"></div>

    <div class="relative z-10 h-full flex items-center justify-center text-center">
      <div class="max-w-4xl mx-auto px-6 space-y-6 animate-fade-in-up">


        <h1 class="text-6xl md:text-8xl font-extrabold text-white leading-tight">
          Lion de<span class="text-accent font-bold tracking-wider "> l'Atlas</span>
        </h1>
        <div>
          <img src="../../assets/images/Symbole-can_maroc.png" alt="Symbole CAN 2025"
            class="h-40 w-40 object-contain inline-block">
          <p class="text-xl md:text-2xl text-gray-200 max-w-2xl mx-auto">
            Le Roi Disparu de l'Afrique du Nord
          </p>

          <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
            <a href="#histoire"
              class="bg-accent hover:bg-accent/90 text-dark px-8 py-4 rounded-full font-bold transition-all hover:scale-105 shadow-lg">
              Découvrir son histoire
            </a>
            <a href="#conservation"
              class="bg-white/10 backdrop-blur-sm border-2 border-white hover:bg-white/20 text-white px-8 py-4 rounded-full font-bold transition-all">
              Programmes de conservation
            </a>
          </div>
        </div>
      </div>


  </section>

  <main class="max-w-7xl mx-auto px-6 py-20">

    <!-- HISTOIRE SECTION -->
    <section id="histoire" class="mb-32">
      <div class="text-center mb-16">
        <span class="text-accent font-bold text-sm tracking-wider uppercase">Histoire & Origine</span>
        <h2 class="text-5xl font-extrabold gradient-text mt-4 mb-6">
          L'Héritage du Roi Berbère
        </h2>
        <div class="w-24 h-1 bg-accent mx-auto"></div>
      </div>

      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
          <div class="bg-gradient-to-br from-primary/5 to-secondary/5 border-l-4 border-accent p-8 rounded-2xl">
            <h3 class="text-2xl font-bold text-primary mb-4">Habitat Naturel</h3>
            <p class="text-gray-700 leading-relaxed">
              Présent autrefois du Maroc jusqu'à l'Égypte, le Lion de l'Atlas occupait les montagnes de l'Atlas,
              les forêts denses et les régions semi-arides. Il jouait un rôle essentiel de prédateur dominant,
              maintenant l'équilibre naturel des espèces.
            </p>
          </div>

          <div class="bg-gradient-to-br from-primary/5 to-secondary/5 border-l-4 border-accent p-8 rounded-2xl">
            <h3 class="text-2xl font-bold text-primary mb-4">Caractéristiques Uniques</h3>
            <p class="text-gray-700 leading-relaxed">
              Reconnaissable à sa crinière exceptionnellement épaisse, longue et sombre, s'étendant parfois jusqu'au
              ventre.
              Cette crinière le protégeait du froid des zones montagneuses et renforçait son apparence imposante.
            </p>
          </div>

          <div class="bg-gradient-to-br from-red-50 to-orange-50 border-l-4 border-red-500 p-8 rounded-2xl">
            <h3 class="text-2xl font-bold text-red-700 mb-4">Extinction</h3>
            <p class="text-gray-700 leading-relaxed">
              L'expansion humaine, la déforestation et la chasse intensive ont conduit à son extinction à l'état sauvage
              au début du XXᵉ siècle. Le dernier individu connu aurait été observé au Maroc vers 1922.
            </p>
          </div>
        </div>

        <div class="relative">
          <div class="absolute inset-0 bg-gradient-to-br from-accent/20 to-primary/20 rounded-3xl transform rotate-3">
          </div>
          <img src="../../assets/images/lion-male-roar.avif" alt="Lion de l'Atlas"
            class="relative rounded-3xl shadow-2xl w-full h-[600px] object-cover">
        </div>
      </div>
    </section>

    <!-- CARACTÉRISTIQUES PHYSIQUES -->
    <section class="mb-32 bg-gradient-to-br from-primary/5 to-secondary/5 rounded-3xl p-12">
      <div class="text-center mb-12">
        <span class="text-accent font-bold text-sm tracking-wider uppercase">Fiche Technique</span>
        <h2 class="text-5xl font-extrabold gradient-text mt-4">
          Caractéristiques Physiques
        </h2>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-white rounded-2xl p-8 card-hover text-center">
          <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-4xl"><img src="../../assets/images/measuring-tape.png" class="h-10 w-10"></span>
          </div>
          <h3 class="text-xl font-bold text-primary mb-2">Taille</h3>
          <p class="text-3xl font-extrabold text-accent mb-2">3m</p>
          <p class="text-gray-600">Longueur totale</p>
        </div>

        <div class="bg-white rounded-2xl p-8 card-hover text-center">
          <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-4xl"><img src="../../assets/images/weight.png" class="h-10 w-10"></span>
          </div>
          <h3 class="text-xl font-bold text-primary mb-2">Poids</h3>
          <p class="text-3xl font-extrabold text-accent mb-2">180-270kg</p>
          <p class="text-gray-600">Mâle adulte</p>
        </div>

        <div class="bg-white rounded-2xl p-8 card-hover text-center">
          <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-4xl"><img src="../../assets/images/paw.png" class="h-10 w-10"></span>
          </div>
          <h3 class="text-xl font-bold text-primary mb-2">Crinière</h3>
          <p class="text-3xl font-extrabold text-accent mb-2">Dense</p>
          <p class="text-gray-600">Longue et foncée</p>
        </div>

        <div class="bg-white rounded-2xl p-8 card-hover text-center">
          <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-4xl"><img src="../../assets/images/health.png" class="h-10 w-10"></span>
          </div>
          <h3 class="text-xl font-bold text-primary mb-2">Longévité</h3>
          <p class="text-3xl font-extrabold text-accent mb-2">15-20ans</p>
          <p class="text-gray-600">En captivité</p>
        </div>
      </div>
    </section>

    <!-- MODE DE VIE & ALIMENTATION -->
    <section class="mb-32">
      <div class="grid lg:grid-cols-2 gap-12">
        <div class="bg-white rounded-3xl p-12 shadow-xl card-hover">
          <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 bg-secondary/10 rounded-2xl flex items-center justify-center">
              <span class="text-4xl"><img src="../../assets/images/Animal_s_lifestyle.png" class="h-16e w-16e"></span>
            </div>
            <h3 class="text-3xl font-extrabold text-primary">Mode de vie</h3>
          </div>
          <p class="text-gray-700 leading-relaxed text-lg mb-6">
            Contrairement aux lions de savane, le Lion de l'Atlas vivait dans des zones montagneuses et boisées.
            Il était souvent observé seul ou en petits groupes, ce qui témoigne de son adaptation unique à
            des environnements plus froids et escarpés.
          </p>
          <div class="flex flex-wrap gap-3">
            <span class="bg-secondary/10 text-secondary px-4 py-2 rounded-full text-sm font-semibold">Montagnard</span>
            <span class="bg-secondary/10 text-secondary px-4 py-2 rounded-full text-sm font-semibold">Solitaire</span>
            <span class="bg-secondary/10 text-secondary px-4 py-2 rounded-full text-sm font-semibold">Territorial</span>
          </div>
        </div>

        <div class="bg-white rounded-3xl p-12 shadow-xl card-hover">
          <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 bg-accent/10 rounded-2xl flex items-center justify-center">
              <span class="text-4xl"><img src="../../assets/images/lion_alimentaire.png" class="h-18 w-16"></span>
            </div>
            <h3 class="text-3xl font-extrabold text-primary">Alimentation</h3>
          </div>
          <p class="text-gray-700 leading-relaxed text-lg mb-6">
            Carnivore strict, le Lion de l'Atlas se nourrissait principalement d'ongulés, de sangliers et
            parfois de bétail, ce qui a malheureusement contribué aux conflits avec les populations locales
            et à sa disparition progressive.
          </p>
          <div class="flex flex-wrap gap-3">
            <span class="bg-accent/10 text-accent px-4 py-2 rounded-full text-sm font-semibold">Carnivore</span>
            <span class="bg-accent/10 text-accent px-4 py-2 rounded-full text-sm font-semibold">Chasseur</span>
            <span class="bg-accent/10 text-accent px-4 py-2 rounded-full text-sm font-semibold">Opportuniste</span>
          </div>
        </div>
      </div>
    </section>

    <!-- CONSERVATION -->
    <section id="conservation" class="mb-32">
      <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-3xl p-12 border-2 border-red-200">
        <div class="max-w-4xl mx-auto text-center">
          <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="text-4xl"><img src="../../assets/images/skeleton.png" class="h-16 w-16"></span>
          </div>

          <h2 class="text-4xl font-extrabold text-red-700 mb-4">
            Statut de Conservation
          </h2>

          <div class="inline-block bg-red-600 text-white px-8 py-3 rounded-full font-bold text-xl mb-6">
            Éteint à l'état sauvage
          </div>

          <p class="text-gray-700 text-lg leading-relaxed mb-8">
            Des descendants présumés subsistent en captivité dans certains zoos à travers le monde.
            Le Zoo ASSAD soutient activement les programmes de préservation génétique et de sensibilisation
            du public pour honorer la mémoire de ce roi disparu.
          </p>

          <div class="grid md:grid-cols-3 gap-6 mt-12">
            <div class="bg-white rounded-2xl p-6 shadow-lg">
              <div class="text-3xl mb-3"><img src="../../assets/images/vibrant-traditional.png" class="h-16e w-16e">
              </div>
              <h4 class="font-bold text-primary mb-2">Conservation génétique</h4>
              <p class="text-sm text-gray-600">Préservation de la lignée</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg">
              <div class="text-3xl mb-3"><img
                  src="../../assets/images/png-clipart-education-logo-pre-school-others-text-logo-thumbnail.png"
                  class="h-16e w-16e"></div>
              <h4 class="font-bold text-primary mb-2">Éducation</h4>
              <p class="text-sm text-gray-600">Sensibilisation du public</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg">
              <div class="text-3xl mb-3"><img src="../../assets/images/pngtree-science.png" class="h-16e w-16e"></div>
              <h4 class="font-bold text-primary mb-2">Recherche</h4>
              <p class="text-sm text-gray-600">Études scientifiques</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CAN 2025 SECTION -->
    <section class="relative mb-24">
      <div
        class="bg-gradient-to-br from-primary via-secondary to-accent rounded-[2.5rem] p-16 md:p-20 text-white shadow-2xl overflow-hidden">

        <!-- Décor flou -->
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative max-w-4xl mx-auto text-center">

          <!-- Logo CAN -->
          <div class="flex justify-center mb-6">
            <div class="">
              <img src="../../assets/images/Symbole-can_maroc.png" alt="Symbole CAN 2025"
                class="h-56 w-56 object-contain">
            </div>
          </div>

          <!-- Titre -->
          <h2 class="text-4xl md:text-5xl font-extrabold mb-6 tracking-tight">
            Symbole de la CAN 2025
          </h2>

          <!-- Description -->
          <p class="text-lg md:text-xl leading-relaxed text-white/90 max-w-3xl mx-auto mb-10">
            Le Lion de l’Atlas incarne la fierté, la résilience et la puissance du
            continent africain. Son image symbolise l’esprit de la CAN 2025
            organisée au Maroc, célébrant l’héritage naturel et culturel de
            l’Afrique du Nord.
          </p>

          <!-- Tags -->
          <div class="flex flex-wrap justify-center gap-4">
            <span
              class="px-6 py-3 rounded-full bg-white/20 backdrop-blur-md font-semibold hover:bg-white/30 transition">
              Fierté
            </span>
            <span
              class="px-6 py-3 rounded-full bg-white/20 backdrop-blur-md font-semibold hover:bg-white/30 transition">
              Résilience
            </span>
            <span
              class="px-6 py-3 rounded-full bg-white/20 backdrop-blur-md font-semibold hover:bg-white/30 transition">
              Puissance
            </span>
            <span
              class="px-6 py-3 rounded-full bg-white/20 backdrop-blur-md font-semibold hover:bg-white/30 transition">
              Héritage
            </span>
          </div>

        </div>
      </div>
    </section>


  </main>

  <!-- Footer -->
  <?php require_once '../layouts/footer.php'; ?>

</body>

</html>