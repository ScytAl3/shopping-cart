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
        <div class="mt-5 p-3 text-center">
            <h1 class="display-4 font-weight-bold">Présentation</h1> 
        </div>
        <div class="container text-light-bg">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit expedita, laborum accusamus optio ex quas. Modi dolores, fuga blanditiis corrupti quam laudantium delectus velit ducimus eos? Maxime cupiditate laborum cumque? Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur perferendis, sit quas rerum ipsum corporis quod tenetur magni mollitia veniam, rem quo fugiat cupiditate, exercitationem quisquam. Quo dolorum mollitia cumque. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugit sed quidem odio accusamus error debitis consequuntur quam harum, recusandae dolorum expedita quo dolore laboriosam veniam culpa. Quia nam quasi labore?</p>
        </div>
        <!-- /titre de la page de presentation -->
        <div class="bgimg-1 parallax">                
                <div class="caption">
                    <span class="border">LOREM CAPTION 1</span>
                </div>                
        </div>
        <div class="container text-light-bg">
            <h3 style="text-align:center;">Lorem ipsum</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit expedita, laborum accusamus optio ex quas. Modi dolores, fuga blanditiis corrupti quam laudantium delectus velit ducimus eos? Maxime cupiditate laborum cumque? Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur perferendis, sit quas rerum ipsum corporis quod tenetur magni mollitia veniam, rem quo fugiat cupiditate, exercitationem quisquam. Quo dolorum mollitia cumque. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugit sed quidem odio accusamus error debitis consequuntur quam harum, recusandae dolorum expedita quo dolore laboriosam veniam culpa. Quia nam quasi labore?</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Non autem hoc: igitur ne illud quidem. Inde igitur, inquit, ordiendum est. Vitiosum est enim in dividendo partem in genere numerare. Quae tamen a te agetur non melior, quam illae sunt, quas interdum optines. Nec vero sum nescius esse utilitatem in historia, non modo voluptatem. Cuius ad naturam apta ratio vera illa et summa lex a philosophis dicitur. Sit enim idem caecus, debilis. Duo Reges: constructio interrete. Nobis Heracleotes ille Dionysius flagitiose descivisse videtur a Stoicis propter oculorum dolorem. At enim hic etiam dolore. Quae fere omnia appellantur uno ingenii nomine, easque virtutes qui habent, ingeniosi vocantur. Habent enim et bene longam et satis litigiosam disputationem. </p>
        </div>        
        <div class="bgimg-2 parallax">
            <div class="caption">
                <span class="border" style="background-color:transparent;font-size:25px;color: #f7f7f7;">LOREM CAPTION 2</span>
            </div>
        </div>
        <div class="text-dark-bg">
            <div class="container">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur nihil fuga molestiae atque adipisci. Id adipisci cupiditate aliquam impedit vel quae harum optio explicabo qui blanditiis! Perspiciatis porro excepturi laborum. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus qui voluptate ipsa veniam perferendis quo eveniet sed quidem exercitationem minima perspiciatis ad possimus ut odio, cupiditate porro, a repellendus dolor.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Haec dicuntur inconstantissime. Aufert enim sensus actionemque tollit omnem. Tanta vis admonitionis inest in locis; Illa videamus, quae a te de amicitia dicta sunt. </p>
                <p>Tum mihi Piso: Quid ergo? Qui convenit? Nam quid possumus facere melius? Quod cum dixissent, ille contra. </p>
            </div>
        </div>
        <div class="bgimg-3 parallax">
            <div class="caption">
                <span class="border" style="background-color:transparent;font-size:25px;color: #f7f7f7;">LOREM CAPTION 3</span>
            </div>
        </div>
        <div class="container text-light-bg">
            <h3 style="text-align:center;">Lorem ipsum</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit expedita, laborum accusamus optio ex quas. Modi dolores, fuga blanditiis corrupti quam laudantium delectus velit ducimus eos? Maxime cupiditate laborum cumque? Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur perferendis, sit quas rerum ipsum corporis quod tenetur magni mollitia veniam, rem quo fugiat cupiditate, exercitationem quisquam. Quo dolorum mollitia cumque. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugit sed quidem odio accusamus error debitis consequuntur quam harum, recusandae dolorum expedita quo dolore laboriosam veniam culpa. Quia nam quasi labore?</p>
        </div>
        <div class="bgimg-4 parallax">
            <div class="container">
                <div class="row pt-5 pb-5">
                    <div class="col-md-4 py-2">
                        <div class="card border-light card-body" style="background-color:transparent;color: #f7f7f7;">
                            <h3>Nihilo magis.</h3>
                            <p>Vide, ne etiam menses! nisi forte eum dicis, qui, simul atque arripuit, interficit. Magni enim aestimabat pecuniam non modo non contra leges, sed etiam legibus partam. In motu et in statu corporis nihil inest, quod animadvertendum esse ipsa natura iudicet? Istam voluptatem perpetuam quis potest praestare sapienti? Quia nec honesto quic quam honestius nec turpi turpius. Praeclare Laelius, et recte sofñw, illudque vere: O Publi, o gurges, Galloni! es homo miser, inquit.</p>
                        </div>
                    </div>
                    <div class="col-md-4 py-2">
                        <div class="card border-light card-body" style="background-color:transparent;color: #f7f7f7;">
                            <h3>Nihil illinc huc pervenit.</h3>
                            <p>Quis Aristidem non mortuum diligit? De vacuitate doloris eadem sententia erit. Quid, si etiam iucunda memoria est praeteritorum malorum? Refert tamen, quo modo. Quis istud possit, inquit, negare? Quid de Pythagora? Id adipisci cupiditate aliquam impedit vel quae harum optio explicabo qui blanditiis! Perspiciatis porro excepturi laborum.</p>
                        </div>
                    </div>
                    <div class="col-md-4 py-2">
                        <div class="card border-light card-body" style="background-color:transparent;color: #f7f7f7;">
                            <h3>Quare attende, quaeso.</h3>
                            <p>Graccho, eius fere, aequalí? Cur deinde Metrodori liberos commendas? Compensabatur, inquit, cum summis doloribus laetitia. Illa tamen simplicia, vestra versuta. Paria sunt igitur. Modi dolores, fuga blanditiis corrupti quam laudantium delectus velit ducimus eos? Maxime cupiditate laborum cumque? Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-dark-bg">
           <div class="container">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur nihil fuga molestiae atque adipisci. Id adipisci cupiditate aliquam impedit vel quae harum optio explicabo qui blanditiis! Perspiciatis porro excepturi laborum. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus qui voluptate ipsa veniam perferendis quo eveniet sed quidem exercitationem minima perspiciatis ad possimus ut odio, cupiditate porro, a repellendus dolor.</p>
                <p>Sed nimis multa. Sed ad bona praeterita redeamus. Cur deinde Metrodori liberos commendas? Quid autem habent admirationis, cum prope accesseris? </p>
                <p>Non semper, inquam; Ita fit cum gravior, tum etiam splendidior oratio. Immo videri fortasse. Quare attende, quaeso. Quo tandem modo? </p>
            </div>
        </div>
        <div class="bgimg-1 parallax">
            <div class="caption">
                <span class="border">LOREM CAPTION FINAL</span>
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
