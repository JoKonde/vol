<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Vol.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Créer un utilisateur
$user = new User($db);

/*$user->email = 'client@example.com';
$user->password = '123456';
$user->role_id = 2; // Client
if($user->create()) {
    echo "User created successfully.";
} else {
    echo "User could not be created.";
}*/

// Connexion d'un utilisateur
echo $_POST['email'];
echo $_POST['password'];
$user->email = $_POST['email'];
$user->password = $_POST['password'];
$loggedInUser = $user->login();
if($loggedInUser) {
    echo "User logged in successfully.";
} else {
    echo "Login failed.";
}

// Rechercher un vol
$vol = new Vol($db);

$vols = $vol->search('Paris', 'New York', '2024-12-24 00:00:00');
if($vols->rowCount() > 0) {
    while ($row = $vols->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "Vol trouvé: $ville_depart -> $ville_arrivee le $date_vol.";
    }
} else {
    echo "Aucun vol trouvé.";
}
?>
