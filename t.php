<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Vol.php';
require_once 'Role.php';

session_start();

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Créer un utilisateur
$user = new User($db);
$role = new Role($db);

/*$user->email = 'client@example.com';
$user->password = '123456';
$user->role_id = 2; // Client
if($user->create()) {
    echo "User created successfully.";
} else {
    echo "User could not be created.";
}*/

// Connexion d'un utilisateur

$user->email = $_POST['email'];
$user->password = $_POST['password'];
$loggedInUser = $user->login();

if($loggedInUser) {
    //header("Location: dashboard.php");
    $role->id = $user->role_id;
    $role= $role->findById($user->role_id);
    echo json_encode($role);
    $_SESSION['email'] =$user->email;
    exit();
} else {
    $_SESSION['msg'] = "Informations incorrectes, veuillez bien verifier vos informations.";
    header("Location: index.php");
    exit();
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
