<?php
// --------------------------------------------------------------
// FONCTION : Generer Salt
// --------------------------------------------------------------
function generateSalt( $lenght = 10 ) {
    $allowedChar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $maxLenght = strlen($allowedChar);
    $randomString = '';
    for ($i=0; $i < $lenght; $i++) { 
        $randomString .= $allowedChar[rand(0, $maxLenght-1)];
    }
    $encryptedSalt = md5($randomString);
    return $encryptedSalt;
}

// --------------------------------------------------------------
// FONCTION : Hashage du mot de passe
// --------------------------------------------------------------
function CreateEncryptedPassword( $salt, $password )
{
    $md5Pwd = md5($password);
    $encryptedPwd = md5($salt . $md5Pwd);
    return $encryptedPwd;                   // génère 60 caractères
};

// --------------------------------------------------------------
// FONCTION : Verification du mot de passe
// --------------------------------------------------------------
function VerifyEncryptedPassword( $userSalt, $userPwd, $loginPwd )
{
    $encryptLoginPwd = CreateEncryptedPassword($userSalt, $loginPwd);
    return ($userPwd == $encryptLoginPwd) ? true : false;
};

/* 
// pour construire le jeu de donnees users
$pwdIn = "c4tchM3";
// genere le salt
$mySalt = generateSalt(10);
echo 'le salt = '.$mySalt."\n";
// genere le mdp
$myPwd = CreateEncryptedPassword($mySalt, $pwdIn);
echo 'le pwd chiffré : '.$myPwd."\n";
// verifie le mdp et le 
$check = VerifyEncryptedPassword($mySalt, $myPwd, $pwdIn);
var_dump($check);
*/

// --------------------------------------------------------------
// FONCTION : Verification des images
// --------------------------------------------------------------
function ValidateUpload($image) {
    // on initialise le tableau des erreurs
    $errors= array();
    // on verifie si une image est envoyee
    if ($image['name'] == '') {
        return($errors);
    }
    // initialisation des variables avec les informations du fichier uploade
    $file_tmp = $image['tmp_name'];
    $file_name = $image['name'];
    $file_size = $image['size'];
    $file_type = $image['type'];
    $fileNameCmps = explode(".", $file_name);
    $file_ext = strtolower(end($fileNameCmps)); // donne l extension de l image    
    // dossier dans lequel l image sera deplacee
    $target_dir = "../img/news_feeds_pictures/";
    // on verifie si le fichier image est une vrai image ou une fausse image
    $check = getimagesize($file_tmp);
    if($check == false) {
        $errors[]= "Le fichier n'est pas une image !";
        return($errors);
    }
    // on verifie la taille du fichier
    if ($file_size > 2097152) {
        $errors[]= "Le fichier ne doit pas dépasser 2 MB !";
        return($errors);
    }    
    // extensions autorisees pour l upload des images
    $allowedImageExtensions= array("jpeg","jpg","png");
    // on verifie si l extension est valide
    if (in_array($file_ext, $allowedImageExtensions) === false){
        $errors[]= "Extension non autorisée, choisissez un fichier JPEG ou PNG !";
        return($errors);
    } 
};

// --------------------------------------------------------------
// FONCTION : Telechargement  des images
// --------------------------------------------------------------
function UploadImage($image) {
    // si aucune image n est envoyee la valeur pour l insert sera null et on affichera l image par defaut
    if ($image['name'] == '') {
        $newFileName = null;
    } else {
        // initialisation des variables avec les informations du fichier uploade
        $file_tmp = $image['tmp_name'];
        $file_name = $image['name'];
        $fileNameCmps = explode(".", $file_name);
        $file_ext = strtolower(end($fileNameCmps)); // donne l extension de l image
        // on supprime les espaces et caracteres speciaux
        $newFileName = md5(time() . $file_name) . '.' . $file_ext;
        // dossier dans lequel l image sera deplacee
        $target_dir = "../img/news_feeds_pictures/";
        $dest_path = $target_dir . $newFileName;
        // on deplace le fichier du repertoire temp a celui choisi
        move_uploaded_file($file_tmp, $dest_path);        
    }    
    return $newFileName;
}

// --------------------------------------------------------------
// FONCTION : Formatage de la date a afficher
// --------------------------------------------------------------
function formatedDateTime($mysqlDate){
    $date = date_format($mysqlDate,"d/m/Y");
    $hour = date_format($mysqlDate, "H");
    $minute = date_format($mysqlDate, "i");
    // on retourne la au format desire
    return  $date.' à '.$hour.'h'.$minute.'.';
};

