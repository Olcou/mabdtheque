<?php
function nav_link(string $lien, string $titre):string 
{
  $classe = 'nav-item nav-link';
  if ($_SERVER['SCRIPT_NAME'] === $lien) {
    $classe = $classe . ' active';
  }
  $html = '<a href=".'. $lien .'" class="'. $classe .'">'.$titre.'</a>';
  echo $html;
  return $html;
}
include ('config.php');
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="./assets/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="./assets/images/favicon/safari-pinned-tab.svg" color="#000000">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Ma BDthèque est une base de données qui vous aide à gérer votre collection de BD">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Main css -->
    <link href="./assets/css/main.css" rel="stylesheet">
    <title><?php if (isset($title)) { echo $title; } else { echo 'Ma BDthèque'; } ?></title>
</head>

<body>

    <!-- ======= Header Section ======= -->
    <div class="m-4">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a href="index.php" class="navbar-brand">
                    <img src="./assets/images/logo.png" alt="Logo MaBDthéque" width="167" height="50">
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <?php 
                        if (isset($_SESSION['userid'])){
                            $head = '/collection.php';
                            $head2 = 'Mon compte';
                        } else {
                            $head = '/connexion.php';
                            $head2 = 'Se connecter';
                        }
                        ?>
                    <div class="btn"><?php nav_link('/index.php', 'Accueil') ;?></div>
                    <div class="btn"><?php nav_link('/rechercher.php', 'Rechercher') ;?></div>
                    <div class="btn btn-outline-warning"><?php nav_link($head, $head2) ;?></div>
                    </div>
                </div>
            </div>
        </nav>
    </div>