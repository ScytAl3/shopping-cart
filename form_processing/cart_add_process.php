<!-- php treatment -->
<?php
    // on demarre la session
    session_start();
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php'; 

    // -------------------------------------------------------------------------------------------------
    //                  verifie que le produit qu on ajoute n est pas deja dans le panier
    // -------------------------------------------------------------------------------------------------
    $checkProduct = verifyPanier($_GET['productId']);
    // --------------------------------------------------------------------------------
    //                      si  - produit existe
    // ---------------------------------------------------------------------------------
    if ($checkProduct) {
        // on envoie un message d erreur
        $_SESSION['error']['page'] = 'shop';
        $_SESSION['error']['message'] = "Ce produit est déjà dans votre panier !";
        // on redirige vers la page de la liste des produits
        header('location:../shop.php');
        die();
    // --------------------------------------------------------------------------------
    //                                                  sinon
    // ---------------------------------------------------------------------------------
    } else {
        // on ajoute l identifiant du produit dans le tableau du panier
        array_push($_SESSION['panier']['id_product'], (int) $_GET['productId']);
        // on ajoute la quantite par defau du produit dans le tableau du panier
        array_push($_SESSION['panier']['qte_product'], 1);
        // on ajoute le prix unitaire du produit dans le tableau du panier
        array_push($_SESSION['panier']['prix'], $_GET['productPrice']);
        // on envoie un message pour notifier l ajout du produit dans le panier
        $_SESSION['error']['page'] = 'shop';
        $_SESSION['error']['message'] = "Ce produit a été ajouté dans votre panier !";
        // on redirige vers la page de la liste des produits
        header('location:../shop.php');
        die();
    }
?>