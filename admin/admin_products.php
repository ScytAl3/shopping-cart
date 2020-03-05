<?php
// on démarre la session
session_start ();
// import du script pdo des fonctions qui accedent a la base de donnees
require '../pdo/pdo_db_functions.php';
// verification que l utilisateur ne passe pas par l URL pour acceder a la page admin, sinon redirection page login
if (isset($_SESSION['current_Session']) && ($_SESSION['current_Role'] != 'Admin')) {
    header('location: ../login.php');
}
// ------
// ----------------------------//---------------------------
//                      variables de session
// ---------------------------------------------------------
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
$_SESSION['error']['page'] = (isset($_SESSION['error']['page'])) ? $_SESSION['error']['page'] : 'adminProduct';
$_SESSION['error']['show'] = ((isset($_SESSION['error']['show'])) && ($_SESSION['error']['page'] == 'adminProduct')) ? $_SESSION['error']['show'] : false;
$_SESSION['error']['message'] = ((isset($_SESSION['error']['message'])) && ($_SESSION['error']['page'] == 'adminProduct')) ? $_SESSION['error']['message'] :  '';
$_SESSION['error']['page'] = 'adminProduct';
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
		<title>Admin - Gestion des produits</title>
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
		<link href="../css/admin_products.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="../css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body>   
        <!-- import du header -->
        <?php include '../includes/header.php'; ?>
        <!-- /import du header -->
        <!--------------------------------------//------------------------------------------------
                        container pour afficher la liste des produits a administrer
        ------------------------------------------------------------------------------------------>           
        <div class="mt-5 container-fluid"> 
            <!-- titre de la page de presentation des produits & messages divers -->
            <div class="my-3 p-3">                
                <div class="text-center mx-auto">
                    <h2 class="display-4 font-weight-bold text-muted">Liste des produits</h2>                       
                    <!-- area pour afficher un message d erreur -->
                    <div class="show-bg<?=($_SESSION['error']['show']) ? '' : 'visible'; ?> text-center mt-5">
                        <p class="lead mt-2"><span><?=$_SESSION['error']['message'] ?></span></p>
                    </div>
                    <!-- /area pour afficher un message d erreur lors du login -->
                </div>                
            </div>
            <!-- /titre de la page de presentation des produits & messages divers -->
            
            <!-- bouton qui dirige vers le formulaire admin pour creer un produit -->
            <div class="my-5 mx-auto">
                <a class="btn btn-success btn-lg btn-block" href="/admin_page/admin_product_create.php">- Ajouter un produit -</a>
            </div> 
            <!-- /bouton qui dirige vers le formulaire admin pour creer unproduit -->
            
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
                ?>
                    <!-- affiche les informations pour chaque produit -->                     
                    <div class="card bg-light border-success mb-3 w-100">
                        <div class="card-body">  
                            <div class="row">                                   
                                <div class="col-8 ml-4 align-self-center">
                                    <h2 class="card-title"><strong><?=$column['produitName']; ?></strong></h2>
                                    <h4 class="card-text text-truncate"><?=$column['produitResume']; ?></h4>
                                </div>
                                <!-- boutons pour modifier ou supprimer un produit --> 
                                <div class="d-flex ml-auto align-self-center">
                                    <a class="btn btn-primary" href="admin_product_edit.php?productId=<?=$column['produitId'] ?>">Edit</a>
                                    <form method="post" action="/forms_processing/admin_product_delete_process.php" onsubmit=" return confirm('are you really sure')">
                                        <!-- passage de l identifiant du produit en hidden pour le traitement de la suppression -->
                                        <input name="productId" type="hidden" value="<?=$column['produitId']; ?>">
                                        <button class="btn btn-danger ml-1">Delete</button>
                                    </form>
                                </div>
                                <!-- /boutons pour modifier ou supprimer un produit --> 
                            </div>                            
                        </div>
                    </div>                 
                    <!-- /on recupere les informations pour chaque actualite --> 
                <?php
                } 
                // si la requete ne retourne rien
                } else {
                ?>
                    <!-- affiche un message pour dire qu il n y a pas encore de produits dans la base de donnees -->
                    <div class="my-3 w-100">                                                                       
                        <div class="mx-auto px-3 py-2 text-center info-message-bg">
                            <h2 class="card-title">Il n'y a aucun produit à afficher pour le moment !</h2>
                        </div>
                    </div> 
                    <!-- /affiche un message pour dire qu il n y a pas encore de produits dans la base de donnees -->
                <?php
                }
                ?>
                <!----------------------------------------------------------------------------
                                /script php pour recuperer tous les produits
                -----------------------------------//----------------------------------------->       
        </div>        
         <!----------------------------------------------------------------------------------------
                        /container pour afficher la liste des produits a administrer
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
