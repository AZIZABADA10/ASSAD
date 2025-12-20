<?php

require_once '../../config/db.php';

$animaux = $connexion->query("SELECT * FROM animal")->fetch_all(MYSQLI_ASSOC);



 /** Header  */
require_once '../layouts/header.php';
?>

<main class="mt-80 h-[400px]">
<?php var_dump($animal) ?>
</main>

<?php
/** Footer */
require_once '../layouts/footer.php';
?>