<?php
$title = 'Fiche Album - Ma BDthéque';
require 'header.php';
?>
<div class="overflow-hidden">
    <img src="./assets/images/bg-mabd.jpg" alt="ma bdthèque background" height="383">
</div>
<?php
// Récupération des données de la fiche 
try {
    if (!isset($_GET['id'])) {
        $erreur = "Fiche album introuvable ...";
    } else {
        $id = $_GET['id'];
        // On se connecte à MySQL
        $req = "select serie.nom as 'nom_serie', titre, tome as 'numero_de_tome', editeur.nom as 'nom_editeur', collection.nom as 'nom_collection', genre.nom as 'nom_genre', isbn, resume, annee, GROUP_CONCAT(concat(auteur.nom,'  ', auteur.prenom)) as 'auteur', concat(visuel.path, visuel.nom, '.', visuel.type) as 'image' FROM ouvrage JOIN genre ON genre.id_genre = ouvrage.id_genre LEFT OUTER JOIN serie on serie.id_serie = ouvrage.id_serie JOIN editeur on editeur.id_editeur = ouvrage.id_editeur LEFT OUTER JOIN collection on collection.id_collection = ouvrage.id_collection LEFT OUTER JOIN visuel on visuel.id_ouvrage = ouvrage.id_ouvrage JOIN est_ecrit on est_ecrit.id_ouvrage = ouvrage.id_ouvrage JOIN auteur ON auteur.id_auteur = est_ecrit.id_auteur where ouvrage.id_ouvrage = :id;";
        $req_prep = $dbh->prepare($req);
        $req_prep->execute(['id' => $id]);
        foreach ($req_prep as $row) {
            $serie = $row['nom_serie'];
            $titre = $row['titre'];
            $tome = $row['numero_de_tome'];
            $auteur = $row['auteur'];
            $editeur = $row['nom_editeur'];
            $collection = $row['nom_collection'];
            $isbn = $row['isbn'];
            $annee = $row['annee'];
            $genre = $row['nom_genre'];
            $resume = $row['resume'];
            $imge = $row['image'];
        }
        // Si l'utilisateur est connecté on récupère sa collection
        if (isset($_SESSION['userid'])) {
            $req = "select COUNT(ouvrage.id_ouvrage) as 'check' from ouvrage JOIN est_possede on est_possede.id_ouvrage = ouvrage.id_ouvrage where est_possede.id_membre =" . $_SESSION['userid'] . " AND ouvrage.id_ouvrage =" . $id . ";";
            $req_prep = $dbh->prepare($req);
            $req_prep->execute();
            foreach ($req_prep as $row) {
                if ($row['check'] == 1) {
                    $possede = true;
                } else {
                    $possede = false;
                }
            }
        }
        // $dbh = null;
    }
} catch (Exception $e) {
    $e->getMessage();
}

