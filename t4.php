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
$user->noms = $_POST['noms'];
$user->sexe = $_POST['sexe'];
$user->role_id = 2; // Client


if(!$user->email || !$user->password || !$user->noms || !$user->sexe ) {
    $_SESSION['msg'] = "Informations incorrectes, veuillez bien verifier vos informations.";
    header("Location: index.php");
    exit();
} else {
    $user->create();
    $_SESSION['msgSuc'] = "Compte créé avec succes. Vous pouvez vous connecter maintenant.";
    header("Location: index.php");
    exit();
}


?>
