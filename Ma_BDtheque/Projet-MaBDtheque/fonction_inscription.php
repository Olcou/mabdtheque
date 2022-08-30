<?php
function validation_inscription(string $pseudo, string $mail, string $pass1, string $pass2, bool $cgu)
{
    // On vérifie si les CGU sont acceptées
    $retour = [];
    if ($cgu) {
        $dsn = 'mysql:host=localhost;dbname=bande_dessinee';
        $dbh = new PDO($dsn, 'root', '');
        // On échappe et assigne les variables de $_POST
        $pseudo = htmlspecialchars($pseudo);
        $mail = htmlspecialchars($mail);
        $pass1 = htmlspecialchars($pass1);
        $pass2 = htmlspecialchars($pass2);
        // On vérifie si le mot de passe fait au moins 6 caractères avec une majuscule, un chiffre et un special char
        if (validation_password($pass1)) {

            // On vérifie si les deux mots de passe sont identiques
            if ($pass1 === $pass2) {

                // On vérifie si le mail est valide
                if (validation_mail($mail)) {

                    // On vérifie si le pseudo n'a que des lettres, chiffres et -/_
                    if (validation_pseudo($pseudo)) {

                        // On vérifie si le pseudo n'est pas dans la base
                        try {
                            $req_select = "SELECT count(pseudo) as 'count' from membre where pseudo=:pseudo;";
                            $req_select_prep = $dbh->prepare($req_select);
                            $req_select_prep->execute(['pseudo' => $pseudo]);
                            foreach ($req_select_prep as $row) {
                                // Si tout est OK -> enregistrement dans la base
                                if ($row['count'] == 0) {
                                    try {
                                        $req_insert = "INSERT INTO membre (pseudo, password, mail) VALUES (:pseudo, :password, :mail);";
                                        $req_insert_prep = $dbh->prepare($req_insert);
                                        $req_insert_prep->execute(['pseudo' => $pseudo, 'password' => $pass1, 'mail' => $mail]);
                                        $retour['form'] = true;
                                        // Si requete insert échoue
                                    } catch (Exception $e) {
                                        print "Erreur : " . $e->getMessage() . "<br/>";
                                        die();
                                    }
                                    // Si le pseudo est déjà dans la base
                                } else {
                                    $retour['erreur'] = "Ce pseudo est déjà pris";
                                }
                            }
                            // Si la requete select pour comparer le pseudo échoue
                        } catch (Exception $e) {
                            print "Erreur : " . $e->getMessage() . "<br/>";
                            die();
                        }
                        // Si le pseudo n'est pas valide
                    } else {
                        $retour['erreur'] = "Pseudo invalide";
                    }
                    // Si le mail n'est pas valide
                } else {
                    $retour['erreur'] = "Adresse mail invalide";
                }
                // Si les 2 mdp ne correspondent pas 
            } else {
                $retour['erreur'] = "Les deux mots de passe ne sont pas identiques";
            }
            // Si le mot de passe est invalide
        } else {
            $retour['erreur'] = "Mot de passe invalide";
        }
    } else {
        $retour['erreur'] = "Vous devez accepter les conditions générales d'utilisation";
    }
    return $retour;
}
