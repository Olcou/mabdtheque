<?php

// Démarre la session
session_start();

// On se connecte à la base
try {
    $dsn = 'mysql:host=localhost;dbname=bande_dessinee';
    $dbh = new PDO($dsn, 'root', '');
} catch (Exception $e) {
    print "Houston, we have a problem<br/><a href='./index.php'>Retour à l'accueil</a>";
    die();
}

?>
