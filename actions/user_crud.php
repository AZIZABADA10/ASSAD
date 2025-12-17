<?php

    require_once __DIR__ .'/../config/db.php';

    $users = $connexion -> query("SELECT * FROM utilisateurs order by id_utilisateur desc");


?>