<?php
$title = 'Recherche - Ma BDthéque';
require 'header.php';
?>

<div class="overflow-hidden">
    <img src="./assets/images/bg-mabd.jpg" alt="ma bdthéque background" height="383">
</div>

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


<div class="container bg-grey my-5" id="resultat">
    <h2 class="pt-4">Liste des ouvrages disponibles :</h2>
    <?php

    // Récupére les informations pour la pagination
    $page = $_GET['page'] ?? '1';
    $rownumber = $_GET['rownumber'] ?? '10';

    if (!is_numeric($page)) {
        $page = 1;
    }
    if (!is_numeric($rownumber)) {
        $rownumber = 10;
    }

    // Construction de la condition where et da liste des paramètres de la requête en fonction des champ saisies
    $where = '';
    $param = [];

    $titre = $_POST['titre'] ?? '';
    if (strlen($titre)) {
        if (strlen($where)) {
            $where .= ' and ';
        } else {
            $where .= ' where ';
        }
        $where .= 'titre LIKE :titre';
        $param['titre'] = '%' . $titre . '%';
    }

    $serie = $_POST['serie'] ?? '';
    if (strlen($serie)) {
        if (strlen($where)) {
            $where .= ' and ';
        } else {
            $where .= ' where ';
        }
        $where .= 'ouvrage.id_serie = (SELECT serie.id_serie FROM serie where nom LIKE :serie)';
        $param['serie'] = '%' . $serie . '%';
    }

    $isbn = $_POST['isbn'] ?? '';
    if (strlen($isbn)) {
        if (strlen($where)) {
            $where .= ' and ';
        } else {
            $where .= ' where ';
        }
        $where .= 'isbn = :isbn';
        $param['isbn'] = $isbn;
    }

    $editeur = $_POST['editeur'] ?? '';
    if (strlen($editeur)) {
        if (strlen($where)) {
            $where .= ' and ';
        } else {
            $where .= ' where ';
        }
        $where .= 'ouvrage.id_editeur = (SELECT editeur.id_editeur FROM editeur where nom LIKE :editeur)';
        $param['editeur'] = '%' . $editeur . '%';
    }

    $annee = $_POST['annee'] ?? '';
    if (strlen($annee)) {
        if (strlen($where)) {
            $where .= ' and ';
        } else {
            $where .= ' where ';
        }
        $where .= 'annee = :annee';
        $param['annee'] = $annee;
    }

    $auteur = $_POST['auteur'] ?? '';
    if (strlen($auteur)) {
        if (strlen($where)) {
            $where .= ' and ';
        } else {
            $where .= ' where ';
        }
        $where .= 'ouvrage.id_auteur = (SELECT auteur.id_auteur FROM auteur where nom LIKE :auteur)';
        $param['auteur'] = '%' . $auteur . '%';
    }

    $genre = $_POST['genre'] ?? '';
    if (strlen($genre)) {
        if (strlen($where)) {
            $where .= ' and ';
        } else {
            $where .= ' where ';
        }
        $where .= 'ouvrage.id_genre = (SELECT genre.id_genre FROM genre where nom LIKE :genre)';
        $param['genre'] = '%' . $genre . '%';
    }

    $collection = $_POST['collection'] ?? '';
    if (strlen($collection)) {
        if (strlen($where)) {
            $where .= ' and ';
        } else {
            $where .= ' where ';
        }
        $where .= 'ouvrage.id_collection = (SELECT collection.id_collection FROM collection where nom LIKE :collection)';
        $param['collection'] = '%' . $collection . '%';
    }

    // Définit la requête pour récupérer le nombre de ligne dans la requête
    $statement = $dbh->prepare('SELECT count(*) FROM ouvrage' . $where);

    // Exécute la requête avec les paramètres remplis
    if (!$statement->execute($param)) {
        // Si $statement->execute() == false, on affiche le code d'erreur
        echo '<h2 class="error">Erreur de récupération des données : ' . $statement->errorCode() . '</h2>';
    }
    // Récupère le count() de la requête
    $rowcount = $statement->fetch()[0];

    // Calcule la dernière page
    $lastPage = ceil($rowcount / $rownumber);

    // Se positionne sur la bonne page si en dehors des limites
    if ($page < 1) {
        $page = 1;
    } elseif ($page > $lastPage) {
        $page = $lastPage;
    }

    // Définit la requête pour ramener les ouvrages avec la pagination
    $statement = $dbh->prepare('SELECT ouvrage.id_ouvrage, titre, editeur.nom AS "nom", isbn, annee FROM ouvrage 
    JOIN editeur ON editeur.id_editeur = ouvrage.id_editeur' .
    $where . ' limit ' . (($page - 1) * $rownumber) . ',' . $rownumber);

    try {
    ?>
        <table class="table table-striped" id="table-oeuvre">
            <thead>
                <tr>
                    <th scope="col">Titre</th>
                    <th scope="col">Editeur</th>
                    <th scope="col">ISBN</th>
                    <th scope="col">Parution</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $statement->execute($param);
                foreach ($statement as $row) {

                ?>
                    <tr>
                        <td><a class="text-decoration-none text-muted" href="./fiche_album.php?id=<?= $row['id_ouvrage'] ?>"><?= $row['titre'] ?></a></td>
                        <td><?= $row['nom'] ?></td>
                        <td><?= $row['isbn'] ?></td>
                        <td><?= $row['annee'] ?></td>
                    </tr>
                <?php $dbh = null;
                }

                ?>
            </tbody>
        </table>

        <!-- nav pour la pagination -->
        <nav aria-label="Page navigation example" class="py-3">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link">Précédent</a>
                </li>
                <li class="page-item"><a class="page-link" href="./rechercher.php?page=1#resultat">1</a></li>
                <li class="page-item"><a class="page-link" href="./rechercher.php?page=2#resultat">2</a></li>
                <li class="page-item">
                    <a class="page-link" href="./rechercher.php?page=2#resultat">Suivant</a>
                </li>
            </ul>
        </nav>

    <?php
    } catch (PDOException $e) {
    ?>
        
        <div class="py-1 text-center">Cette ouvrage n'est pas présent dans la liste. Vous pouvez l'ajouter :
            <a class="btn btn-secondary" href="./creation.php" role="button">Ajouter</a>
        </div>
        </tbody>
        </table>
    <?php
    }
    ?>
</div>
<?php require 'footer.php'; ?>