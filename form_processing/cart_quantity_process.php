<!-- php treatment -->
<?php
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php';
    // on demarre une session
    session_start();

    if (isset($_POST['quantity'], $_POST['produitId'], $_POST['produitNom'])) {
        // on appelle la fonction qui modifie la quantite du produit 
        $newQuantity = modif_qte($_POST['produitId'], $_POST['quantity']);
        // si tout c est bien deroule
        if ($newQuantity) {
            // on envoie un message avec le nombre ajoute
            $_SESSION['error']['show'] = true;
            $_SESSION['error']['message'] = "La quantité de ". $_POST['produitNom']." est passé à ".$_POST['quantity']." !";
            // on redirige vers la page du panier
            header('location:/../panier.php');
            die;
        } else {
            // on envoie un message d erreur
            $_SESSION['error']['show'] = true;
            $_SESSION['error']['message'] = "Problème lors de la modification de la quantité de ".$_POST['produitNom']." !";
            // on redirige vers la page du panier
            header('location:/../index.php');
            die;
        }
    }
?>