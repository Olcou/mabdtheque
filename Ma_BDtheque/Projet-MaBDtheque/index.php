<?php
$title = 'Accueil - Ma BDthèque';
require 'header.php';
include 'afficher_derniers_ajouts.php'
?>

<!-- ======= Dernier ajout Section ======= -->

<div class="overflow-hidden">
  <img src="./assets/images/bg-mabd.jpg" alt="ma bdthéque background" height="383">
</div>
<div class="container bg-grey my-5">
  <h2 class="pt-4">Derniers ajouts à la base :</h2>
  <div class="container py-5">
    <div class="row">
      <?php $retour = afficher_derniers_ajouts();
      $tabImage = $retour[0];
      $tabId = $retour[1];
      $tabTitre = $retour[2];
      $tabEditeur = $retour[3];
      for ($i = 0; $i < 4; $i++) { ?>
        <div class="col-sm text-center">
          <a href="./fiche_album.php?id=<?=$tabId[$i]?>">
          <img class="img-fluid" src=".<?=$tabImage[$i]?>" alt="couverture BD" height="400" width="200"></a>
          <h3><a class ="link-dark" href="./fiche_album.php?id=<?=$tabId[$i]?>"><?=$tabTitre[$i]?></a></h3>
          <p><?=$tabEditeur[$i]?></p>
        </div> <?php } ?>
    </div>
  </div>
</div>
<?php if (!(isset($_SESSION['userid']))) { ?>
<div class="container text-center">
  <a class="btn btn-outline-warning" href="./inscription.php">Inscrivez-vous pour ajouter des albums à votre collection</a>
</div> <?php } else { ?>
  <div class="container text-center">
  <a class="btn btn-outline-warning" href="./collection.php">Voir ma collection</a>
</div> <?php } ?>
<!-- ======= Section RECHERCHE ======= -->

<div class="container bg-grey my-5">
    <h2 class="pt-4">Rechercher:</h2>
    <div class="container py-5">
        <form method="post" action="rechercher.php#resultat" class="row">

            <div class="row mb-3 col-6">
                <label for="titre" class="col-sm-2 col-form-label">Titre :</label>
                <div class="col-sm-10">
                    <input type="text" name="titre" class="form-control" id="titre" value="<?= $_POST['titre'] ?? '' ?>">
                </div>
            </div>
            <div class="row mb-3 col-6">
                <label for="serie" class="col-sm-2 col-form-label">Série :</label>
                <div class="col-sm-10">
                    <input type="text" name="serie" class="form-control" id="serie" value="<?= $_POST['serie'] ?? '' ?>">
                </div>
            </div>
            <div class="row mb-3 col-6">
                <label for="isbn" class="col-sm-2 col-form-label">ISBN :</label>
                <div class="col-sm-10">
                    <input type="text" name="isbn" class="form-control" id="isbn" value="<?= $_POST['isbn'] ?? '' ?>">
                </div>
            </div>
            <div class="row mb-3 col-6">
                <label for="editeur" class="col-sm-2 col-form-label">Editeur :</label>
                <div class="col-sm-10">
                    <input type="text" name="editeur" class="form-control" id="editeur" value="<?= $_POST['editeur'] ?? '' ?>">
                </div>
            </div>
            <div class="row mb-3 col-6">
                <label for="annee" class="col-sm-2 col-form-label">Année :</label>
                <div class="col-sm-10">
                    <input type="number" min="1700" max="2099" step="1" name="annee" class="form-control" id="annee" value="<?= $_POST['annee'] ?? '' ?>">
                </div>
            </div>
            <div class="row mb-3 col-6">
                <label for="auteur" class="col-sm-2 col-form-label">Auteur :</label>
                <div class="col-sm-10">
                    <input type="text" name="auteur" class="form-control" id="auteur" value="<?= $_POST['auteur'] ?? '' ?>">
                </div>
            </div>
            <div class="row mb-3 col-6">
                <label for="genre" class="col-sm-2 col-form-label">Genre :</label>
                <div class="col-sm-10">
                    <input type="text" name="genre" class="form-control" id="genre" value="<?= $_POST['genre'] ?? '' ?>">
                </div>
            </div>
            <div class="row mb-3 col-6">
                <label for="collection" class="col-sm-2 col-form-label">Collection:</label>
                <div class="col-sm-10">
                    <input type="text" name="collection" class="form-control" id="collection" value="<?= $_POST['collection'] ?? '' ?>">
                </div>
            </div>
            <div class="py-1 text-center">
                <button class="btn btn-outline-secondary" name="submit" type="submit">Rechercher</button>
            </div>
        </form>
    </div>
</div>

<?php require 'footer.php'; ?>