// ------------------------------------------------------------------------------
// FONCTION : verification presence d un produit dans le panier
// ------------------------------------------------------------------------------
/**
 * verifie la presence d un produit dans le panier
 *
 * @param String $id_product numéro d identification du produit a verifier
 * @return Boolean Renvoie Vrai si le produit est trouve dans le panier, Faux sinon
 */
function verifyPanier($id_product) {
    // on initialise la variable de retour
    $find = false;
    // on verifie les numeros d identification des produit et on compare avec celui du produit a verifier
    if (count($_SESSION['panier']['id_product']) > 0 && array_search($id_product, $_SESSION['panier']['id_product']) !== false) {
        $find = true;
    }
    return $find;
};

// ------------------------------------------------------------------------------
// FONCTION : suppression d un produit dans le panier
// ------------------------------------------------------------------------------
/**
 * supprimer un article du panier
 * 
 * @param String     $id_product numéro d identification du produit a supprimer 
 * @param Boolean    $reindex : facultatif, par défaut, vaut true pour ré-indexer le tableau après 
 *                                  suppression. On peut envoyer false si cette ré-indexation n'est pas nécessaire. 
 * @return Mixed     retourne TRUE si la suppression a bien ete effectuee - FALSE sinon - "absent" si 
 *                                  le produit a deja ete retire du panier 
 */
function deleteProduct($id_product, $reindex = true) {
    $suppression = false;
    // on cherche dans le tableau des id produit la cle qui correspond a l id du produit que l on veut supprimer
    $keyDelete = array_keys($_SESSION['panier']['id_product'], $id_product);        
    // sortie la cle a ete trouvee
    if (!empty ($keyDelete)) {
        // on parcours le panier pour supprimer l identifiant correspondant
        foreach ($_SESSION['panier'] as $key => $value) {
            foreach($keyDelete as $idValue) {                     
                unset($_SESSION['panier'][$key][$idValue]); 
            } 
            // reindexation des tableaux
            if ($reindex == true) {
                $_SESSION['panier'][$key] = array_values($_SESSION['panier'][$key]);
            }
            $suppression = true; 
        }
    } else {
        $suppression = "absent";
    }
    return $suppression;
};

// ------------------------------------------------------------------------------
// FONCTION : modifier la quantite d un produit dans le panier
// ------------------------------------------------------------------------------
/**
 * modifie la quantite d un article dans le panier
 *
 * @param String    $id_product  identifiant du produit a modifier
 * @param Int   $qte nouvelle quantite a enregistrer
 * @return Boolean  retourne VRAI si la modification a bien eu lieu, FAUX sinon.
 */
function modif_qte($id_product, $qte) {
    // on compte le nombre de produits differents dans le panier 
    $nb_produit = count($_SESSION['panier']['id_product']);
    // on initialise la variable de retour
    $ajoute = false;
    // on parcoure le tableau de session pour modifier le produit precis
    for ($i = 0; $i < $nb_produit; $i++) {
        if ($id_product == $_SESSION['panier']['id_product'][$i]) {
            $_SESSION['panier']['qte_product'][$i] = $qte;
            $ajoute = true;
        }
    }
    return $ajoute;
} 

// ------------------------------------------------------------------------------
// FONCTION : calculer le total du panier
// ------------------------------------------------------------------------------
/**
 * calcule le montant total du panier
 *
 * @return Double
 */
function montant_panier() {
    // on initialise le montant 
    $montant = 0;
    // comptage des produits du panier
    $nb_produits = count($_SESSION['panier']['id_product']);
    // on calcule le total par produit
    for ($i = 0; $i < $nb_produits; $i++)
    {
        $montant += $_SESSION['panier']['qte_product'][$i] * $_SESSION['panier']['prix'][$i];
    }
    // on retourne le resultat
    return $montant;
} 

// ------------------------------------------------------------------------------
// FONCTION : calculer le total des produits
// ------------------------------------------------------------------------------
/**
 * calcule la quantite totale des produits du panier
 *
 * @return Int
 */
function quantite_produit_panier() {
    // on initialise le montant 
    $quantite = 0;
    // comptage des produits du panier
    $nb_produits = count($_SESSION['panier']['id_product']);
    // on calcule le total par produit
    for ($i = 0; $i < $nb_produits; $i++)
    {
        $quantite += $_SESSION['panier']['qte_product'][$i];
    }
    // on retourne le resultat
    return $quantite;
} 

// ------------------------------------------------------------------------------
// FONCTION : vider le panier
// ------------------------------------------------------------------------------
function vider_panier()
{
    $vide = false;
    unset($_SESSION['panier']);
    if(!isset($_SESSION['panier']))
    {
        $vide = true;
    }
    return $vide;
} 