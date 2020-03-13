<?php
// on démarre la session
session_start ();
// import du script pdo des fonctions sur la database
require 'pdo/pdo_db_functions.php';
// verification que l utilisateur ne passe pas par l URL si le panier est vide
if (isset($_SESSION['panier']) && empty($_SESSION['panier']['id_product'])) {
    header('location: index.php');
}
// ----------------------------//---------------------------
//                  variables de session
// ---------------------------------------------------------
//----------------------------//----------------------------
//                              USER
// nom de la page en cours
$_SESSION['current']['page'] = 'panier';
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
		<title>Gestion panier - Panier en cours</title>
		<meta name="author" content="Franck Jakubowski">
		<meta name="description" content="Un mini site de produits à ajouter à un panier.">
		<!--  favicons -->      
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
        <link rel="manifest" href="/favicon/site.webmanifest">
        <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
		<!-- bootstrap stylesheet -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- font awesome stylesheet -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<!-- default stylesheet -->
        <link href="css/global.css" rel="stylesheet" type="text/css">
        <!-- current page stylesheet -->
		<link href="css/panier.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
        <link href="css/footer.css" rel="stylesheet" type="text/css">
        <!-- font import -->
        <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet"> 
    </head>    
    
	<body>   
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->

        <!--------------------------------------//------------------------------------------------
                                container pour afficher la page du panier
        ------------------------------------------------------------------------------------------>           
        <div class="mt-5 container"> 

            <div class="my-3 py-3">
                <div class="text-center mx-auto">                                  
                    <!-- titre de la page de presentation des produits -->
                    <h2 class="display-4 font-weight-bold">Votre panier</h2>                       
                    <!-- area pour afficher un message d erreur -->
                    <div class="alert alert-danger <?=($_SESSION['error']['message'] != '') ? 'd-block' : 'd-none'; ?> text-center mt-5" role="alert">
                        <p class="lead mt-2"><span><?=$_SESSION['error']['message'] ?></span></p>
                    </div>
                    <!-- /area pour afficher un message d erreur lors du login -->
                </div>
                <!-- /titre de la page de presentation des produits -->
            </div>           
            
            <?php
                // --------------------------------------------------------------------------------------
                //             fonction qui calcule le nombre total de produit dans le panier
                // --------------------------------------------------------------------------------------
                $quantiteTotale = quantite_produit_panier();
                // --------------------------------------------------------------------------------------
                //                          fonction qui calcule le montant total du panier
                // --------------------------------------------------------------------------------------
                $montantTotal = montant_panier();
                //  --------------------------------------------------//--------------------------------------------------
                //          script php pour recuperer toutes les informations des produits dans le panier
                //  ------------------------------------------------------------------------------------------------------
                // on compte le nombre de produits differents dans le panier 
                $productCount = count($_SESSION['panier']['id_product']);
                //
                //var_dump($productCount); die;
                //
                // on parcours chaque sous tableaux du panier pour recuperer les informations associees a un meme produit a chaque iteration 
                for ($i = 0; $i < $productCount; $i++) { 
                    // identifiant du produit dans le panier - iteration
                    $productId = $_SESSION['panier']['id_product'][$i];
                    // ----------------------------------------//----------------------------------------------
                    //                       fonction qui renvoie les informations du produit
                    $myProduct = productReader($productId);
                    // image du produit
                    $productPicture = $myProduct['picture'];
                    // nom du produit
                    $productName = $myProduct['produitName'];
                    // quantite en stock du produit
                    $productStock = $myProduct['produitQuantite'];                    
                    //                       fonction qui renvoie les informations du produit
                    // ----------------------------------------//----------------------------------------------
                    // quantite commandee dans la panier - iteration
                    $productQuantity = $_SESSION['panier']['qte_product'][$i];
                    // prix unitaire du produit - iteration
                    $productPrice = $_SESSION['panier']['prix'][$i];    
                    // calcul du prix total du produit en fonction de la quantite
                    $productTotalPrice =  $productPrice * $productQuantity;        
            ?>
                <!----------------------------------//---------------------------------------------
                                    section pour afficher les produits du panier
                ---------------------------------------------------------------------------------->               
                <div class="row card-header text-white bg-info mb-3">
                    <!-- photo produit -->
                    <div class="mx-auto">
                        <img class="min-picture" src="/img/product_pictures/<?=(is_null($productPicture)) ? 'empty_picture.jpg' : $productPicture ?>" alt="Photo du produit">         
                    </div>
                    <!-- /photo produit -->

                    <!-- nom produit -->
                    <div class="col-md align-self-center text-center">
                        <h2 class="card-title"><strong><?=$productName ?></strong></h2>
                    </div>
                    <!-- /nom produit -->

                    <!-- selection quantite -->
                    <form class="form-row mx-auto" action="/form_processing/cart_quantity_process.php" method="POST">
                        <div class="form-group mr-3">
                            <label class="col-form-label mr-1" for="quantity">Quantity</label>                        
                            <input class="form-control " type="number" name="quantity" id="quantity" min="1" max="<?=$productStock ?>" value="<?=$productQuantity ?>"  style="text-align:center;">
                        </div>
                        <!--------------------------------------------------//--------------------------------------------------------
                                    passage de parametre cache pour le traitement de la modification de la quantite     -->
                        <input type="hidden" id="produitId" name="produitId" value="<?=$productId ?>">
                        <!-- parametre pour le message qui sera retourne par la page cart_quantity_process.php -->
                        <input type="hidden" id="produitNom" name="produitNom" value="<?=$productName ?>">
                        <!--        passage de parametre cache pour le traitement de la modification de la quantite     
                        ----------------------------------------------------//-------------------------------------------------------->                    
                        <!-- boutons pour modifier la quantite d un produit du panier -->
                        <button class ="btn btn-primary align-self-center" type="submit"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                        <!-- /boutons pour modifier la quantite d un produit du panier -->                    
                    </form>
                    <!-- /selection quantite -->

                    <!-- prix du produit -->
                    <div  class="col-md align-self-center mx-auto">
                        <h2 class="text-center"><?=$productTotalPrice ?> €</h2>
                    </div>
                    <!-- /prix du produit --> 

                    <!-- boutons pour supprimer un produit du panier -->
                    <div  class="align-self-center mx-auto">
                        <a class ="btn btn-danger" href="/form_processing/cart_delete_process.php?productId=<?=$productId ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </div>
                    <!-- /boutons pour supprimer un produit du panier -->                                           
                </div>
                <!--------------------------------------------------------------------------------
                                    /section pour afficher les produits du panier
                ---------------------------------------//------------------------------------------->
                <?php
                }
                //  -------------------------------------------------------------------------------------------------------
                //          /script php pour recuperer toutes les informations des produits dans le panier
                //  ------------------------------------------------//------------------------------------------------------
                ?>
                <!-------------------------------------------------------------------------------------
                        section pour afficher le montant total du panier dynamiquement
                ----------------------------------------//--------------------------------------------->
                <div class="row mb-3"> 
                    <div class="card ml-auto" style="width: 18rem;">
                        <div class="card-header">Nombre de produit :
                        </div>
                        <div class="card-body text-right">
                            <p class="card-text"><?=$quantiteTotale ?></p>
                        </div>                        
                        <div class="card-header">Total du panier :
                        </div>
                        <div class="card-body text-right">
                            <p class="card-text">€ <?=$montantTotal ?></p>
                        </div>
                    </div>
                </div>
                <!-------------------------------------------------------------------------------------
                        /section pour afficher le montant total du panier dynamiquement
                ----------------------------------------//--------------------------------------------->

                <!-- bouton pour valider le panier --> 
                <div class="row">                
                    <a type="submit" class="btn btn-success btn-lg btn-block" href="/form_processing/cart_checkout_process.php">Valider panier</a>
                </div>
                <!-- /bouton pour valider le panier --> 
                              
        </div>        
         <!----------------------------------------------------------------------------------------
                            /container pour afficher la page du panier
        -----------------------------------------//------------------------------------------------->   
        
        <!-- import du header -->
        <?php include 'includes/footer.php'; ?>
        <!-- /import du header -->
<!------------------------------------------>
    <!--?=var_dump($_SESSION) ?-->
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
