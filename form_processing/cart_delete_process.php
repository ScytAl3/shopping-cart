<!-- php treatment -->
<?php
    // on demarre la session
    session_start();
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php';     
    
    // -------------------------------------------------------------------------------------------------
    //                                      supprime le produit selectionne
    // -------------------------------------------------------------------------------------------------
    deleteProduct($_GET['productId']);
    // on envoie un message pour notifier la suppression du produit du panier
     $_SESSION['error']['page'] = 'panier';
    $_SESSION['error']['message'] = "Le produit ".$_GET['productId']." a bien été supprimé votre panier !";
    // on redirige vers la page du panier des produits
    header('location:../panier.php');
    die();
?>