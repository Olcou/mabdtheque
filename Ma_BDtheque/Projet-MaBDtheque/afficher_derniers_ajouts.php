
<?php
function afficher_derniers_ajouts() {
// Récupération des données de la fiche 
try {
    // On se connecte à MySQL
    $dbh = new PDO(
        'mysql:host=localhost;dbname=bande_dessinee;charset=utf8',
        'root',
        '',
        array(PDO::ATTR_PERSISTENT => true)
    );

    // CONSTRUIRE UNE REQUETE 

    $req = "select visuel.id_ouvrage as 'id', ouvrage.titre, concat(visuel.path, visuel.nom, '.', visuel.type) as 'image', editeur.nom FROM visuel JOIN ouvrage ON ouvrage.id_ouvrage = visuel.id_ouvrage JOIN editeur ON ouvrage.id_editeur = editeur.id_editeur ORDER BY id_visuel DESC LIMIT 0, 4;";
    $req_prep = $dbh->prepare($req);
    $req_prep->execute();
    // j'initialise un tableau vide
    $tabImage = [];
    $tabId = [];
    $tabTitre = [];
    $tabEditeur = [];
    foreach ($req_prep as $key => $row) {
        $imge = $row['image'];
        $tabImage[$key] = $imge;
        $tabId[$key] = $row['id'];
        $tabTitre[$key] = $row['titre'];
        $tabEditeur[$key] = $row['nom'];
    }
    $dbh = null;
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
$retour[0] = $tabImage;
$retour[1] = $tabId;
$retour[2] = $tabTitre;
$retour[3] = $tabEditeur;
return $retour;
}

function afficher_collection ($id) {
    try {
        $dbh = new PDO(
            'mysql:host=localhost;dbname=bande_dessinee;charset=utf8',
            'root',
            '',
            array(PDO::ATTR_PERSISTENT => true)
        );
        $req = "SELECT ouvrage.id_ouvrage as 'id', ouvrage.titre, editeur.nom, ouvrage.isbn, concat(visuel.path, visuel.nom, '.', visuel.type) as image FROM ouvrage JOIN editeur ON editeur.id_editeur = ouvrage.id_editeur JOIN est_possede ON est_possede.id_ouvrage = ouvrage.id_ouvrage LEFT OUTER JOIN visuel on visuel.id_ouvrage = ouvrage.id_ouvrage WHERE est_possede.id_membre =" . $id .";";
        $req_prep = $dbh->prepare($req);
        $req_prep->execute();
        $tabId = [];
        $tabTitre = [];
        $tabEditeur = [];
        $tabIsbn = [];
        $tabImage = [];
        foreach ($req_prep as $key => $row) {
            $imge = $row['image'];
            // $imge = str_replace('/', '\\', $imge);
            // $imge = substr($imge, 1);
            $tabImage[$key] = $imge;
            $tabId[$key] = $row['id'];
            $tabTitre[$key] = $row['titre'];
            $tabIsbn[$key] = $row['isbn'];
            $tabEditeur[$key] = $row['nom'];
        }
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
    $retour[0] = $tabId;
    $retour[1] = $tabTitre;
    $retour[2] = $tabEditeur;
    $retour[3] = $tabIsbn;
    $retour[4] = $tabImage;
    return $retour;
}
?>
