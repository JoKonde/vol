<!DOCTYPE html>
<html lang="fr">
  <?php 
  session_start();
  require_once 'Database.php';
require_once 'User.php';
require_once 'Vol.php';
require_once 'Role.php';
require_once 'Compagnie.php';
require_once 'MonVol.php';

$database = new Database();
$db = $database->getConnection();
  $compagnie = new Compagnie($db);
 $listCompagnies= $compagnie->read();
 $vol = new Vol($db);
 $monVol = new MonVol($db);
 $volId=$_SESSION['vol_id'];
$userId=$_SESSION['idUser'];
 $listBillets= $monVol->rechercheParUser($userId);
?>
<head>
<meta charset="utf-8">
  <title>JMK TRAVEL | Acceuil</title>
  <!-- SEO Meta Tags-->
  <meta name="description" content="JMK TRAVEL">
  <meta name="keywords" content="travel, flight, voyage,vol,avion">
  <meta name="author" content="JMK TRAVEL">
  <!-- Viewport-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicon and Touch Icons-->
  <link rel="apple-touch-icon" sizes="180x180" href="logo.png">
  <link rel="icon" type="image/png" sizes="32x32" href="logo.png">
  <link rel="icon" type="image/png" sizes="16x16" href="logo.png">
  <link rel="manifest" href="site.webmanifest">
  <link rel="mask-icon" color="#5bbad5" href="safari-pinned-tab.svg">
  <meta name="msapplication-TileColor" content="#766df4">
  <meta name="theme-color" content="#ffffff">
    <!-- Page loading styles-->
    <style>
      .page-loading {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        -webkit-transition: all .4s .2s ease-in-out;
        transition: all .4s .2s ease-in-out;
        background-color: #fff;
        opacity: 0;
        visibility: hidden;
        z-index: 9999;
      }
      .page-loading.active {
        opacity: 1;
        visibility: visible;
      }
      .page-loading-inner {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        text-align: center;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        -webkit-transition: opacity .2s ease-in-out;
        transition: opacity .2s ease-in-out;
        opacity: 0;
      }
      .page-loading.active > .page-loading-inner {
        opacity: 1;
      }
      .page-loading-inner > span {
        display: block;
        font-size: 1rem;
        font-weight: normal;
        color: #666276;;
      }
      .page-spinner {
        display: inline-block;
        width: 2.75rem;
        height: 2.75rem;
        margin-bottom: .75rem;
        vertical-align: text-bottom;
        border: .15em solid #bbb7c5;
        border-right-color: transparent;
        border-radius: 50%;
        -webkit-animation: spinner .75s linear infinite;
        animation: spinner .75s linear infinite;
      }
      @-webkit-keyframes spinner {
        100% {
          -webkit-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      @keyframes spinner {
        100% {
          -webkit-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      
    </style>
    <!-- Page loading scripts-->
    <script>
      (function () {
        window.onload = function () {
          var preloader = document.querySelector('.page-loading');
          preloader.classList.remove('active');
          setTimeout(function () {
            preloader.remove();
          }, 2000);
        };
      })();
      
    </script>
    <!-- Vendor Styles-->
    <link rel="stylesheet" media="screen" href="vendor/simplebar/dist/simplebar.min.css"/>
    <link rel="stylesheet" media="screen" href="vendor/flatpickr/dist/flatpickr.min.css"/>
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="css/theme.min.css">
    
  </head>
  <!-- Body-->
  <body class="bg-secondary">
   
    <!-- Page loading spinner-->
    <div class="page-loading active">
      <div class="page-loading-inner">
        <div class="page-spinner"></div><span>Loading...</span>
      </div>
    </div>
    <main class="page-wrapper">
      <!-- Navbar-->
      <header class="navbar navbar-expand-lg navbar-light fixed-top" data-scroll-header>
        <div class="container">
          <a class="navbar-brand me-3 me-xl-4" href="index.php">
            <img class="d-block" src="img/logo.png" width="90" alt="Finder"></a>
          <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="dropdown d-none d-lg-block order-lg-3 my-n2 me-3"><a class="d-block py-2" href="city-guide-account-info.html"><img class="rounded-circle" src="img/avatars/36.png" width="40" alt="Annette Black"></a>
            <div class="dropdown-menu dropdown-menu-end">
              <div class="d-flex align-items-start border-bottom px-3 py-1 mb-2" style="width: 16rem;"><img class="rounded-circle" src="img/avatars/24.png" width="48" alt="Annette Black">
                <div class="ps-2">
                  <h6 class="fs-base mb-0">
                  <?php 
                    echo $_SESSION['noms']
                ?>
                  </h6>
                  
                  <span class="star-rating star-rating-sm"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i></span>
                  <p>
                    Role:
                    <?php 
                      echo $_SESSION['role']
                    ?>
                  </p>
                </div>
              </div>
              
              
              <?php
if ($_SESSION['role'] == "Admin") { 
    ?>
    <a class="dropdown-item" href="dashboard.php"><i class="fi-user opacity-60 me-2"></i>Compagnie d'avions</a>
    <a class="dropdown-item" href="vols.php"><i class="fi-heart opacity-60 me-2"></i>Vols</a>
    <?php
} else {
    ?>
    <a class="dropdown-item " href="#"><i class="fi-home opacity-60 me-2"></i>Reservations</a>
              <a class="dropdown-item" href="#"><i class="fi-home opacity-60 me-2"></i>Mes Vols</a>
              <a class="dropdown-item" href="#"><i class="fi-star opacity-60 me-2"></i>Payements</a>
    <?php
}
?>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="index.php">Deconnexion</a>
            </div>
          </div>
          
          
          <div class="collapse navbar-collapse order-lg-2" id="navbarNav">
            <ul class="navbar-nav navbar-nav-scroll" style="max-height: 35rem;">
            <li class="nav-item dropdown active me-lg-2"><a class="nav-link align-items-center pe-lg-4" href="#" role="button" aria-expanded="false"><i class="fi-layers me-2"></i>Acceuil<span class="d-none d-lg-block position-absolute top-50 end-0 translate-middle-y border-end" style="width: 1px; height: 30px;"></span></a>

</li>
<!-- Menu items-->

              
              
              <li class="nav-item dropdown d-lg-none"><a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="rounded-circle me-2" src="img/avatars/36.png" width="30" alt="user">
              <?php 
                    echo $_SESSION['noms']
                ?>
            </a>
                <div class="dropdown-menu">
                  <div class="ps-3"><span class="star-rating star-rating-sm"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i></span>
                    <div class="fs-xs py-2">(302) 555-0107<br>annette_black@email.com</div>
                  </div><a class="dropdown-item" href="city-guide-account-info.html"><i class="fi-user opacity-60 me-2"></i>Personal Info</a><a class="dropdown-item" href="city-guide-account-favorites.html"><i class="fi-heart opacity-60 me-2"></i>Favorites</a><a class="dropdown-item" href="city-guide-vendor-businesses.html"><i class="fi-home opacity-60 me-2"></i>My Businesses</a><a class="dropdown-item" href="city-guide-account-reviews.html"><i class="fi-star opacity-60 me-2"></i>Reviews</a><a class="dropdown-item" href="city-guide-account-notifications.html"><i class="fi-bell opacity-60 me-2"></i>Notifications</a>
                  <div class="dropdown-divider"></div><a class="dropdown-item" href="city-guide-help-center.html">Help</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </header>
      <!-- Page content-->
      <!-- Page container-->
      <div class="container mt-5 mb-md-4 py-5">
        <!-- Breadcrumbs-->
        
        <!-- Account header-->
        <div class="d-flex align-items-center justify-content-between pb-4 mb-2">
          <div class="d-flex align-items-center">
            <div class="position-relative flex-shrink-0"><img class="rounded-circle border border-white" src="img/avatars/29.png" width="100" alt="Annette Black">
              <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm position-absolute end-0 bottom-0" type="button" data-bs-toggle="tooltip" title="Change image"><i class="fi-pencil fs-xs"></i></button>
            </div>
            <div class="ps-3 ps-sm-4">
              <h3 class="h4 mb-2">
                <?php 
                    echo $_SESSION['noms']
                ?>
              </h3><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i></span>
              <p>
                    Role:
                    <?php 
                      echo $_SESSION['role']
                    ?>
                  </p>
            </div>
          </div>
        </div>
        <!-- Page content-->
        <div class="card card-body p-4 p-md-5 shadow-sm">
          <!-- Account nav-->
          <div class="mt-md-n3 mb-4">
            <a class="btn btn-outline-primary btn-lg rounded-pill w-100 d-md-none" href="#account-nav" data-bs-toggle="collapse">
              <i class="fi-align-justify me-2"></i>
          <?php 
                    echo $_SESSION['noms']
            ?>
        </a>
            <div class="collapse d-md-block" id="account-nav">
              <ul class="nav nav-pills flex-column flex-md-row pt-3 pt-md-0 pb-md-4 border-bottom-md">
              <?php
if ($_SESSION['role'] == "Admin") { 
    ?>
    <li class="nav-item mb-md-0 me-md-2 pe-md-1">
        <a class="nav-link active" href="dashboard.php" aria-current="page">
            <i class="fi-user mt-n1 me-2 fs-base"></i>Compagnie d'aviation
        </a>
    </li>
    <li class="nav-item mb-md-0 me-md-2 pe-md-1">
        <a class="nav-link" href="vols.php">
            <i class="fi-heart mt-n1 me-2 fs-base"></i>Vols
        </a>
    </li>
    <?php
} else {
    ?>
    <li class="nav-item mb-md-0 me-md-2 pe-md-1">
        <a class="nav-link " href="dashboard.php">
            <i class="fi-heart mt-n1 me-2 fs-base"></i>Reservations
        </a>
    </li>
    <li class="nav-item mb-md-0 me-md-2 pe-md-1">
        <a class="nav-link active" href="configVol.php">
            <i class="fi-star mt-n1 me-2 fs-base"></i>Mes Vols
        </a>
    </li>
    <li class="nav-item mb-md-0">
        <a class="nav-link" href="#">
            <i class="fi-bell mt-n1 me-2 fs-base"></i>Payements
        </a>
    </li>
    <?php
}
?>

                
                <li class="nav-item d-md-none"><a class="nav-link" href="index.php"><i class="fi-logout mt-n1 me-2 fs-base"></i>Deconnexion</a></li>
              </ul>
            </div>
          </div>
          <?php
if ($_SESSION['role'] == "Client") { 
    ?>
          <div class="d-flex flex-md-row flex-column align-items-md-center justify-content-md-between mb-4 pt-2">
            <h1 class="h3 mb-0">Configurer mon vol</h1>
          </div>
          <form action="t5.php" method="post">
            <div class="border rounded-3 p-3 mb-2" id="personal-info">
            <!-- Name-->
            <?php
                  if (isset($_SESSION['msg'])) {
                    echo "<p class='alert alert-danger'>" . $_SESSION['msg'] . "</p>";
                    // Supprimer le message d'erreur après l'affichage
                    unset($_SESSION['msg']);
                  }
                  ?>
            <div class="border-bottom pb-3 mb-3">
              <div class="d-flex align-items-center justify-content-between">
                <div class="pe-2">
                  <label class="form-label fw-bold">Nombre Adulte</label>
                  <div id="name-value"><?php 
                  if(isset($_SESSION['nbre_adulte'])){
                    if($_SESSION['nbre_adulte']){
                      echo $_SESSION['nbre_adulte'];
                    }
                  }
                  ?>
                  </div>
                </div>
                <div data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#name-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>

                
              </div>
              <div class="collapse" id="name-collapse" data-bs-parent="#personal-info">
                <input class="form-control mt-3" name="nbre_adulte" type="number" data-bs-binded-element="#name-value" data-bs-unset-value="---vide----" >
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <div class="pe-2">
                  <label class="form-label fw-bold">Nombre Bébé</label>
                  <div id="adresse-value"><?php 
                  if(isset($_SESSION['nbre_bebe'])){
                    if($_SESSION['nbre_bebe']){
                      echo $_SESSION['nbre_bebe'];
                    }
                  }
                  ?>
                  </div>
                </div>
                <div data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#adresse-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
              </div>
              
              
              <div class="collapse" id="adresse-collapse" data-bs-parent="#personal-info">
                <input class="form-control mt-3" name="nbre_bebe" type="number" data-bs-binded-element="#adresse-value" data-bs-unset-value="---vide----" > 
              </div>
              
            </div>
            <div class="border-bottom pb-3 mb-3">
              <div class="d-flex align-items-center justify-content-between">
                <div class="pe-2">
                  <label class="form-label fw-bold">Nombre Enfant</label>
                  <div id="name-value"><?php 
                  if(isset($_SESSION['nbre_enfant'])){
                    if($_SESSION['nbre_enfant']){
                      echo $_SESSION['nbre_enfant'];
                    }
                  }
                  ?>
                  </div>
                </div>
                <div data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#name-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>

                
              </div>
              <div class="collapse" id="name-collapse" data-bs-parent="#personal-info">
                <input class="form-control mt-3" name="nbre_enfant" type="number" data-bs-binded-element="#name-value" data-bs-unset-value="---vide----" >
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <div class="pe-2">
                  <label class="form-label fw-bold">Nombre Bébé</label>
                  <div id="adresse-value"><?php 
                  if(isset($_SESSION['nbre_bebe'])){
                    if($_SESSION['nbre_bebe']){
                      echo $_SESSION['nbre_bebe'];
                    }
                  }
                  ?>
                  </div>
                </div>
                <div data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#adresse-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
              </div>
              
              
              <div class="collapse" id="adresse-collapse" data-bs-parent="#personal-info">
                <input class="form-control mt-3" name="nbre_bebe" type="number" data-bs-binded-element="#adresse-value" data-bs-unset-value="---vide----" > 
              </div>
              
            </div>
            
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <button class="btn btn-primary rounded-pill px-3 px-sm-4" type="submit">Enregistrer</button>
          </div>
          </form>
          <div class="d-flex flex-md-row flex-column align-items-md-center justify-content-md-between mb-4 pt-2">
            <h1 class="h3 mb-0">Liste Billets</h1>
          </div>
          <table class="table table-striped-columns">
    <tr>
        <td>#</td>
        <td>Nombre Adulte</td>
        <td>Nombre Bébé</td>
        <td>Nombre Enfant</td>
        <td>Vol</td>
        <td>Action</td>
    </tr>

    <?php
    $index = 1; // Initialiser la variable de numérotation
    foreach ($listBillets as $billet) { ?>
    <tr>
        <td><?php echo $index++; ?></td>
        <td><?php echo $billet['nbre_adulte']; ?></td>
        <td><?php echo $billet['nbre_bebe']; ?></td>
        <td><?php echo $billet['nbre_enfant']; ?></td>
        <td><?php echo $billet['vol_id']; ?></td>
        <td>
        <form name="pay" method="post" action="https://checkout.genesyspay.solutions/v1/init">
        <input type="hidden" name="public_key" value="GPPUB-7258581b9cb7117fdbcc230a3f7017ffde23fbb6">
        <input type="hidden" name="order_id" value="
        <?php 
        echo sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), // 32 bits for "time_low"
        mt_rand(0, 0xffff), // 16 bits for "time_mid"
        mt_rand(0, 0x0fff) | 0x4000, // 16 bits for "time_hi_and_version", four most significant bits hold version number 4
        mt_rand(0, 0x3fff) | 0x8000, // 16 bits, 8 bits for "clk_seq_hi_res", 8 bits for "clk_seq_low", two most significant bits hold zero and one for variant DCE1.1
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff) // 48 bits for "node"
    ); ?>
        ">
        
        <input type="hidden" name="amount" value="
        <?php 
        $leVol=new Vol($db);
        $leVol= $leVol->findById($billet['vol_id']);
        $_SESSION['monVol'] = $billet['id'];
        $montant=($leVol["montant"]*$billet['nbre_adulte'])+($leVol["montant"]*$billet['nbre_bebe'])+($leVol["montant"]*$billet['nbre_enfant']);
        $_SESSION['montant'] = $montant;
        echo  $montant; 
        
        ?>
        
        ">
        <input type="hidden" name="currency" value="USD">
        <input type="hidden" name="redirect_url" value="http://localhost/vol/payement-reussi.php">
        <input type="hidden" name="status_url" value="https://callback.url">
        <input type="hidden" name="cancel_url" value="http://localhost/vol/payement-annule.php">
        <input type="hidden" name="failed_url" value="http://localhost/vol/payement-echec.php">
        <button type="submit" class="btn btn-primary btn-lg rounded-pill w-10">Payer</button>
    </form>
             </td>
    </tr>
    <?php } ?>
</table>
<?php }else{ ?>
    <!--debut ici!-->
    <div class="col-xl-8 col-lg-9 col-md-10 mx-auto px-0 mt-4">
            <!-- Search form-->
            <form class="form-group d-block d-md-flex position-relative rounded-md-pill mb-2 mb-sm-4 mb-lg-5" action="dashboard.php" method="post">
              <div class="input-group input-group-lg border-end-md">
                <div class="dropdown w-100 mb-sm-0 mb-3" data-bs-toggle="select">
                  <button class="btn btn-link btn-lg dropdown-toggle ps-2 ps-sm-3" type="button" data-bs-toggle="dropdown">
                    <i class="fi-list me-2"></i><span class="dropdown-toggle-label">Ville de depart</span>
                  </button>
                  <input type="hidden" name="villeDepart" id="villeDepart">
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-value="Kinshasa"><i class="fi-bed fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Kinshasa</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Lubumbashi"><i class="fi-cafe fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Lubumbashi</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Kananga"><i class="fi-shopping-bag fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Kananga</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Kisangani"><i class="fi-museum fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Kisangani</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Goma"><i class="fi-entertainment fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Goma</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Matadi"><i class="fi-meds fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Matadi</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Kindu"><i class="fi-makeup fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Kindu</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="GEMENA"><i class="fi-car fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">GEMENA</span></a></li>
                  </ul>
                </div>
              </div>
              <hr class="d-md-none my-2">
              <div class="d-sm-flex">
                <div class="dropdown w-100 mb-sm-0 mb-3" data-bs-toggle="select">
                  <button class="btn btn-link btn-lg dropdown-toggle ps-2 ps-sm-3" type="button" data-bs-toggle="dropdown">
                    <i class="fi-list me-2"></i><span class="dropdown-toggle-label">Ville de destination</span>
                  </button>
                  <input type="hidden" name="villeArrivee" id="villeArrivee">
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-value="Kinshasa"><i class="fi-bed fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Kinshasa</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Lubumbashi"><i class="fi-cafe fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Lubumbashi</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Kananga"><i class="fi-shopping-bag fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Kananga</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Kisangani"><i class="fi-museum fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Kisangani</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Goma"><i class="fi-entertainment fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Goma</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Matadi"><i class="fi-meds fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Matadi</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="Kindu"><i class="fi-makeup fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">Kindu</span></a></li>
                    <li><a class="dropdown-item" href="#" data-value="GEMENA"><i class="fi-car fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">GEMENA</span></a></li>
                  </ul>
                </div>
                <button class="btn btn-primary btn-lg rounded-pill w-100 w-md-auto ms-sm-3" type="submit">Chercher</button>
              </div>
            </form>
          </div>


          <section class="container py-5 pt-xxl-4 mt-md-2 mb-md-4 px-4">
      <div class="row row-cols-lg-6 row-cols-sm-3 row-cols-2 g-3 g-xl-4">
        <div class="d-flex flex-md-row flex-column align-items-md-center justify-content-md-between mb-4 pt-2">
          <h1 class="h3 mb-0">Liste Vols</h1>
        </div>
        <table class="table table-striped-columns">
          <tr>
            <td>#</td>
            <td>Ville Depart</td>
            <td>Date Depart</td>
            <td>Ville d'arrivée</td>
            <td>Date Arrivée</td>
            <td>Prix</td>
            <td>Compagnie</td>
            <td>Action</td>
          </tr>

          <?php
          $index = 1; // Initialiser la variable de numérotation
          $compOne = new Compagnie($db);
          $compOne2 = new Compagnie($db);
          // Initialiser les variables avec une valeur par défaut
          $villeDepart = isset($_POST['villeDepart']) ? $_POST['villeDepart'] : '';
          $villeArrivee = isset($_POST['villeArrivee']) ? $_POST['villeArrivee'] : '';
          // Déterminer la liste des vols en fonction des entrées du formulaire
          if ($villeDepart && $villeArrivee) {
            $listVols = $vol->rechercheParVille($villeDepart, $villeArrivee);
          } else {
            $listVols = $vol->read();
          }


          foreach ($listVols as $vol) {
            $compOne2 = $compOne->findById($vol['compagnie_id']);
          ?>
            <tr>
              <td><?php echo $index++; ?></td>
              <td><?php echo $vol['ville_depart']; ?></td>
              <td><?php echo $vol['date_vol_depart']; ?></td>
              <td><?php echo $vol['ville_arrivee']; ?></td>
              <td><?php echo $vol['date_vol_arrivee']; ?></td>
              <td><?php echo $vol['montant'] . "$"; ?></td>
              <td><?php echo $compOne2['nom']; ?></td>
             <td>
             <form method="post" action="saveId.php">
                    <input type="hidden" name="vol_id" value="<?php echo htmlspecialchars($vol['id']); ?>">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill w-10">Payer</button>
                </form>
             </td>
              
            </tr>
          <?php } ?>
        </table>
      </div>
    </section>
    <!--fin ici!-->


    <?php } ?>
        </div>
      </div>
    </main>
    <!-- Footer-->
    <footer class="footer pt-lg-5 pt-4 bg-dark text-light">
    
    <div class="py-4 border-top border-light">
      <div class="container d-flex flex-column flex-lg-row align-items-center justify-content-between py-2">
        <!-- Copyright-->
        <p class="order-lg-1 order-2 fs-sm mb-2 mb-lg-0"><span class="text-light opacity-60">&copy; 2024 Tous les droits reservés.</span></p>
        <div class="d-flex flex-lg-row flex-column align-items-center order-lg-2 order-1 ms-lg-4 mb-lg-0 mb-4">
          <!-- Links-->
          
          <div class="d-flex align-items-center">
            <!-- Language switcher-->
            
            <!-- Socials-->
            <div class="ms-4 ps-lg-2 text-nowrap"><a class="btn btn-icon btn-translucent-light btn-xs rounded-circle ms-2" href="#"><i class="fi-facebook"></i></a><a class="btn btn-icon btn-translucent-light btn-xs rounded-circle ms-2" href="#"><i class="fi-twitter"></i></a><a class="btn btn-icon btn-translucent-light btn-xs rounded-circle ms-2" href="#"><i class="fi-telegram"></i></a><a class="btn btn-icon btn-translucent-light btn-xs rounded-circle ms-2" href="#"><i class="fi-messenger"></i></a></div>
          </div>
        </div>
      </div>
    </div>
  </footer>
    <!-- Back to top button--><a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon fi-chevron-up">   </i></a>
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="vendor/flatpickr/dist/flatpickr.min.js"></script>
    <!-- Main theme script-->
    <script src="js/theme.min.js"></script>
    <script>
    // Obtenir la date d'aujourd'hui
    const today = new Date().toISOString().split('T')[0];

    // Définir l'attribut min de l'élément input
    document.getElementById('date_vol_depart').setAttribute('min', today);
    document.getElementById('date_vol_arrivee').setAttribute('min', today);

    document.querySelectorAll('.dropdown-item').forEach(item => {
      item.addEventListener('click', function(e) {
        e.preventDefault();
        let selectedValue = this.getAttribute('data-value');
        let selectedText = this.querySelector('.dropdown-item-label').textContent;

        let parentDropdown = this.closest('.dropdown');

        if (parentDropdown.querySelector('.dropdown-toggle-label').textContent.includes('Ville de depart')) {
          // Pour la ville de départ : envoyer l'ID et afficher le nom
          document.getElementById('villeDepart').value = selectedValue;
          parentDropdown.querySelector('.dropdown-toggle-label').textContent = selectedText;
        } else if (parentDropdown.querySelector('.dropdown-toggle-label').textContent.includes("Ville d'arrivée")) {
          // Pour la ville d'arrivée : envoyer l'ID et afficher le nom
          document.getElementById('villeArrivee').value = selectedValue;
          parentDropdown.querySelector('.dropdown-toggle-label').textContent = selectedText;
        }
      });
    });
  </script>
  </body>
</html>