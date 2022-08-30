<?php
$title = 'Modifier un album - Ma BDthéque';
include 'validation.php';
require 'header.php';
?>
<div class="overflow-hidden">
    <img src="./assets/images/bg-mabd.jpg" alt="ma bdthèque background" height="383">
</div>
<?php
// On test si une série a été ajoutée
if (isset($_POST['serie_nom']) && $_POST['serie_nom'] != "") {
    try {
        $req = 'SELECT count(nom) as "count" from serie WHERE nom ="' . $_POST['serie_nom'] . '";';
        foreach ($dbh->query($req) as $row) {
            if ($row['count'] == 0) {
                $req = 'INSERT INTO serie (nom) VALUES ("' . $_POST['serie_nom'] . '");';
                $dbh->query($req);
            } else {
                $erreur = "Nom de série déjà existant";
            }
        }
    } catch (Exception $e) {
        print "Houston, we have a problem<br/><a href='./index.php'>Retour à l'accueil</a>";
        die();
    }
}
// On test si un editeur a été ajouté
if (isset($_POST['editeur_nom']) && $_POST['editeur_nom'] != "") {
    try {
        $req = 'SELECT count(nom) as "count" from editeur WHERE nom ="' . $_POST['editeur_nom'] . '";';
        foreach ($dbh->query($req) as $row) {
            if ($row['count'] == 0) {
                $req = 'INSERT INTO editeur (nom) VALUES ("' . $_POST['editeur_nom'] . '");';
                $dbh->query($req);
            } else {
                $erreur = "Nom d'éditeur déjà existant";
            }
        }
    } catch (Exception $e) {
        print "Houston, we have a problem<br/><a href='./index.php'>Retour à l'accueil</a>";
        die();
    }
}
// On test si une collection a été ajoutée
if (isset($_POST['collection_nom']) && $_POST['collection_nom'] != "") {
    try {
        $req = "SELECT count(nom) as 'count' from collection WHERE nom ='" . $_POST['collection_nom'] . "';";
        foreach ($dbh->query($req) as $row) {
            if ($row['count'] == 0) {
                $collection_editeur = $_POST['collection_editeur'];
                $req = 'INSERT INTO collection (nom, id_editeur) VALUES ("' . $_POST['collection_nom'] . '", (select id_editeur from editeur where nom ="' . $collection_editeur . '"));';
                $dbh->query($req);
            } else {
                $erreur = "Nom de collection déjà existant";
            }
        }
    } catch (Exception $e) {
        print "Erreur : " . $e->getMessage() . "<br/>";
        print "Houston, we have a problem<br/><a href='./index.php'>Retour à l'accueil</a>";
        die();
    }
}
// On test si un auteur a été ajouté
if (isset($_POST['auteur_nom']) && $_POST['auteur_nom'] != "") {
    try {
        $i = 0;
        $auteur_nom = [];
        $auteur_prenom = [];
        $req = 'SELECT nom, prenom from auteur';
        foreach ($dbh->query($req) as $row) {
            $auteur_nom[$i] = $row['nom'];
            $auteur_prenom[$i] = $row['prenom'];
            $i++;
        }
        if (!(in_array($_POST['auteur_nom'], $auteur_nom))) {
            if (isset($_POST['auteur_prenom'])) {
                $req = 'INSERT INTO auteur (nom, prenom) VALUES ("' . $_POST['auteur_nom'] . '","' . $_POST['auteur_prenom'] . '");';
            } else {
                $req = 'INSERT INTO auteur (nom) VALUES ("' . $_POST['auteur_nom'] . '");';
            }
            $dbh->query($req);
        } elseif ((in_array($_POST['auteur_nom'], $auteur_nom)) &&
            !(in_array($_POST['auteur_prenom'], $auteur_prenom))
        ) {
            $req = 'INSERT INTO auteur (nom, prenom) VALUES ("' . $_POST['auteur_nom'] . '","' . $_POST['auteur_prenom'] . '");';
            $dbh->query($req);
        } else {
            $erreur = "Nom d'auteur déjà existant";
        }
    } catch (Exception $e) {
        print "Houston, we have a problem<br/><a href='./index.php'>Retour à l'accueil</a>";
        die();
    }
}
// On ajoute les données de la base dans des variables
try {
    if (!isset($_GET['id'])) {
        $erreur = "Fiche album introuvable ...";
    } else {
        $id = $_GET['id'];
        // On se connecte à MySQL
        $req = "select serie.nom as 'nom_serie', titre, tome as 'numero_de_tome', editeur.nom as 'nom_editeur', collection.nom as 'nom_collection', genre.nom as 'nom_genre', isbn, resume, annee, GROUP_CONCAT(concat(auteur.nom,' ', auteur.prenom)) as 'auteur', concat(visuel.path, visuel.nom, '.', visuel.type) as 'image' FROM ouvrage JOIN genre ON genre.id_genre = ouvrage.id_genre LEFT OUTER JOIN serie on serie.id_serie = ouvrage.id_serie JOIN editeur on editeur.id_editeur = ouvrage.id_editeur LEFT OUTER JOIN collection on collection.id_collection = ouvrage.id_collection LEFT OUTER JOIN visuel on visuel.id_ouvrage = ouvrage.id_ouvrage JOIN est_ecrit on est_ecrit.id_ouvrage = ouvrage.id_ouvrage JOIN auteur ON auteur.id_auteur = est_ecrit.id_auteur where ouvrage.id_ouvrage = :id;";
        $req_prep = $dbh->prepare($req);
        $req_prep->execute(['id' => $id]);
        foreach ($req_prep as $row) {
            $fiche_serie = $row['nom_serie'];
            $fiche_titre = $row['titre'];
            $fiche_tome = $row['numero_de_tome'];
            $fiche_auteur = $row['auteur'];
            $fiche_editeur = $row['nom_editeur'];
            $fiche_collection = $row['nom_collection'];
            $fiche_isbn = $row['isbn'];
            $fiche_annee = $row['annee'];
            $fiche_genre = $row['nom_genre'];
            $fiche_resume = $row['resume'];
            $fiche_imge = $row['image'];
        }
    }
    // On récupère les auteurs avec un concat dans la requete SQL donc on explode dans un tableau pour les afficher
    $fiche_auteur = explode(',', $fiche_auteur);
    $isbn = [];
    $i = 0;
    foreach ($dbh->query('SELECT isbn from ouvrage') as $row) {
        $isbn[$i] = $row['isbn'];
        $i++;
    }
    $serie = [];
    $i = 0;
    foreach ($dbh->query('SELECT nom from serie ORDER BY nom ASC') as $row) {
        $serie[$i] = $row['nom'];
        $i++;
    }
    $auteur = [];
    $i = 0;
    foreach ($dbh->query("SELECT concat(nom, ' ', prenom) as nom from auteur ORDER BY nom ASC") as $row) {
        $auteur[$i] = $row['nom'];
        $i++;
    }
    $editeur = [];
    $i = 0;
    foreach ($dbh->query('SELECT nom from editeur ORDER BY nom ASC') as $row) {
        $editeur[$i] = $row['nom'];
        $i++;
    }
    $collection = [];
    $i = 0;
    foreach ($dbh->query('SELECT nom from collection ORDER BY nom ASC') as $row) {
        $collection[$i] = $row['nom'];
        $i++;
    }
    $genre = [];
    $i = 0;
    foreach ($dbh->query('SELECT nom from genre ORDER BY nom ASC') as $row) {
        $genre[$i] = $row['nom'];
        $i++;
    }
} catch (Exception $e) {
    print "Houston, we have a problem<br/><a href='./index.php'>Retour à l'accueil</a>";
    die();
}



