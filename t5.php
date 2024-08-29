<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Vol.php';
require_once 'Role.php';
require_once 'Compagnie.php';
require_once 'MonVol.php';

session_start();

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();


$monVol = new MonVol($db);
$volId=$_SESSION['vol_id'];
$userId=$_SESSION['idUser'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs POST
    $monVol->nbre_adulte = $_POST['nbre_adulte'];
    $monVol->nbre_bebe = $_POST['nbre_bebe'];
    $monVol->nbre_enfant = $_POST['nbre_enfant'];
    $monVol->vol_id = $volId;
    $monVol->user_id = $userId;
    if($monVol->nbre_adulte<=0){
        $_SESSION['msg'] = "Veuillez svp, le nombre d'adulte doit etre superieur à zéro.";
        header("Location: configVol.php");
    
    }else{
        $monVol->create();
        
        
    }
    
}
    
header("Location: configVol.php");




?>
