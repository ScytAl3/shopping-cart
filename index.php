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
// on verifie l existence du tableau des informations de session, sinon on le cree
if (!isset($_SESSION['current'])) {
    // initialisation du tableau 
    $_SESSION['current'] = array();
    $_SESSION['current']['page'] = '';
    $_SESSION['current']['login'] = false;
    $_SESSION['current']['userId'] = time();
    $_SESSION['current']['userName'] = '';
    $_SESSION['current']['userRole'] = 'Visitor';
}
// nom de la page en cours
$_SESSION['current']['page'] = 'index';
//                              USER
//----------------------------//----------------------------
//----------------------------//----------------------------
//                     ERROR MANAGEMENT
// on verifie l existence du tableau d erreur, sinon on le cree
if (!isset($_SESSION['error'])) {
    // initialisation du tableau 
    $_SESSION['error'] = array();
    $_SESSION['error']['page'] = '';
    $_SESSION['error']['message'] = '';
}
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
		<!-- 
            favicons
         -->
		<!-- bootstrap stylesheet -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- font awesome stylesheet -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<!-- default stylesheet -->
        <link href="css/global.css" rel="stylesheet" type="text/css">
        <!-- page stylesheet -->
		<link href="css/index.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body>   
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <!--------------------------------------//------------------------------------------------
                            container pour afficher la presentation du site
        ------------------------------------------------------------------------------------------>           
        <!-- titre de la page de presentation -->
        <div class="my-3 p-3 text-center">
            <h1 class="display-4 font-weight-bold text-muted mb-5">Présentation</h1> 
        </div>
        <!-- /titre de la page de presentation -->
        <div class="bgimg-1 parallax">
            <div class="caption">
                <span class="border">LOREM CAPTION</span>
            </div>
        </div>
        <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;">Lorem ipsum</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit expedita, laborum accusamus optio ex quas. Modi dolores, fuga blanditiis corrupti quam laudantium delectus velit ducimus eos? Maxime cupiditate laborum cumque? Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur perferendis, sit quas rerum ipsum corporis quod tenetur magni mollitia veniam, rem quo fugiat cupiditate, exercitationem quisquam. Quo dolorum mollitia cumque. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugit sed quidem odio accusamus error debitis consequuntur quam harum, recusandae dolorum expedita quo dolore laboriosam veniam culpa. Quia nam quasi labore?</p>
        </div>
        <div class="bgimg-2 parallax">
            <div class="caption">
                <span class="border" style="background-color:transparent;font-size:25px;color: #f7f7f7;">LOREM CAPTION</span>
            </div>
        </div>
        <div style="position:relative;">
            <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur nihil fuga molestiae atque adipisci. Id adipisci cupiditate aliquam impedit vel quae harum optio explicabo qui blanditiis! Perspiciatis porro excepturi laborum. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus qui voluptate ipsa veniam perferendis quo eveniet sed quidem exercitationem minima perspiciatis ad possimus ut odio, cupiditate porro, a repellendus dolor.</p>
            </div>
        </div>
        <div class="bgimg-3 parallax">
            <div class="caption">
                <span class="border" style="background-color:transparent;font-size:25px;color: #f7f7f7;">LOREM CAPTION</span>
            </div>
        </div>
        <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;">Lorem ipsum</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit expedita, laborum accusamus optio ex quas. Modi dolores, fuga blanditiis corrupti quam laudantium delectus velit ducimus eos? Maxime cupiditate laborum cumque? Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur perferendis, sit quas rerum ipsum corporis quod tenetur magni mollitia veniam, rem quo fugiat cupiditate, exercitationem quisquam. Quo dolorum mollitia cumque. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugit sed quidem odio accusamus error debitis consequuntur quam harum, recusandae dolorum expedita quo dolore laboriosam veniam culpa. Quia nam quasi labore?</p>
        </div>
        <div class="bgimg-4 parallax">
            <div class="caption">
                <span class="border" style="background-color:transparent;font-size:25px;color: #f7f7f7;">LOREM CAPTION</span>
            </div>
        </div>
        <div style="position:relative;">
            <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur nihil fuga molestiae atque adipisci. Id adipisci cupiditate aliquam impedit vel quae harum optio explicabo qui blanditiis! Perspiciatis porro excepturi laborum. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus qui voluptate ipsa veniam perferendis quo eveniet sed quidem exercitationem minima perspiciatis ad possimus ut odio, cupiditate porro, a repellendus dolor.</p>
            </div>
        </div>
        <div class="bgimg-1 parallax">
            <div class="caption">
                <span class="border">END !!!</span>
            </div>
        </div>
         <!----------------------------------------------------------------------------------------
                            /container pour afficher la presentation du site
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
