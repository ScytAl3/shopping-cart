<?php
// -- import du script de connexion a la db
require 'pdo_db_connect.php'; 
// -- import du script des fonctions speciales
require 'special_functions.php';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Les Fonctions utilisateurs                                      //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ---------------------------------------------//-----------------------------------------
//      fonction pour verifier l existence d un champ dans la table users
// ---------------------------------------------//-----------------------------------------
function userExist($where, $valueToTest) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la  requete preparee pour verifier si la condition testee renvoie un resultat
    $query = "SELECT * FROM users WHERE $where = :bp_pseudo";
    // preparation de l execution de la requete
    try {
        $statement = $pdo -> prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage de la valeur a tester en  parametre
        $statement->bindParam(':bp_pseudo', $valueToTest, PDO::PARAM_STR);
        // execution de la requete
        $statement -> execute(); 
        $count = $statement->rowCount();       
        // --------------------------------------------------------------
        //var_dump($count = $statement->fetch()); die; 
        // --------------------------------------------------------------
        // si on trouve un resultat
        if ($count == 1) {
            // on recupere les donnees qui sont associees a l utilisateur 
            $userExist= $statement->fetch(); 
        } else {
            $userExist = false;
        }         
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO Check User Exist...' . $ex->getMessage();
        die($msg); 
    }
    $statement = null;
    $pdo = null;
    // on retourne le resultat
    return $userExist; 
}

// ------------------------------------------------------------
//           fonction pour verifier le mot de passe
// ------------------------------------------------------------
function validPassword($loginPwd, $user) {
    // on on appelle la fonction speciale qui verifie le mot de passe saissi grace au Salt et mot de passe chiffre associes a l utilisateur
    $checkPwd = VerifyEncryptedPassword($user['userSalt'], $user['userPassword'], $loginPwd);
    // ------------------------------------
    //var_dump($checkPwd); die;
    // ------------------------------------
    // si identique
    if ($checkPwd) {        
        $user_valid = true;
    } else {        
        $user_valid = false;
    } 
    // on retourne le resultat
    return $user_valid; 
}

// -----------------------------------------------------------
//              fonction pour creer un utilisateur
// -----------------------------------------------------------
function createUser($userData) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la requete pour creer un utilisateur
    $sqlInsert = "INSERT INTO 
                                users (`userLastName`, `userFirstName`, `userEmail`, `userPassword`, `userSalt`, `accountCreated_at`, `userRole`) 
                            VALUES 
                                (?, ?, ?, ?, ?, ?, now(), DEFAULT)";
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($sqlInsert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // execution de la requete
        $statement -> execute($userData);
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO create user...' . $ex->getMessage();
        die($msg); 
    }
    // on retourne le dernier Id cree
    return $pdo -> lastInsertId(); 
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Les Fonctions produits                                          //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ----------------------------------------------------------------------
//      fonction pour renvoyer la liste des produits
// ----------------------------------------------------------------------
/**
 *  renvoie un tableau de la liste des produits
 * 
 * @return Mixed    retourne un tableau de donnees - sinon FALSE si aucun resultat pour la requete
 */
function allProductReader() {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();   
    // preparation de la requete preparee 
    $queryList = "SELECT  p.produitsId AS produitId,
                                            p.produitsName AS produitName,
                                            p.produitsDescription AS produitResume,
                                            p.produitsPrix AS produitPrix,
                                            i.pictureFilename AS picture
                            FROM `produits` p
                            INNER JOIN pictures i ON i.produitsId = p.produitsId
                            WHERE p.produitsQuantite > 0
                            AND p.produitavailable = 1
                            GROUP BY p.produitsId
                            ORDER BY p.created_at DESC";   
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($queryList, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // execution de la requete
        $statement -> execute();
        // on verifie s il y a des resultats
        // --------------------------------------------------------
        //var_dump($statement->rowCount()); die; 
        // --------------------------------------------------------
        if ($statement->rowCount() > 0) {
            $myReader = $statement->fetchAll();            
        } else {
            $myReader = false;
        }   
        //$statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO Product list...' . $e->getMessage(); 
        die($msg);    
    }
    // on retourne le resultat
    return $myReader; 
}

