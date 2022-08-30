<?php
// include('config.php');
include('validation.php');
include('fonction_inscription.php');
$title = 'Inscription - Ma BDthéque';
require 'header.php';
?>
<div class="overflow-hidden">
    <img src="assets/images/bg-mabd.jpg" alt="ma bdthéque background" height="383">
</div>

<?php
// On vérifie si le formulaire a été envoyé
if (isset($_POST['pseudo'])) {
    $retour = validation_inscription($_POST['pseudo'], $_POST['mail'], $_POST['password1'], $_POST['password2'], $_POST['cgu']);
}
// Si le formulaire a été bien rempli on affiche un message de réussite
if (isset($retour['form']) && $retour['form']) {
?>
    <div class="container bg-grey my-5 py-3 succes">
        <div class="text-center">Vous êtes maintenant inscrit.</div>
        <div class="text-center my-3"><a class="btn btn-outline-dark"  href="./connexion.php">Vous pouvez maintenant vous connecter</a></div>
    </div>
<?php
} else { ?>
    <!-- Sinon on affiche le formulaire -->
    <form action="" method="post">
        <div class="container bg-grey my-5 formulaire">
            <h1>Inscription</h1>
            <div class="row d-flex flex-direction-columns justify-content-center">
                <div class="col-sm-12 col-md-6">
                    <div class="">
                        <label for="pseudo">Pseudo </label>
                        <br />
                        <input class="form-control" type="text" name="pseudo" id="pseudo" autocomplete="name" required>
                    </div>
                    <div class="my-3">
                        <label for="mail">Email</label>
                        <br />
                        <input class="form-control" type="mail" name="mail" id="mail" autocomplete="mail" required>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="">
                        <label for="password1">Mot de passe</label>
                        <br />
                        <input class="form-control" type="password" name="password1" id="password1" autocomplete="password1" required>
                    </div>
                    <div class="my-3">
                        <label for="password2">Confirmer le mot de passe</label>
                        <br />
                        <input class="form-control" type="password" name="password2" id="password2" autocomplete="password2" required>
                    </div>
                </div>
            </div>
            <div class="text-center pt-3">
                <label class="text-muted" for="cgu">J'accepte les conditions générales d'utilisation : </label>
                <input class="form-check-label" type="checkbox" name="cgu" id="cgu" required>
            </div>
            <div class="text-center my-3">
                <input class="btn btn-outline-secondary" type="submit" value="S'inscrire">
            </div>
            <div class="text-center text-muted pb-3">Vous êtes déjà inscrit ?
                <div>
                    <a class="btn btn-outline-secondary text-decoration-none" href="connexion.php">Connectez-vous</a>
                </div>

            </div>
        </div>
    </form>
    <!-- On affiche une erreur si il y en a une  -->
    <?php if (isset($retour['erreur'])) { ?>
        <div class="erreur">
            <?= $retour['erreur'] ?>
        </div>
    <?php } ?>
    </div> <?php } ?>
<?php require 'footer.php'; ?>