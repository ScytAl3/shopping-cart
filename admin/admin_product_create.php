<?php
// on démarre la session
session_start ();
// import du script pdo des fonctions qui accedent a la base de donnees
require '../pdo/pdo_db_functions.php';
// verification que l utilisateur ne passe pas par l URL pour acceder a la page admin, sinon redirection page login
if (isset($_SESSION['current']['login']) && ($_SESSION['current']['userRole'] != 'Admin')) {
    header('location: ../login.php');
}
// ----------------------------//---------------------------
//                      variables de session
// ---------------------------------------------------------
//----------------------------//----------------------------s
//                              USER
// nom de la page en cours
$_SESSION['current']['page'] = 'adminProductCreate';
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
    <head>
		<!-- default Meta -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin - Mise à jour d'un produit</title>
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
        <link href="../css/global.css" rel="stylesheet" type="text/css">
        <!-- page stylesheet -->
		<link href="../css/admin_product_edit.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="../css/header.css" rel="stylesheet" type="text/css">
        <link href="../css/footer.css" rel="stylesheet" type="text/css">
        <!-- font import -->
        <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet"> 
    </head>
</head>
<body>
    <!-- import du header -->
    <?php include '../includes/header.php'; ?>
    <!-- /import du header -->

    <div class="alert alert-info text-center" role="alert">
        CREATE - WORK IN PROGRESS
    </div>

    <!-- import du header -->
    <?php include '../includes/footer.php'; ?>
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