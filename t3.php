<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Vol.php';
require_once 'Role.php';
require_once 'Compagnie.php';

session_start();

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();


$vol = new Vol($db);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs POST
    $vol->compagnie_id = $_POST['compagnie'];
    $vol->ville_depart = $_POST['villeDepart'];
    $vol->ville_arrivee = $_POST['villeArrivee'];
    $vol->date_vol_depart = $_POST['date_vol_depart'];
    $vol->date_vol_arrivee = $_POST['date_vol_arrivee'];
    $vol->montant = $_POST['montant'];
    $vol->create();
}
    
header("Location: vols.php");




?>
