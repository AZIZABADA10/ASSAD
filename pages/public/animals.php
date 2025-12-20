<?php

require_once '../../config/db.php';

$animal = $connexion -> query("SELECT * FROM animal")->fetch_assoc();



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