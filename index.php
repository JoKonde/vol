<!DOCTYPE html>
<?php
session_start();
require_once 'Database.php';
require_once 'User.php';
require_once 'Vol.php';
require_once 'Role.php';
require_once 'Compagnie.php';


// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$role = new Role($db);
$vol = new Vol($db);

//on cherche si les roles existent deja sinon on le cree
$listRole = $role->read();
if (count($listRole) <= 0) {
  $role->nom = "Admin";
  $role->create();
  $role->nom = "Client";
  $role->create();
}
$listUser = $user->read();
if (count($listUser) <= 0) {
  $user->noms = 'Rachel KAMUANYA';
  $user->sexe = 'F';
  $user->email = 'rachel@gmail.com';
  $user->password = '123456789';
  $user->role_id = 1; // Admin
  $user->create();
}

?>
<html lang="fr">

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

    .page-loading.active>.page-loading-inner {
      opacity: 1;
    }

    .page-loading-inner>span {
      display: block;
      font-size: 1rem;
      font-weight: normal;
      color: #666276;
      ;
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
    (function() {
      window.onload = function() {
        var preloader = document.querySelector('.page-loading');
        preloader.classList.remove('active');
        setTimeout(function() {
          preloader.remove();
        }, 2000);
      };
    })();
  </script>
  <!-- Vendor Styles-->
  <link rel="stylesheet" media="screen" href="vendor/simplebar/dist/simplebar.min.css" />
  <link rel="stylesheet" media="screen" href="vendor/tiny-slider/dist/tiny-slider.css" />
  <link rel="stylesheet" media="screen" href="vendor/flatpickr/dist/flatpickr.min.css" />
  <!-- Main Theme Styles + Bootstrap-->
  <link rel="stylesheet" media="screen" href="css/theme.min.css">
  <!-- Google Tag Manager-->

</head>
<!-- Body-->

<body>


  <!-- Page loading spinner-->
  <div class="page-loading active">
    <div class="page-loading-inner">
      <div class="page-spinner"></div><span>Loading...</span>
    </div>
  </div>
  <main class="page-wrapper">
    <!-- Sign In Modal-->
    <div class="modal fade" id="se-connecter" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 950px;">
        <div class="modal-content">
          <div class="modal-body px-0 py-2 py-sm-0">
            <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal"></button>
            <div class="row mx-0 align-items-center">
              <div class="col-md-6 border-end-md p-4 p-sm-5">
                <h2 class="h3 mb-4 mb-sm-5">Salut!<br>Bienvenu.</h2><img class="d-block mx-auto" src="img/signin-modal/signin.svg" width="344" alt="Illustartion">
                <div class="mt-4 mt-sm-5">Vous n'avez pas de compte? <a href="#signup-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Créer en un ici</a></div>
              </div>
              <div class="col-md-6 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">


                <form class="needs-validation" method="post" action="t.php">
                  <?php
                  if (isset($_SESSION['msg'])) {
                    echo "<p class='alert alert-danger'>" . $_SESSION['msg'] . "</p>";
                    // Supprimer le message d'erreur après l'affichage
                    unset($_SESSION['msg']);
                  }
                  ?>
                  <div class="mb-4">
                    <label class="form-label mb-2" for="signin-email">Email</label>
                    <input class="form-control" type="email" id="signin-email" name="email" placeholder="Votre adresse email" required>
                  </div>
                  <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                      <label class="form-label mb-0" for="signin-password">Mot de Passe</label><a class="fs-sm" href="#">Mot de passe oublié?</a>
                    </div>
                    <div class="password-toggle">
                      <input class="form-control" type="password" name="password" id="signin-password" placeholder="Votre mot de passe" required>
                      <label class="password-toggle-btn" aria-label="Show/hide password">
                        <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                      </label>
                    </div>
                  </div>
                  <button class="btn btn-primary btn-lg rounded-pill w-100" type="submit">Se Connecter</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Sign Up Modal-->
    <div class="modal fade" id="signup-modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 950px;">
        <div class="modal-content">
          <div class="modal-body px-0 py-2 py-sm-0">
            <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal"></button>
            <div class="row mx-0 align-items-center">
              <div class="col-md-6 border-end-md p-4 p-sm-5">
                <h2 class="h3 mb-4 mb-sm-5">Join Finder.<br>Get premium benefits:</h2>
                <ul class="list-unstyled mb-4 mb-sm-5">
                  <li class="d-flex mb-2"><i class="fi-check-circle text-primary mt-1 me-2"></i><span>Add and promote your listings</span></li>
                  <li class="d-flex mb-2"><i class="fi-check-circle text-primary mt-1 me-2"></i><span>Easily manage your wishlist</span></li>
                  <li class="d-flex mb-0"><i class="fi-check-circle text-primary mt-1 me-2"></i><span>Leave reviews</span></li>
                </ul><img class="d-block mx-auto" src="img/signin-modal/signup.svg" width="344" alt="Illustartion">
                <div class="mt-sm-4 pt-md-3">Already have an account? <a href="#se-connecter" data-bs-toggle="modal" data-bs-dismiss="modal">Sign in</a></div>
              </div>
              <div class="col-md-6 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5"><a class="btn btn-outline-info rounded-pill w-100 mb-3" href="#"><i class="fi-google fs-lg me-1"></i>Sign in with Google</a><a class="btn btn-outline-info rounded-pill w-100 mb-3" href="#"><i class="fi-facebook fs-lg me-1"></i>Sign in with Facebook</a>
                <div class="d-flex align-items-center py-3 mb-3">
                  <hr class="w-100">
                  <div class="px-3">Or</div>
                  <hr class="w-100">
                </div>
                <form class="needs-validation" novalidate>
                  <div class="mb-4">
                    <label class="form-label" for="signup-name">Full name</label>
                    <input class="form-control" type="text" id="signup-name" placeholder="Enter your full name" required>
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="signup-email">Email address</label>
                    <input class="form-control" type="email" id="signup-email" placeholder="Enter your email" required>
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="signup-password">Password <span class='fs-sm text-muted'>min. 8 char</span></label>
                    <div class="password-toggle">
                      <input class="form-control" type="password" id="signup-password" minlength="8" required>
                      <label class="password-toggle-btn" aria-label="Show/hide password">
                        <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                      </label>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="signup-password-confirm">Confirm password</label>
                    <div class="password-toggle">
                      <input class="form-control" type="password" id="signup-password-confirm" minlength="8" required>
                      <label class="password-toggle-btn" aria-label="Show/hide password">
                        <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                      </label>
                    </div>
                  </div>
                  <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="agree-to-terms" required>
                    <label class="form-check-label" for="agree-to-terms">By joining, I agree to the <a href='#'>Terms of use</a> and <a href='#'>Privacy policy</a></label>
                  </div>
                  <button class="btn btn-primary btn-lg rounded-pill w-100" type="submit">Sign up</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Navbar-->
    <header class="navbar navbar-expand-lg navbar-light bg-light fixed-top" data-scroll-header>
      <div class="container">
        <a class="navbar-brand me-3 me-xl-4" href="index.php"><img class="d-block" src="img/logo.png" width="90" alt="Finder"></a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <a class="btn btn-sm text-primary d-none d-lg-block order-lg-3" href="#se-connecter" data-bs-toggle="modal"><i class="fi-user me-2"></i>Connexion</a><a class="btn btn-primary btn-sm rounded-pill ms-2 order-lg-3" href="#signup-modal" data-bs-toggle="modal"><i class="fi-plus me-2"></i>Créer Compte</a>
        <div class="collapse navbar-collapse order-lg-2" id="navbarNav">
          <ul class="navbar-nav navbar-nav-scroll" style="max-height: 35rem;">
            <!-- Demos switcher-->
            <li class="nav-item dropdown active me-lg-2"><a class="nav-link align-items-center pe-lg-4" href="#" role="button" aria-expanded="false"><i class="fi-layers me-2"></i>Acceuil<span class="d-none d-lg-block position-absolute top-50 end-0 translate-middle-y border-end" style="width: 1px; height: 30px;"></span></a>

            </li>
            <!-- Menu items-->
            

          </ul>
        </div>
      </div>
    </header>
    <!-- Page content-->
    <!-- Hero-->
    <section class="jarallax bg-dark zindex-1 py-xxl-5" data-jarallax data-speed="0.5"><span class="img-overlay bg-transparent opacity-100" style="background-image: linear-gradient(0deg, rgba(31, 27, 45, .7), rgba(31, 27, 45, .7));"></span>
      <div class="jarallax-img" style="background-image: url(img/city-guide/home/hero-bg.jpg);"></div>
      <div class="content-overlay container py-md-5">
        <div class="mt-5 mb-md-5 py-5">
          <div class="col-xl-6 col-lg-8 col-md-10 mx-auto mb-sm-5 mb-4 px-0 text-center">
            <h1 class="display-5 text-light mt-sm-5 my-4">Explores le monde avec<span class="dropdown d-inline-block ms-2">
                <a class=" text-decoration-none" href="#" role="button" aria-haspopup="true" aria-expanded="false">JMK TRAVEL</a>

            </h1>
            <p class="fs-lg text-white">Chercher votre vol, et on s'occupe de tout.</p>
          </div>
          <div class="col-xl-8 col-lg-9 col-md-10 mx-auto px-0">
            <!-- Search form-->
            <form class="form-group d-block d-md-flex position-relative rounded-md-pill mb-2 mb-sm-4 mb-lg-5" action="index.php" method="post">
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
        </div>
      </div>
      <div class="position-absolute d-none d-xxl-block bottom-0 start-0 w-100 bg-white zindex-1" style="border-top-left-radius: 30px; border-top-right-radius: 30px; height: 30px;"></div>
    </section>
    <!-- Categories-->
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
             <td><a class="btn btn-primary btn-lg rounded-pill w-10" onclick="alert('Veuillez vous connecter avant de payer ce billet. Ou si vous n avez pas encore un compte client, veuillez en créer un,MERCI.');">Payer</a></td>
              
            </tr>
          <?php } ?>
        </table>
      </div>
    </section>


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
  <!-- Back to top button--><a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon fi-chevron-up"> </i></a>
  <!-- Vendor scrits: js libraries and plugins-->
  <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/simplebar/dist/simplebar.min.js"></script>
  <script src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
  <script src="vendor/tiny-slider/dist/min/tiny-slider.js"></script>
  <script src="vendor/flatpickr/dist/flatpickr.min.js"></script>
  <script src="vendor/jarallax/dist/jarallax.min.js"></script>
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