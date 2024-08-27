<?php
session_start(); // Démarrer la session

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vol_id'])) {
    // Récupérer l'ID du vol depuis le formulaire
    $volId = $_POST['vol_id'];

    // Stocker l'ID du vol dans la session
    $_SESSION['vol_id'] = $volId;

    // Rediriger vers une page de confirmation ou de paiement
    header('Location: configVol.php'); // Vous pouvez changer 'confirmation.php' à votre convenance
    exit();
}
?>
