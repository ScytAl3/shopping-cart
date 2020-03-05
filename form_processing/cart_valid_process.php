<!-- php treatment -->
<?php
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php';
    // on demarre une session
    session_start();

    // recuperation de l identifiant de l utilisateur
    $userCartId = $_SESSION['current_Id'];
    //  --------------------------------------------------//--------------------------------------------------
    //                                          Creation du panier dans la table 
    //  --------------------------------------------------//--------------------------------------------------
    // on appelle la fonction pour creer le panier en cours dans la table panier - la fonction doit revoyer le nouvel identifiant cree
    $newCartId = createPanier($userCartId);
    // si probleme lors de l insert des valeurs du panier dans la table
    if ($newCartId < 0) {
        // on envoie un message pour notifier l erreur
        $_SESSION['error']['show'] = true;
        $_SESSION['error']['message'] = "Problème lors de la création du panier !";
        // on redirige vers la page du panier
        header('location:/../panier.php');
        die;
    }
    //  --------------------------------------------------//--------------------------------------------------
    //                     Creation des ligne_commande associees au panier et aux produits
    //  --------------------------------------------------//--------------------------------------------------
    // on compte le nombre de produits differents dans le panier 
    $nb_produit = count($_SESSION['panier']['id_product']);
    // on parcours a chaque iteration les sous tableaux du panier
    for ($i=0; $i < $nb_produit; $i++) { 
        // on recupere l identifiant du produit
        $productId = $_SESSION['panier']['id_product'][$i];
        // on recupere la quantite de ce produit
        $productQuantity = $_SESSION['panier']['qte_product'][$i];
        // on recupere le prix unitaire de ce produit
        $productPrice = $_SESSION['panier']['prix'][$i];       
        // on calcule le prix tolal pour la quantite de ce produit
        $prixTotalProduct =  $productQuantity * $productPrice;
        // on prepare le tableau des donnees a passer en parametre a la fonction qui va inserer les lignes dans la table
        $lineCmdData = [
            $newCartId,             // identifiant du panier cree 
            $productId,              // identifiant du produit
            $productQuantity,   // la quantite du produit
            $prixTotalProduct   // le total de la ligne de commande
        ];
        // on appelle la fonction pour creer la ligne de commande
        $newLineCmd = createLineCmd($lineCmdData);
        //  --------------------------------------------------//--------------------------------------------------
        //                      Mise a jour de la quantite en stock des produits du panier
        //  --------------------------------------------------//--------------------------------------------------
        // on passe les donnees en parametre a la fonction qui va mettre a jour la quantite en stock des produits
        $updateQteProduct = updateProductQuantity($productQuantity, $productId);        
    }
    // on vide le panier
    vider_panier();
    // on redirige vers la page logout
    header('location:/../logout.php');
?>