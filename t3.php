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
    if(!$vol->compagnie_id || !$vol->ville_depart || !$vol->ville_arrivee || !$vol->date_vol_depart || !$vol->date_vol_arrivee){
        $_SESSION['msg'] = "Veuillez svp, selectionner tous les champs.";
        header("Location: vols.php");
    
    }else{
        if($vol->montant<=0){
            $_SESSION['msg'] = "SVP, le prix du billet doit etre superieur à zero.";
    header("Location: vols.php");
        }else{
            if($vol->ville_depart==$vol->ville_arrivee){
                $_SESSION['msg'] = "SVP, la ville de depart ne peut pas etre la meme que la ville de destination.";
            header("Location: vols.php");
            }else{
                $vol->create();
            }
           
        }
        
    }
    
}
    
header("Location: vols.php");




?>
