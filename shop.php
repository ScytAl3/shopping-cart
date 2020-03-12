<?php
// on démarre la session
session_start ();
// import du script pdo des fonctions qui accedent a la base de donnees
require 'pdo/pdo_db_functions.php';
// ----------------------------//---------------------------
//                      variables de session
// ---------------------------------------------------------
//----------------------------//----------------------------
//                              USER
// nom de la page en cours
$_SESSION['current']['page'] = 'shop';
//                              USER
//----------------------------//----------------------------
//----------------------------//----------------------------
//                     ERROR MANAGEMENT
// on efface le message d erreur d une autre page
if ($_SESSION['current']['page'] != $_SESSION['error']['page']) {$_SESSION['error']['message'] = '';}
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
		<title>Gestion panier - Liste des produits</title>
		<meta name="author" content="Franck Jakubowski">
		<meta name="description" content="Un mini site de produits à ajouter à un panier.">
		<!--  favicons -->
        <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
        <link rel="manifest" href="/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
		<!-- bootstrap stylesheet -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- font awesome stylesheet -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<!-- default stylesheet -->
		<link href="css/global.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body>   
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <!--------------------------------------//------------------------------------------------
                                    container pour afficher la liste des produits
        ------------------------------------------------------------------------------------------>           
        <div class="mt-5 container-fluid"> 

            <!-- titre de la page de presentation des produits & messages divers -->
            <div class="my-3 p-3">
                <div class="text-center mx-auto">
                    <!-- message d information pour tester la connexion a la base de donnees -->
                    <div class="alert alert-info" role="alert">
                        <?php require 'pdo/pdo_db_connect.php'; 
                            // on instancie une connexion pour verifie s il n y a pas d erreurs avec les parametres de connexion
                            $pdo = my_pdo_connexxion();
                            if ($pdo) {
                                echo 'Connexion réussie à la base de données';
                            } else {
                                var_dump($pdo);
                            }
                        ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                            
                    </div>
                    <!-- /message d information pour tester la connexion a la base de donnees -->                   
                    
                    <h2 class="display-4 font-weight-bold">Liste des produits disponibles</h2>                       
                    <!-- area pour afficher un message d erreur -->
                    <div class="alert alert-danger <?=($_SESSION['error']['message'] != '') ? 'd-block' : 'd-none'; ?> text-center mt-5" role="alert">
                        <p class="lead mt-2"><span><?=$_SESSION['error']['message'] ?></span></p>
                    </div>
                    <!-- /area pour afficher un message d erreur lors du login -->
                </div>                
            </div>
            <!-- /titre de la page de presentation des produits & messages divers -->       
            
            <div class="row justify-content-around">
                <!---------------------------------//-----------------------------------------
                                    script php pour recuperer tous les produits
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
                <div class="col-8 col-sm-6- col-md-5 col-lg-3 col-xl-2 card border-secondary mx-1 mb-5 py-3">
                    <!-- photo du produit -->
                    <img class="card-img-top mx-auto" src="/img/product_pictures/<?=$productPicture ?>" alt="a product picture">
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
                //----------------------------------------------------------------------------
                //            /script php pour recuperer tous les produits
                //-----------------------------------//---------------------------------------- 
                // si la requete ne retourne rien
                } else {
                ?>
            </div> 
                <!-- affiche un message pour dire qu il n y a pas encore de produits dans la base de donnees -->
                <div class="my-3">                                                                       
                    <div class="mx-auto px-3 py-2 text-center info-message-bg">
                        <h2 class="card-title">Il n'y a aucun produit à afficher pour le moment !</h2>
                    </div>
                </div> 
                <!-- /affiche un message pour dire qu il n y a pas encore de produits dans la base de donnees -->
                <?php
                }
                ?>
                              
        </div>        
         <!----------------------------------------------------------------------------------------
                                /container pour afficher la liste des produits
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
