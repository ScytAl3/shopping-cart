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
        <div class="mt-5 container">
            <!-- titre de la page de presentation des produits & messages divers -->
            <div class="my-3 p-3 text-center">
                <h1 class="display-4 font-weight-bold text-muted mb-5">Presentation</h1>
                <blockquote class="blockquote">
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Elicerem ex te cogeremque, ut responderes, nisi vererer ne Herculem ipsum ea, quae pro salute gentium summo labore gessisset, voluptatis causa gessisse diceres. Sed tu, ut dignum est tua erga me et philosophiam voluntate ab adolescentulo suscepta, fac ut Metrodori tueare liberos. Erit enim mecum, si tecum erit. Bonum ipsum etiam quid esset, fortasse, si opus fuisset, definisses aut quod esset natura adpetendum aut quod prodesset aut quod iuvaret aut quod liberet modo. Cognitis autem rerum finibus, cum intellegitur, quid sit et bonorum extremum et malorum, inventa vitae via est conformatioque omnium officiorum, cum quaeritur, quo quodque referatur; Duo Reges: constructio interrete. Bonum ipsum etiam quid esset, fortasse, si opus fuisset, definisses aut quod esset natura adpetendum aut quod prodesset aut quod iuvaret aut quod liberet modo. Obsequar igitur voluntati tuae dicamque, si potero, rhetorice, sed hac rhetorica philosophorum, non nostra illa forensi, quam necesse est, cum populariter loquatur, esse interdum paulo hebetiorem.</p>

                    <p class="text-justify">Itaque prima illa commendatio, quae a natura nostri facta est nobis, incerta et obscura est, primusque appetitus ille animi tantum agit, ut salvi atque integri esse possimus. Quid enim dicis omne animal, simul atque sit ortum, applicatum esse ad se diligendum esseque in se conservando occupatum? Sic, quod est extremum omnium appetendorum atque ductum a prima commendatione naturae, multis gradibus adscendit, ut ad summum perveniret, quod cumulatur ex integritate corporis et ex mentis ratione perfecta. Sed tamen omne, quod de re bona dilucide dicitur, mihi praeclare dici videtur. Sed quid minus probandum quam esse aliquem beatum nec satis beatum? -delector enim, quamquam te non possum, ut ais, corrumpere, delector, inquam, et familia vestra et nomine.</p>

                    <p class="text-justify">Dicis eadem omnia et bona et mala, quae quidem dicunt ii, qui numquam philosophum pictum, ut dicitur, viderunt: valitudinem, vires, staturam, formam, integritatem unguiculorum omnium bona, deformitatem, morbum, debilitatem mala. Si scieris, inquit Carneades, aspidem occulte latere uspiam, et velle aliquem inprudentem super eam assidere, cuius mors tibi emolumentum futura sit, improbe feceris, nisi monueris ne assidat, sed inpunite tamen; Nec enim, cum tua causa cui commodes, beneficium illud habendum est, sed faeneratio, nec gratia deberi videtur ei, qui sua causa commodaverit. Non enim in ipsa sapientia positum est beatum esse, sed in iis rebus, quas sapientia comparat ad voluptatem. De maximma autem re eodem modo, divina mente atque natura mundum universum et eius maxima partis administrari. Facit enim ille duo seiuncta ultima bonorum, quae ut essent vera, coniungi debuerunt; Nihil enim arbitror esse magna laude dignum, quod te praetermissurum credam aut mortis aut doloris metu. Si sapiens, ne tum quidem miser, cum ab Oroete, praetore Darei, in crucem actus est. Principiis autem a natura datis amplitudines quaedam bonorum excitabantur partim profectae a contemplatione rerum occultiorum, quod erat insitus menti cognitionis amor, e quo etiam rationis explicandae disserendique cupiditas consequebatur; Quo modo autem philosophus loquitur?</p>                    
                </blockquote>
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
