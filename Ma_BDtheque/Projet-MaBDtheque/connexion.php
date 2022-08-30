<script>
    if (typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", "connexion.php");
    }
</script>
<?php
include 'validation.php';
$title = 'Connexion - Ma BDthéque';
require 'header.php';
?>
<div class="overflow-hidden">
    <img src="./assets/images/bg-mabd.jpg" alt="ma bdthéque background" height="383">
</div>
<?php
// On vérifie sur l'utilisateur s'est déco
if (isset($_GET['deco']) == 1) {
    unset($_SESSION['username']);
    unset($_SESSION['userid']);
}
// On vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['username'])) {
    $form = false;
    $message = "<div class='py-3 text-muted'>Bienvenue !</div>
    <div><a class='btn btn-outline-dark my-3' href='./index.php'>Retour à l'accueil</a></div>
    <div><a class='btn btn-outline-danger mb-3' href='./connexion.php?deco=1'>Se déconnecter</a></div>";
}
// On vérifie si le formulaire a été envoyé
if (isset($_POST['pseudo'])) {
    // On assigne les variables de $_POST en les échappant
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $password = htmlspecialchars($_POST['password']);
    // On requete la base
    try {
        $req_connexion = "SELECT pseudo, password, id_membre FROM membre WHERE pseudo = :pseudo;";
        $req_connexion_prep = $dbh->prepare($req_connexion);
        $req_connexion_prep->execute(['pseudo' => $pseudo]);
        // On vérifie si le pseudo existe dans la base
        if ($req_connexion_prep->rowCount() > 0) {
            foreach ($req_connexion_prep as $row_connexion) {
                // On vérifie si le pseudo et le password correspondent 
                if ($row_connexion['password'] == $password) {
                    $form = false;
                    $_SESSION['username'] = $pseudo;
                    $_SESSION['userid'] = $row_connexion['id_membre'];
                } else {
                    // Si le pseudo et le mdp ne correspondent pas
                    $erreur = "Le mot de passe est incorrect";
                }
            }
        } else {
            // Si l'utilisateur n'est pas dans la base
            $erreur = "Utilisateur inconnu";
        }
    } catch (Exception $e) {
        print "Houston, we have a problem<br/><a href='./index.php'>Retour à l'accueil</a>";
        die();
    }
}
if (isset($form) && !$form) {
    if (isset($message)) { ?>
        <div class="container bg-grey my-5 middle"><?= $message ?></div>
    <?php } else { ?>
        <div class="container bg-grey my-5 middle">
            <div>
                Vous êtes maintenant connecté.
            </div>
            <div>
                <a class="btn btn-outline-dark my-3" href="./index.php">Retour à l'accueil</a>
            </div>
            <div>
                <a class="btn btn-outline-danger mb-3" href='./connexion.php?deco=1'>Se déconnecter</a>
            </div>
        </div>
    <?php }
} else { ?>
    <div class="container bg-grey my-5">
        <h1>Connexion</h1>
        <div class="row">
            <form action="" method="post">
                <div class="">
                    <label for="pseudo">Pseudo : </label>
                    <input class="form-control" type="text" name="pseudo" id="pseudo" autocomplete="pseudo" required>
                </div>
                <div class="my-3">
                    <label for="password">Mot de passe : </label>
                    <input class="form-control" type="password" name="password" id="password" autocomplete="password" required>
                </div>
                <div class="text-center my-2">
                    <input class="btn btn-outline-secondary" type="submit" value="Se connecter">
                </div>
            </form>
            <div class="text-center my-2">

                <a class="btn btn-outline-secondary" href="./inscription.php">Pas encore inscrit ?</a>
            </div>
            <?php
            if (isset($erreur)) {
            ?>
                <div><?= $erreur ?></div>
            <?php } ?>
        </div>
    </div> <?php } ?>
<?php require 'footer.php'; ?>