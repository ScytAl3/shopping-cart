<?php
// on démarre la session
session_start ();
// import du script pdo des fonctions qui accedent a la base de donnees
require 'pdo/pdo_db_functions.php';
// ----------------------------//---------------------------
//                      variables de session
// ---------------------------------------------------------
//----------------------------//----------------------------
//                              CART
// on verifie l existence du panier, sinon on le cree
if (!isset($_SESSION['panier'])) {
    // initialisation du panier 
    $_SESSION['panier'] = array();
    // subdivision du panier 
    $_SESSION['panier']['id_product'] = array();
    $_SESSION['panier']['qte_product'] = array();
    $_SESSION['panier']['prix'] = array();
}
//                              CART
//----------------------------//----------------------------
//----------------------------//----------------------------s
//                              USER
// utilisateur valide en cours de session
$_SESSION['current_Session'] = (isset($_SESSION['current_Session'])) ? $_SESSION['current_Session'] : false;
// variable pour l utilisateur connecte en cours de session
$_SESSION['current_userTemp']  =  (isset($_SESSION['current_userTemp'])) ? $_SESSION['current_userTemp'] : time();
// role utilisateur en cours de session
$_SESSION['current_Role'] = (isset($_SESSION['current_Role'])) ? $_SESSION['current_Role'] : 'Default';
// identifiant de l admin
$_SESSION['current_Id'] = (isset($_SESSION['current_Id'])) ? $_SESSION['current_Id'] : false;
//                              USER
//----------------------------//----------------------------
//----------------------------//----------------------------
//                     ERROR MANAGEMENT
$_SESSION['error']['page'] = (isset($_SESSION['error']['page'])) ? $_SESSION['error']['page'] : 'productList';
$_SESSION['error']['show'] = ((isset($_SESSION['error']['show'])) && ($_SESSION['error']['page'] =='productList')) ? $_SESSION['error']['show'] : false;
$_SESSION['error']['message'] = ((isset($_SESSION['error']['message'])) && ($_SESSION['error']['page'] =='productList')) ? $_SESSION['error']['message'] :  '';
$_SESSION['error']['page'] = 'productList';
//                     ERROR MANAGEMENT
//----------------------------//----------------------------
// ----------------------------------------------------------
//                  variables de session
// ----------------------------//-----------------------------
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<!-- default Meta -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Gestion panier - Liste des produit</title>
		<meta name="author" content="Franck Jakubowski">
		<meta name="description" content="Un mini site de produits à ajouter à un panier.">
		<!-- 
            favicons
         -->
		<!-- bootstrap stylesheet -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- font awesome stylesheet -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<!-- default stylesheet -->
		<link href="css/index.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body>   
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <!--------------------------------------//------------------------------------------------
                            debut du container pour afficher la liste des produits
        ------------------------------------------------------------------------------------------>           
        <div class="mt-5 container-fluid"> 

            <div class="my-3 p-3">
                <!-- titre de la page de presentation des produits & messages divers -->
                <div class="text-center mx-auto">
                    <!-- message d information pour tester la connexion a la base de donnees -->
                    <div class="show-bg">
                        <?php require 'pdo/pdo_db_connect.php'; 
                            // on instancie une connexion pour verifie s il n y a pas d erreurs avec les parametres de connexion
                            $pdo = my_pdo_connexxion();
                            if ($pdo) {
                                echo 'Connexion réussie à la base de données';
                            } else {
                                var_dump($pdo);
                            }
                        ?>                            
                    </div>
                    <!-- /message d information pour tester la connexion a la base de donnees -->                   
                    
                    <h2 class="display-4 font-weight-bold text-muted">Liste des produits disponibles</h2>                       
                    <!-- area pour afficher un message d erreur -->
                    <div class="show-bg<?=($_SESSION['error']['show']) ? '' : 'visible'; ?> text-center mt-5">
                        <p class="lead mt-2"><span><?=$_SESSION['error']['message'] ?></span></p>
                    </div>
                    <!-- /area pour afficher un message d erreur lors du login -->
                </div>
                <!-- /titre de la page de presentation des produits & messages divers -->
            </div>           
            
            <div class="row justify-content-around">
                <!---------------------------------//-----------------------------------------
                    debut script php pour recuperer tous les produits
                ------------------------------------------------------------------------------>
                <?php   
                    // appelle de la fonction qui retourne les information de chaque produits
                    $allProduct = allProductReader();   
                    //
                    //var_dump($allProduct); die;
                    //
                    // si la fonction retourne un resultat
                    if ($allProduct) {
                    // boucle pour afficher les differentes produits
                    foreach ($allProduct as $myProduct => $column) {
                        // on verifie la presence du nom d une image dans la table sinon on affiche celle par defaut
                        $productPicture = (($column['picture']) == '') ? 'empty_picture.jpg' : $column['picture'];
                ?>
                    <!-- on recupere les valeurs des differents champs d une ligne d un produit-->             
                    <div class="col-sm-3 card border-primary mx-1 mb-5 py-3">
                        <!-- photo du produit -->
                        <img class="card-img-top news-picture mx-auto" src="/img/product_pictures/<?=$productPicture ?>" alt="a product picture">
                        <!-- /photo du produit -->

                        <!-- nom et description du produit -->
                        <div class="card-header mt-2">
                            <h1 class="card-title pricing-card-title"> € <?=$column['produitPrix']; ?></h1>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title"><strong><?=$column['produitName']; ?></strong></h2>                        
                            <h4 class="card-text text-truncate"><?=$column['produitResume']; ?></h4>
                        </div>
                        <!-- /nom et description du produit -->

                        <!-- bouton pour ajouter le produit selectionne --> 
                            <a class ="btn btn-primary" href="/form_processing/cart_add_process.php?productId=<?=$column['produitId']; ?>&productPrice=<?=$column['produitPrix']; ?>">Ajouter au panier</a>
                        <!-- /bouton pour ajouter le produit selectionne --> 
                    </div>
                <?php
                } 
                // si la requete ne retourne rien
                } else {
                ?>
                    <!-- affiche un message pour dire qu il n y a pas encore de produits dans la base de donnees -->
                    <div class="my-3 w-100">                                                                       
                        <div class="mx-auto px-3 py-2 text-center info-message-bg">
                            <h2 class="card-title">Il n'y a aucune produit à afficher pour le moment !</h2>
                        </div>
                    </div> 
                    <!-- /affiche un message pour dire qu il n y a pas encore de produits dans la base de donnees -->
                <?php
                }
                ?>
            <!----------------------------------------------------------------------------
                    /debut script php pour recuperer tous les produits
            -----------------------------------//----------------------------------------->             
            </div>         
        </div>        
         <!----------------------------------------------------------------------------------------
                            /debut du container pour afficher la liste des produits
        -----------------------------------------//------------------------------------------------->   
<!------------------------------------------>
    <?=var_dump($_SESSION) ?>
<!------------------------------------------>
        <!-- import scripts -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
			integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
			crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
			integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
			crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
			integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
			crossorigin="anonymous"></script>
		<!-- /import scripts -->
	</body>
</html>