// ---------------------------------------------------------------------------
//      fonction pour renvoyer les informations d un produit
// ---------------------------------------------------------------------------
function productReader($productId) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();   
    // preparation de la requete preparee 
    $queryList = "SELECT  p.produitsName AS produitName,
                                            p.produitsQuantite AS produitQuantite,
                                            p.produitsPrix AS produitPrix,
                                            i.pictureFilename AS picture
                            FROM `produits` p
                            INNER JOIN pictures i ON i.produitsId = p.produitsId 
                            WHERE p.produitsId = :bp_productId";   
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($queryList, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage de l identifiant utilisateur
        $statement->bindParam(':bp_productId', $productId, PDO::PARAM_STR);
        // execution de la requete
        $statement -> execute();
        // on verifie s il y a des resultats
        // --------------------------------------------------------
        //var_dump($statement->fetchColumn()); die; 
        // --------------------------------------------------------
        if ($statement->rowCount() > 0) {
            $myReader = $statement->fetch();            
        } else {
            $myReader = false;
        }   
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO Product detail...' . $ex->getMessage(); 
        die($msg);
    }
    // on retourne le resultat
    return $myReader; 
}

// -------------------------------------------------------------------------------
//      fonction pour renvoyer les photos associees a un produit
// -------------------------------------------------------------------------------
function productPictureReader($productId) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();   
    // preparation de la requete preparee 
    $queryList = "SELECT p.picturesId AS pictureId, p.pictureFilename AS picture
                            FROM `articles` a
                            INNER JOIN pictures p ON p.articlesId = a.articlesId
                            WHERE p.articlesId = :bp_articlesId";   
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($queryList, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage de l identifiant utilisateur
        $statement->bindParam(':bp_articlesId', $productId, PDO::PARAM_STR);
        // execution de la requete
        $statement -> execute();
        // on verifie s il y a des resultats
        // --------------------------------------------------------
        //var_dump($statement->fetchColumn()); die; 
        // --------------------------------------------------------
        if ($statement->rowCount() > 0) {
            $myReader = $statement->fetchAll();            
        } else {
            $myReader = false;
        }   
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO Product pictures list...' . $ex->getMessage(); 
        die($msg);
    }
    // on retourne le resultat
    return $myReader; 
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Les Fonctions panier                                             //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ------------------------------------------------------------------------------------------
//      fonction pour creer une entree dans la table panier apres validation
// ------------------------------------------------------------------------------------------
function createPanier($userId) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la requete pour creer un utilisateur
    $sqlInsert = "INSERT INTO 
                                `paniers`(`panierUserTemp`, `created_at`)
                            VALUES 
                                (:bp_userId, now())";
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($sqlInsert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage de la valeur en  parametre
        $statement->bindParam(':bp_userId', $userId, PDO::PARAM_INT);
        // execution de la requete
        $statement -> execute();
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO Create Panier...' . $ex->getMessage();
        die($msg); 
    }
    // on retourne le dernier Id cree
    return $pdo -> lastInsertId(); 
}

// ---------------------------------------------------------------------------------------------------
//      fonction pour creer une entree dans la table ligne_commande apres validation
// ---------------------------------------------------------------------------------------------------
function createLineCmd($lineCmdData) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la requete pour creer un utilisateur
    $sqlInsert = "INSERT INTO 
                                `lignes_commande`(`paniersId`, `produitsId`, `quantite`, `prixTotal`)
                            VALUES 
                                (?, ?, ?, ?)";
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($sqlInsert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // execution de la requete
        $statement -> execute($lineCmdData);
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO Create Line Command...' . $ex->getMessage();
        die($msg); 
    }
    // on retourne le dernier Id cree
    return $pdo -> lastInsertId(); 
}

// ----------------------------------------------------------------------------------------------------
//      fonction pour mettre a jour la quantite d un produit apres validation du panier 
// ----------------------------------------------------------------------------------------------------
function updateProductQuantity($quantity, $productId) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la  requete preparee pour mettre a jour les informations
    $sql = "UPDATE `produits` SET `produitsQuantite`= (`produitsQuantite` - :bp_quantity)";
    $where = " WHERE `produitsId`= :bp_productId";
    // construction de la requete
    $query = $sql.$where;
    // preparation de l execution de la requete
    try {
        $statement = $pdo -> prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage des valeurs en  parametre
        $statement->bindParam(':bp_quantity', $quantity, PDO::PARAM_INT);
        $statement->bindParam(':bp_productId', $productId, PDO::PARAM_INT);
        // execution de la requete
        $statement -> execute(); 
        $statement -> closeCursor();  
        $msg =  "Le stock du produit a diminué de ".$quantity;
    } catch(PDOException $ex) {       
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO Update quantity stock product...' . $ex->getMessage(); 
        die($msg); 
    }
    $statement = null;
    $pdo = null;
    // on retourne le resultat
    return $msg;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Les Fonctions Administrateur                               //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
