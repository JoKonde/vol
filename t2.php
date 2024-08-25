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


$compagnie = new Compagnie($db);

$compagnie->nom = $_POST['nom'];
$compagnie->adresse = $_POST['adresse'];
if(!$compagnie->nom || !$compagnie->adresse){
    $_SESSION['msg'] = "Veuillez svp, selectionner tous les champs.";
    header("Location: dashboard.php");

}else{
    $comp= $compagnie->create();
    $_SESSION['nomCompagnie'] =$comp->nom;
    $_SESSION['adresseCompagnie'] =$comp->adresse;
    
header("Location: dashboard.php");
}





?>