// Variable pour gérer la date max dans l'input annee
$now = date('Y');
// Variable pour gérer les selected dans les listes
$selected = "selected";


// On vérifie si le formulaire a été rempli
if (isset($_POST['titre'])) {
    // On échappe les variables et on les assignes
    $user_titre = htmlspecialchars($_POST['titre']);
    $user_tome = $_POST['tome'] ?? '';
    $user_serie = $serie[$_POST['serie']] ?? "";
    $user_auteur0 = $auteur[$_POST['auteur0']];
    if (isset($_POST['auteur1']) && $_POST['auteur1'] != "") {
        $user_auteur1 = $auteur[$_POST['auteur1']] ?? "";
    }
    $user_editeur = $editeur[$_POST['editeur']];
    $user_collection = $collection[$_POST['collection']] ?? "";
    $user_isbn = $_POST['isbn'];
    $user_annee = $_POST['annee'];
    $user_genre = $genre[$_POST['genre']];
    // Si le titre fait moins de 255 caractères
    if (strlen($user_titre) < 255) {
        // Si l'ISBN fait 13 caractères
        if (strlen($user_isbn) == 13) {
            // Si il n'y a que des chiffres
            if (validation_isbn($user_isbn)) {
                // Si l'isbn n'est pas dans la base
                if ($user_isbn == $fiche_isbn) {
                    // On vérifie si un fichier a été uploadé
                    if (($_FILES['cover']['error']) == 0) {
                        // Si il n'y a pas d'erreur 
                        if (is_uploaded_file($_FILES['cover']['tmp_name'])) {
                            // J'assigne les variable du nom et du path pour stocker l'image
                            $tmp_name = $_FILES['cover']['tmp_name'];
                            $up_name = str_replace(" ", "_", $_POST['titre']);
                            $up_name = str_replace("'", "_", $_POST['titre']);
                            $up_name .= "_" . $user_isbn;
                            $type = explode('/', $_FILES['cover']['type']);
                            // Si le type de l'image est bon 
                            if ($type[1] == "jpg" || $type[1] == "png" || $type[1] == "bmp" || $type[1] == "jpeg") {
                                $path = "/assets/images/visuel/";
                                $dest = $path . $up_name . '.' . $type[1];
                                // Je télécharge l'image en local
                                move_uploaded_file($tmp_name, $dest);
                                $check_file = true;
                                // $path = "./assets/images/visuel/";
                            } else {
                                $erreur = "Le type du fichier ne correspond pas";
                            }
                        }
                    } elseif (($_FILES['cover']['error']) == 1 || (($_FILES['cover']['error']) == 2)) {
                        $erreur = "Le fichier est trop lourd. Taille max : 3 Mo";
                    } elseif (isset($_FILES['cover']['error']) && $_FILES['cover']['error'] != 4) {
                        $erreur = "Une erreur s'est produite pendant le téléchargement de la couverture";
                    }
                    // Si tout est ok on modifie la fiche dans la base
                    try {
                        $dbh = null;
                        $dbh = new PDO($dsn, 'root', '');
                        $req_crea = 'UPDATE ouvrage SET
                            titre = "' . $user_titre . '", id_serie = (SELECT id_serie from serie where nom = "' . $user_serie . '"), id_editeur = (SELECT id_editeur from editeur where nom = "' . $user_editeur . '"), id_collection = (SELECT id_collection from collection where nom = "' . $user_collection . '"), isbn = ' . $user_isbn . ', annee = ' . $user_annee . ', id_genre = (SELECT id_genre from genre where nom = "' . $user_genre . '") where id_ouvrage = ' . $_GET['id'] . ';';
                        $req_crea_prep = $dbh->prepare($req_crea);
                        $req_crea_prep->execute();
                        $dbh = null;
                        // Création premier auteur
                        $dbh = new PDO($dsn, 'root', '');
                        foreach ($dbh->query("select id_auteur from auteur where concat (nom, ' ', prenom) ='" . $user_auteur0 . "';") as $row) {
                            $id_auteur0 = $row['id_auteur'];
                        }
                        $dbh = null;
                        $dbh = new PDO($dsn, 'root', '');
                        $req_crea_auteur = "UPDATE est_ecrit SET id_auteur = '" . $id_auteur0 . "' WHERE est_ecrit.id_ouvrage = " . $_GET['id'] . " AND est_ecrit.id_auteur = (select id_auteur from auteur where concat (nom, ' ', prenom) ='" . $fiche_auteur[0] . "');";
                        $dbh->query($req_crea_auteur);
                        $dbh = null;
                        // Création deuxieme auteur si il y en a un 
                        if (isset($_POST['auteur1']) && $_POST['auteur1'] != "") {
                            $dbh = new PDO($dsn, 'root', '');
                            foreach ($dbh->query("select id_auteur from auteur where concat (nom, ' ', prenom) ='" . $user_auteur1 . "';") as $row) {
                                $id_auteur1 = $row['id_auteur'];
                            }
                            $dbh = null;
                            $dbh = new PDO($dsn, 'root', '');
                            $req_crea_auteur = $req_crea_auteur = "UPDATE est_ecrit SET id_auteur = '" . $id_auteur1 . "' WHERE est_ecrit.id_ouvrage = " . $_GET['id'] . " AND est_ecrit.id_auteur = (select id_auteur from auteur where concat (nom, ' ', prenom) ='" . $fiche_auteur[1] . "');";
                            $dbh->query($req_crea_auteur);
                            $dbh = null;
                        }
                        if (isset($check_file)) {
                            $dbh = new PDO($dsn, 'root', '');
                            $req_file = 'UPDATE visuel SET nom = "' . $up_name . '", path = "' . $path . '",type = "' . $type[1] . '" where id_ouvrage = ' . $_GET['id'] . ';';
                            $dbh->query($req_file);
                            $dbh = null;
                        }
                    } catch (Exception $e) {
                        print "Houston, we have a problem<br/><a href='./index.php'>Retour à l'accueil</a>";
                        print "Erreur : " . $e->getMessage() . "<br/>";
                        die();
                    }
                } else {
                    $erreur = "L'ISBN ne correspond pas au format";
                }
            } else {
                $erreur = "L'ISBN ne correspond pas au format";
            }
        } else {
            $erreur = "Le titre est déjà présent dans la base";
        }
    } else {
        $erreur = "Le titre est trop long";
    }
}
if (isset($erreur)) {
    echo $erreur;
}
?>
<div class="container bg-grey my-5">
    <form action="" method="POST" enctype="multipart/form-data">
        <h1>Modification d'une fiche</h1>
        <div class="row">
            <!-- FICHIER POUR LA COUVERTURE -->
            <div class="col-sm-12 col-md-4">
                <div class="col-12">
                    <img class="img-fluid" src=".<?= $fiche_imge ?>" alt="Couverture">
                    <!-- <img src="" alt=""> -->
                    <!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                    <!-- Le nom de l'élément input détermine le nom dans le tableau $_FILES -->
                    <div>Sélectionner un fichier : <input class="form-control" name="cover" type="file" /></div>
                </div>
            </div>
            <!-- FORMULAIRE DROITE -->
            <div class="col-sm-12 col-md-8">
                <!-- TITRE -->
                <label for="titre">Titre :</label>
                <input type="text" class="form-control" name="titre" id="titre" value="<?= $fiche_titre ?? '' ?>" required>
                <br />
                <!-- TOME -->
                <label for="tome">Numéro de tome :</label>
                <input type="number" class="form-control" name="tome" id="tome" value="<?= $fiche_tome ?? '' ?>">
                <br />
                <!-- SERIE -->
                <div>
                    <label for="serie">Série :</label>
                    <select name="serie" class="form-select" id="serie" size=1>
                        <option value=""></option>
                        <?php
                        for ($i = 0; $i < count($serie); $i++) {
                            if (isset($fiche_serie) && $fiche_serie == $serie[$i]) {
                                echo "<option value ='" . $i . "' selected>" . $serie[$i] . "</option>";
                            } else {
                                echo "<option value ='" . $i . "'>" . $serie[$i] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <!-- BOUTON MODALE CREATION SERIE -->
                    <div class="py-2 text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#crea_serie">Créer une série</button>
                    </div>

                </div>

                <!-- AUTEUR -->
                <?php

                for ($i_auteur = 0; $i_auteur < count($fiche_auteur); $i_auteur++) {
                ?>
                    <label for="auteur<?= $i_auteur ?>">Auteur :</label>
                    <select name="auteur<?= $i_auteur ?>" class="form-select" id="auteur<?= $i_auteur ?>" size=1 required>
                        <option value=""></option>
                        <?php
                        for ($i = 0; $i < count($auteur); $i++) {
                            if ($fiche_auteur[$i_auteur] == $auteur[$i]) {
                                echo "<option value ='" . $i . "' selected>" . $auteur[$i] . "</option>";
                            } else {
                                echo "<option value ='" . $i . "'>" . $auteur[$i] . "</option>";
                            }
                        }
                        ?>
                    </select> <?php if (!($i_auteur == (count($fiche_auteur) - 1))) { ?><br> <?php }
                                                                                        }
                                                                                                ?>
                </select>
                <!-- MODALE CREATION AUTEUR -->
                <div class="py-2 text-end">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#crea_auteur">Créer un auteur</button>
                </div>
                <!-- EDITEUR -->
                <label for="editeur">Editeur :</label>
                <select name="editeur" class="form-select" id="editeur" size=1 required>
                    <option value=""></option>
                    <?php
                    for ($i = 0; $i < count($editeur); $i++) {
                        if (isset($fiche_editeur) && $fiche_editeur == $editeur[$i]) {
                            echo "<option value ='" . $i . "' selected>" . $editeur[$i] . "</option>";
                        } else {
                            echo "<option value ='" . $i . "'>" . $editeur[$i] . "</option>";
                        }
                    }
                    ?>
                </select>
                <!-- MODALE CREATION EDITEUR -->
                <div class="py-2 text-end">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#crea_editeur">Créer un éditeur</button>
                </div>
                <!-- COLLECTION -->
                <label for="collection">Collection :</label>
                <select name="collection" class="form-select" id="collection" size=1>
                    <option value=""></option>
                    <?php
                    for ($i = 0; $i < count($collection); $i++) {
                        if (isset($fiche_collection) && $fiche_collection == $collection[$i]) {
                            echo "<option value ='" . $i . "' selected>" . $collection[$i] . "</option>";
                        } else {
                            echo "<option value ='" . $i . "'>" . $collection[$i] . "</option>";
                        }
                    }
                    ?>
                </select>
                <!-- MODALE CREATION collection -->
                <div class="py-2 text-end">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#crea_collection">Créer une collection</button>
                </div>
                <!-- ISBN -->
                <label for="isbn">ISBN :</label>
                <input type="text" class="form-control" name="isbn" id="isbn" value="<?= $fiche_isbn ?? '' ?>" required>
                <br />
                <!-- ANNEE -->
                <label for="annee">Année de parution :</label>
                <input type="number" class="form-control" name="annee" id="annee" min="1900" max="<?= $now ?>" step="1" value="<?= $fiche_annee ?? $now ?>" required />
                <br />
                <!-- GENRE -->
                <label for="genre">Genre :</label>
                <select name="genre" class="form-select" id="genre" size=1 required>
                    <option value=""></option>
                    <?php
                    for ($i = 0; $i < count($genre); $i++) {
                        if (isset($fiche_genre) && $fiche_genre == $genre[$i]) {
                            echo "<option value ='" . $i . "' selected>" . $genre[$i] . "</option>";
                        } else {
                            echo "<option value ='" . $i . "'>" . $genre[$i] . "</option>";
                        }
                    }
                    ?>
                </select>
                <div class="py-4 text-center">
                    <input class="btn btn-outline-dark" type="submit" value="Modifier la fiche">
                </div>
                <div class="py-4 text-center">
                    <a href="./fiche_album.php?id=<?= ($_GET['id']) ?>" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
<!-- MODALE SERIE -->
<div class="modal fade" id="crea_serie" tabindex="-1" aria-labelledby="ModalCreationSerie" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titre_modale">Créer une série</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="serie_nom">Nom de la série : </label>
                    <input type="text" name="serie_nom" id="serie_nom">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <input type="submit" class="btn btn-outline-secondary" value="Créer la série" />
                </div>
            </div>
        </form>
    </div>
</div>
<!-- MODALE AUTEUR-->
<div class="modal fade" id="crea_auteur" tabindex="-1" aria-labelledby="ModalCreationAuteur" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titre_modale">Créer un auteur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post"></form>
            <div class="modal-body">
                <form action="" method="post">
                    <label for="auteur_nom">Nom de l'auteur : </label>
                    <input type="text" name="auteur_nom" id="auteur_nom">
                    <br />
                    <label for="auteur_prenom">Prénom de l'auteur : </label>
                    <input type="text" name="auteur_prenom" id="auteur_prenom">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <input type="submit" class="btn btn-outline-secondary" value="Créer l'auteur" />
                </form>
            </div>
        </div>
    </div>
</div>
<!-- MODALE COLLECTION -->
<div class="modal fade" id="crea_collection" tabindex="-1" aria-labelledby="ModalCreationcollection" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titre_modale">Créer une collection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post"></form>
            <div class="modal-body">
                <form action="" method="post">
                    <label for="collection_nom">Nom de la collection : </label>
                    <input type="text" name="collection_nom" id="collection_nom">
                    <label for="collection_editeur">Éditeur de la collection : </label>
                    <select name="collection_editeur" id="collection_editeur" size=1 required>
                        <option value=""></option>
                        <?php
                        for ($i = 0; $i < count($editeur); $i++) {
                            echo "<option value ='" . $editeur[$i] . "'>" . $editeur[$i] . "</option>";
                        }
                        ?>
                    </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <input type="submit" class="btn btn-outline-secondary" value="Créer la collection" />
                </form>
            </div>
        </div>
    </div>
</div>
<!-- MODALE EDITEUR -->
<div class="modal fade" id="crea_editeur" tabindex="-1" aria-labelledby="ModalCreationEditeur" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titre_modale">Créer un éditeur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post"></form>
            <div class="modal-body">
                <form action="" method="post">
                    <label for="editeur_nom">Nom de l'éditeur : </label>
                    <input type="text" name="editeur_nom" id="editeur_nom">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <input type="submit" class="btn btn-outline-secondary" value="Créer l'éditeur" />
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>