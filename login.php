<?php
// on démarre la session
session_start ();
// ----------------------------//---------------------------
//                  variables de session
// ---------------------------------------------------------
//----------------------------//----------------------------
//                              USER
// nom de la page en cours
$_SESSION['current']['page'] = 'login';
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
		<title>Gestion panier - login</title>
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
        <!-- current page stylesheet -->
		<link href="css/login.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body> 
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <!--------------------------------------//--------------------------------------------------
                        debut du container global pour le formulaire de login
        -------------------------------------------------------------------------------------------> 
        <div class="container">
            <div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3 justify-content-center">                        
                <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">                
                    <div class="my-3 p-3">                        

                        <!-- titre de la section du formulaire -->
                        <div class="text-center mx-auto">
                            <h2 class="display-4 font-weight-bold text-muted">Veuillez vous connecter</h2>                       
                            <!-- area pour afficher un message d erreur lors d un mauvais login : pseudo inexistant ou erreud password -->
                            <div class="alert alert-danger <?=($_SESSION['error']['message'] != '') ? 'd-block' : 'd-none'; ?> text-center mt-5" role="alert">
                                <p class="lead mt-2"><span><?=$_SESSION['error']['message'] ?></span></p>
                            </div>
                            <!-- /area pour afficher un message d erreur lors du login : pseudo inexistant ou erreud password -->
                            <!-- logo du site -->
                                <img class="mt-3" src="/img/default/octopus-logo-form.png" alt="site logo" width="100" height="100">
                            <!-- /logo du site --> 
                        </div>
                        <!-- /titre de la section du formulaire -->

                        <!----------------------------------------//--------------------------------------------------
                                                        debut du container du formulaire de login
                        ---------------------------------------------------------------------------------------------->
                        <div class="<?=($_SESSION['current']['login'])? 'invisible' : 'visible' ; ?>">
                            <form class="form-signin p-5" method="POST" action="form_processing/login_process.php">      
                                <!-- email input -->                          
                                <div class="input-group margin-bottom-sm">
                                    <input class="form-control fa fa-envelope" type="text" name="email" id="email" placeholder="&#xf0e0; Votre adresse email"  required autofocus="">
                                </div>

                                <!-- password input -->
                                <div class="input-group mb-3">
                                    <input class="form-control fa fa-key" type="password" name="password" id="password" placeholder="&#xf084; Password" required>
                                </div>

                                <!-- buttons -->
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">LOGIN</button>
                                    <a class="btn btn-primary btn-lg btn-block" name="signup" role="button" href="sign_up.php">SIGN UP</a>
                                </div>
                                <p class="mt-5 mb-3 text-muted">© 2019-2020</p>
                            </form>
                        </div>
                        <!--------------------------------------------------------------------------------------------
                                                           /debut du container formulaire de login
                        -------------------------------------------//--------------------------------------------------->
                    </div>            
                </div>                
            </div>
        </div>
        <!------------------------------------------------------------------------------------------
                    debut du container global pour le formulaire de login
        ----------------------------------------//--------------------------------------------------->   
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
