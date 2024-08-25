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
    $role->id = $user->role_id;
    $role= $role->findById($user->role_id);
    $_SESSION['email'] =$user->email;
    $_SESSION['noms'] =$user->noms;
    $_SESSION['role'] =$role->nom;
    header("Location: dashboard.php");
    exit();
} else {
    $_SESSION['msg'] = "Informations incorrectes, veuillez bien verifier vos informations.";
    header("Location: index.php");
    exit();
}


?>
