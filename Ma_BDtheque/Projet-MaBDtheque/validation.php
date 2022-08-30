<?php
// Fonction pour valider le mot de passe (6min, une maj, un chiffre et un special char)
function validation_password($s) {
    $i = 0;
    $check_maj = false;
    $check_num = false;
    $check_spec = false;
    if (strlen($s) >= 6) {
        while ($i < strlen($s)) {
            if ($s[$i] >= 'A' && $s[$i] <= 'Z'){
                $check_maj = true;
            }
            elseif ($s[$i] >= '0' && $s[$i] <= '9'){
                $check_num = true;
            }
            elseif (($s[$i] >= '!' && $s[$i] <= '/') || ($s[$i] >= ':' && $s[$i] <= '@')){
                $check_spec = true;
            }
            $i++;
        }
        if ($check_maj && $check_num && $check_spec) {
            return true;
        }
    } else {
        return false;
    }
}

// Fonction pour vérifier le mail 
function validation_mail($s) {
    // On vérifie si il n'y a qu'un arobase et que ce n'est pas le premier char ni le dernier char
    function arobase($s) {
        $check = 0;
        for ($i=0; $i < strlen($s); $i++){
            if (($i == 0 && $s[$i] == '@') || ($i == (strlen($s) -1) && $s[$i] == '@')) {
                return false;
            }
            elseif ($s[$i] === '@'){
                $check++;
            }
        }
        if ($check == 1) {
            return true;
        } else { 
            return false; 
        }
    }
    // On vérifie si le domaine a un point 
    function domain($s) {
        $arobase = false;
        for ($i = 0; $i < strlen($s); $i++) {
            if ($s[$i]=='@'){
                $arobase = true;
            }
            elseif ($arobase && $s[$i]=='.') {
                return true;
            }
        }
        return false;
    }
    // On vérifie si le suffixe a au moins deux char
    function suffix($s){
        $point = strlen($s) - 1;
        while ($s[$point] != '.'){
            $point--;
        }
        if ((strlen($s)-1) - $point >= 2){
            return true;
        }
        else {
            return false;
        }
    }
    // On vérifie le tout 
    if (arobase($s)){
        if (domain($s)){
            if (suffix($s)){
                return true;
            } else { return false; }
        } else { return false; }
    } else { return false; }
}

// Fonction pour valider le pseudo (20char max : chiffre/lettre et -/_)
function validation_pseudo($s) {
    $i = 0;
    if (strlen($s) <= 20) {
        while ($i < strlen($s)){
            if (!($s[$i] >= 'A' && $s[$i] <= 'z') && !($s[$i] === '-') && !($s[$i] === '_')) {
                return false;
            }
            $i++;
        }
        return true;
    } else {
        return false;
    }
}

// Fonction pour valider l'ISBN
function validation_isbn($s){
    for ($i = 0; $i < strlen($s); $i++) {
        if (!($s[$i] >= '0' && $s[$i] <= '9')) {
            return false;
        }
    }
    return true;
}
?>