// Si l'utilisateur a cliqué sur un bouton pour ajouter à sa collection
if (isset($_GET['id']) && isset($titre)) {
    // Si bouton ajouter
    if (isset($_POST['ajouter'])) {
        try {
            $req = "INSERT INTO est_possede (id_membre, id_ouvrage, prete, lu) VALUES (" . $_SESSION['userid'] . "," . $_GET['id'] . ", 0, 0);";
            $req_prep = $dbh->prepare($req);
            $req_prep->execute();
            if ($req_prep->rowCount()) {
                $message = "L'album a bien été ajouté à votre collection";
                $possede = true;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
        // Si bouton retirer
    } elseif (isset($_POST['retirer'])) {
        try {
            $req = "DELETE FROM est_possede where id_ouvrage = " . $_GET['id'] . ";";
            $req_prep = $dbh->prepare($req);
            $req_prep->execute();
            if ($req_prep->rowCount()) {
                $message = "L'album a bien été retiré de votre collection";
                $possede = false;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}
// Si il y a un message à afficher, on l'affiche
if (isset($message)) { ?>
    <div class="container middle m-4">
        <?= $message ?>
    </div> <?php }
            ?>
<!-- On affiche la fiche album -->
<div class="container bg-grey my-5 py-2 px-5">
    <h1 class="my-3" id="fiche-id">Fiche Album</h1>
    <div class="row my-3">
        <?php
        // Si l'id n'est pas renseigné
        if (!(isset($_GET['id']))) {
            echo "<p>" . $erreur . "</p>";
        }
        ?>
        <!-- Si le titre a été récupéré (et donc fiche existante) -->
        <?php if (isset($titre)) { ?>
            <div class="col-sm-12 col-md-3 my-3">
                <!-- Si y'a une image on l'affiche -->
                <?php if (isset($imge)) { ?>
                    <img src=".<?= $imge ?>" alt="Couverture de l'album" class="img-fluid"> <?php }
                                                                                        // Sinon on affiche une image par défaut
                                                                                        else { ?>
                    <img src="./assets/images/default.jpeg" alt="Couverture de l'album" class="img-fluid"> <?php } ?>
            </div>
            <!-- Toute la liste avec les infos récupérées -->
            <div class="col-sm-12 col-md-6 d-flex">
                <ul class="liste_fiche">
                    <li>Titre : <span class="infos"><?= $titre ?></span></li>
                    <?php if (isset($tome)) { ?>
                        <li>Numéro de tome : <span class="infos"><?= $tome ?></span></li> <?php } ?>
                    <?php if (isset($serie)) { ?>
                        <li>Série : <span class="infos"><?= $serie ?></span></li> <?php } ?>
                    <?php if (isset($collection)) { ?>
                        <li>Collection : <span class="infos"><?= $collection ?></span></li> <?php } ?>
                    <li>Éditeur : <span class="infos"><?= $editeur ?></span></li>
                    <li>Auteur(s) : <span class="infos"><?= $auteur ?></span></li>
                    <li>ISBN : <span class="infos"><?= $isbn ?></span></li>
                    <li>Année de parution : <span class="infos"><?= $annee ?></span></li>
                    <li>Genre : <span class="infos"><?= $genre ?></span></li>
                    <?php if (isset($resume)) { ?>
                        <li>Résumé : <span class="infos"><?= $resume ?></span></li> <?php } ?>
                </ul>
            </div>
            <!-- Le bloc à droite qui gère la collection  -->
            <div class="col-sm-12 col-md-3">
                <?php
                // Si l'utilisateur est pas connecter, on lui propose de s'inscrire
                if (!(isset($_SESSION['userid']))) { ?>
                    <a class="btn btn-outline-secondary" href="./inscription.php">Inscrivez-vous pour commencer votre collection</a>
                    <form action="" method="post"></form>
                    <!-- Si il est connecté on vérifie si il est possédé ou non -->
                    <?php
                } elseif (isset($_SESSION['userid'])) {
                    if ($possede) { ?>
                        <form action="" method="post">
                            <input class="btn btn-outline-secondary" type="submit" name="retirer" id="retirer" value="Retirer de la collection" onclick="">
                        </form>
                    <?php } else { ?>
                        <form action="" method="post">
                            <input class="btn btn-outline-secondary" type="submit" name="ajouter" id="ajouter" value="Ajouter à la collection">
                        </form>


                    <?php } ?>
                    <a class="btn btn-outline-secondary my-3" href="./modification.php?id=<?= ($_GET['id']) ?>" role="button">Modifier la fiche</a>
                <?php } ?>
                <!-- Si le titre n'a pas été trouvé  -->
            </div> <?php } else { ?>
            <p>Fiche inexistante</p>
            <!-- <p><a class="link-dark" href='/index.php' >Retour à l'accueil</a></p> -->
            <p><a class="btn btn-outline-dark" href="./rechercher.php" role="button">Effectuer une recherche</a></p>

        <?php } ?>
    </div>
    <!-- Affichage des liens suivant et précédent si l'ID est renseigné -->
    <div class="row my-3">
        <div style="text-align:right" class="col-4">
            <?php if (isset($_GET['id'])) {
                if ($_GET['id'] >= 2) {
            ?>
                    <a class="btn btn-outline-secondary" href="./fiche_album.php?id=<?= ($_GET['id'] - 1) ?>#fiche-id">Album précédent</a> <?php
                                                                                                                                        } else {
                                                                                                                                            ?>
                    <a class="btn btn-outline-secondary disabled" href="./fiche_album.php?id=<?= ($_GET['id']) ?>">Album précédent</a> <?php
                                                                                                                                        }
                                                                                                                                    } ?>

        </div>
        <div class="col-4 middle">
            <!-- <a href="./recherche.php">Retour aux résultats</a><br/> -->
            <a class="btn btn-outline-dark" href="./index.php" role="button">Retour à l'accueil</a>
        </div>
        <div style="text-align:left" class="col-4">
            <?php if (isset($_GET['id'])) { ?>
                <a class="btn btn-outline-secondary" href="./fiche_album.php?id=<?= ($_GET['id'] + 1) ?>#fiche-id">Album suivant</a>
            <?php } ?>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>