<!-- php treatment -->
<?php
    // on demarre une session
    session_start();
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php';

    if (isset($_POST['quantity'], $_POST['produitId'], $_POST['produitNom'])) {
        // -------------------------------------------------------------------------------------------------
        //                                          modifie la quantite du produit
        // -------------------------------------------------------------------------------------------------
        $newQuantity = modif_qte($_POST['produitId'], $_POST['quantity']);
        // --------------------------------------------------------------------------------
        //                                  si  la fonction renvoie true
        // --------------------------------------------------------------------------------
        if ($newQuantity) {
            // on envoie un message avec le nombre ajoute
            $_SESSION['error']['page'] = 'panier';
            $_SESSION['error']['message'] = "La quantité de ". $_POST['produitNom']." est passé à ".$_POST['quantity']." !";
            // on redirige vers la page du panier
            header('location:/../panier.php');
            die();
        // --------------------------------------------------------------------------------
        //                                               sinon
        // --------------------------------------------------------------------------------
        } else {
            // on envoie un message d erreur
            $_SESSION['error']['page'] = 'panier';
            $_SESSION['error']['message'] = "Problème lors de la modification de la quantité de ".$_POST['produitNom']." !";
            // on redirige vers la page du panier
            header('location:/../panier.php');
            die();
        }
    }
?>