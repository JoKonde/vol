<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Vol.php';
require_once 'Role.php';

session_start();

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();


$compagnie = new Compagnie($db);



$compagnie->nom = $_POST['nom'];
$compagnie->create();

header("Location: dashboard.php");




?>
