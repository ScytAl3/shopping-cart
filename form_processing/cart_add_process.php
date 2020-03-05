<!-- php treatment -->
<?php
    // on demarre la session
    session_start();
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php'; 

    // appelle la fonction pour verifier que le produit qu on ajoute n est pas deja dans le panier
    $checkProduct = verifyPanier($_GET['productId']);
    // si le produit se trouve deja dans le panier
    if ($checkProduct) {
        // on envoie un message d erreur
        $_SESSION['error']['show'] = true;
        $_SESSION['error']['message'] = "Ce produit est déjà dans votre panier !";
        // on redirige vers la page de la liste des produits
        header('location:/../index.php');
        die;
    } else {
        // on ajoute l identifiant du produit dans le tableau du panier
        array_push($_SESSION['panier']['id_product'], (int) $_GET['productId']);
        // on ajoute la quantite par defau du produit dans le tableau du panier
        array_push($_SESSION['panier']['qte_product'], 1);
        // on ajoute le prix unitaire du produit dans le tableau du panier
        array_push($_SESSION['panier']['prix'], $_GET['productPrice']);
        // on envoie un message pour notifier l ajout du produit dans le panier
        $_SESSION['error']['show'] = true;
        $_SESSION['error']['message'] = "Ce produit a été ajouté dans votre panier !";
        // on redirige vers la page de la liste des produits
        header('location:/../index.php');
        die;
    }
?>