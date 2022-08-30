<?php
$title = 'Ma collection - Ma BDthèque';
require 'header.php';
include 'afficher_derniers_ajouts.php'
?>
<?php 
  if (isset($_SESSION['userid'])) {
    $retour = afficher_collection($_SESSION['userid']);
    $tabId = $retour[0];
    $tabTitre = $retour[1];
    $tabEditeur = $retour[2];
    $tabIsbn = $retour[3];
    $tabImage = $retour[4];
  }
?>
<div class="overflow-hidden">
  <img src="./assets/images/bg-mabd.jpg" alt="ma bdthéque background" height="383">
</div>

<div class="py-1 my-4 text-center">
            <a class="btn btn-outline-danger" href="./connexion.php?deco=1" role="button">Se déconnecter</a>
        </div>
<div class="container bg-grey my-5 h-70">
  <h2 class="pt-4">Ma collection :</h2>
  <div class="container py-5">
    <div class="row">
    <?php for ($i = 0; $i < count($tabId); $i++) { ?>
        <div class="col-sm-3 text-center">
          <?php 
          if ($tabImage[$i] != "") { ?>
          <a href="./fiche_album.php?id=<?=$tabId[$i]?>">
          <img class="img-fluid" src=".<?=$tabImage[$i]?>" alt="Couverture BD" height="400" width="200"></a>
          <?php } else { ?>
            <a href="./fiche_album.php?id=<?=$tabId[$i]?>">
          <img class="img-fluid" src="./assets/images/default.jpeg" alt="Couverture BD" height="400" width="200"></a>
          <?php } ?>
          <h3><a class ="link-dark" href="./fiche_album.php?id=<?=$tabId[$i]?>"><?=$tabTitre[$i]?></a></h3>
          <p><?=$tabEditeur[$i]?></p>
          <p style="font-size:  0.8em;">ISBN : <br/><?=$tabIsbn[$i]?></p>
        </div> <?php } ?>
    </div>
  </div>
</div>

<?php require 'footer.php'; ?>