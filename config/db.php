<?php

$serveur='localhost';
$utilisateur='adminAssad';
$nom_base_de_donnee = 'assad';
$mot_de_passe = 'Assad@286';

$connexion = new mysqli($serveur,$utilisateur,$mot_de_passe,$nom_base_de_donnee);
if ($connexion -> connect_error) {
    die("Erreur de connexion:". $connexion -> connect_error);
}

?>