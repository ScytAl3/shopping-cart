<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Les Fonctions chiffrement                                    //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// --------------------------------------------------------------
// FONCTION : Generer Salt
// --------------------------------------------------------------
/**
 * genere uns Salt qui sera associe a un compte pour chiffrer le mot de passe
 * 
 * @return String   chaine aleatoire de 10 caracteres
 */
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
/**
 * retourne une chaine chiffree
 * 
 * @param String    le Salt associe a un utilisateur
 * @param String    la chaine de caractere saisie par l utilisateur lors de la creation de son compte
 * 
 * @return String   chaine chiffree
 */
function CreateEncryptedPassword( $salt, $password )
{
    $md5Pwd = md5($password);
    $encryptedPwd = md5($salt . $md5Pwd);
    return $encryptedPwd;                   // génère 60 caractères
};

// --------------------------------------------------------------
// FONCTION : Verification du mot de passe
// --------------------------------------------------------------
/**
 * verifie le mot de passe saisi avec celui enregistre dans la base de donnees
 * 
 * @param String    le salt associe a l utilisateur stocke dans la base de donnees
 * @param String    le mot de passe associe a l utilisateur stocke dans la base de donnees
 * @param String    le mot de passe saisi lors de l authentification
 * 
 * @return Boolean  renvoie TRUE si le mot de passe saisi correspond - sinon FALSE
 */
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Les Fonctions upload file                                      //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// --------------------------------------------------------------
// FONCTION : Verification des images
// --------------------------------------------------------------
/**
 * verifie que le fichier uploade correspond a ce qui est autorise
 * 
 * @param Array tableau associe au fichier uploade $_FILES[]
 * 
 * @return String   retourne un string vide si le fichier est valide, sinon le message d erreur correspondant    
 */
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
/**
 * deplace le fichier uploade a partir du dossier temporaire vers le dossier de destination en le chiffrant
 * 
 * @param Array tableau associe au fichier uploade $_FILES[]
 * 
 * @return String retourne le nom du fichier chiffre
 */
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Les Fonctions diverses                                          //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// --------------------------------------------------------------
// FONCTION : Formatage de la date a afficher
// --------------------------------------------------------------
/**
 * formate une date MySQL dans le format choisi
 * 
 * @param Datetime  la date MySQL retournee par une requete SELECT
 * 
 * @return String   la date formatee
 */
function formatedDateTime($mysqlDate){
    $date = date_format($mysqlDate,"d/m/Y");
    $hour = date_format($mysqlDate, "H");
    $minute = date_format($mysqlDate, "i");
    // on retourne la au format desire
    return  $date.' à '.$hour.'h'.$minute.'.';
};

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Les Fonctions panier                                             //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ------------------------------------------------------------------------------
// FONCTION : verification presence d un produit dans le panier
// ------------------------------------------------------------------------------
/**
 * verifie la presence d un produit dans le panier
 *
 * @param String $id_product numéro d identification du produit a verifier
 * @return Boolean Renvoie TRUE si le produit est trouve dans le panier, FALSE sinon
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
 * @param String     $id_product numero d identification du produit a supprimer 
 * @param Boolean    $reindex : facultatif, par defaut, vaut true pour re-indexer le tableau apres 
 *                                  suppression. On peut envoyer false si cette re-indexation n est pas necessaire. 
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
/**
 * vide le panier en cours
 * 
 * @return Boolean  retourne TRUE si le panier est vide, sinon FALSE
 */
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