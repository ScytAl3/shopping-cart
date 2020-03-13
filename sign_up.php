<?php
// on démarre la session
session_start ();
// ----------------------------//---------------------------
//                  variables de session
// ---------------------------------------------------------
//----------------------------//----------------------------
//                              USER
// nom de la page en cours
$_SESSION['current']['page'] = 'sign_up';
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
		<title>Gestion panier - Inscription</title>
		<meta name="author" content="Franck Jakubowski">
		<meta name="description" content="Un mini site d'actualités consultable par tous les membres mais ou seul un admin est autorisé à poster.">
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
		
        <!-----------------------------------//-----------------------------------------
                 	debut du container global du formulaire d inscription
        -------------------------------------------------------------------------------->
        <div class="d-md-flex flex-md-equal w-100 my-5 pl-md-3 justify-content-center">						            
            <div class="mr-md-3 px-md-5 col-md-8 bg-info">  

				<!-- titre de la section du formulaire -->              
				<div class="py-2 text-center">
					<h1><strong>INSCRIPTION</strong></h1>
					<!-- area pour afficher un message d erreur lors de la creation -->
					<div class="alert alert-danger <?=($_SESSION['error']['message'] != '') ? 'd-block' : 'd-none'; ?> text-center mt-5" role="alert">
						<p class="lead mt-2"><span><?=$_SESSION['error']['message'] ?></span></p>
					</div>
					<!-- /area pour afficher un message d erreur lors de la creation -->
					<!-- logo du site -->
					<div class="text-center mt-3">
						<img class="d-inline-block align-top mb-4" src="/img/default/octopus-logo-form.png" alt="site logo" width="100" height="100">
					</div>
					<!-- logo du site -->
				</div>
                <!-- /titre de la section du formulaire -->

				<!----------------------------------------//--------------------------------------------------
													debut du formulaire d inscription
                ---------------------------------------------------------------------------------------------->
				<form class="form-inscription" action="form_processing/signup_process.php" method="POST" enctype="multipart/form-data">					
                    <!-- nom -->
					<div class="mb-4">
						<label for="lastName">Nom</label>
						<input class="form-control" name="lastName" id="lastName" type="text" required pattern="^[A-Za-z -]{1,75}$">
                    </div>	
                    		
					<!-- prenom -->
					<div class="mb-4">
						<label for="firstName">Prénom</label>
						<input class="form-control" name="firstName" id="firstName" type="text" required pattern="^[A-Za-z -]{1,75}$">
                    </div>		
                    
					<!-- email -->
					<div class="mb-4">
						<label for="email">Courriel</label>
						<input class="form-control" type="email" name="email" id="email"
							placeholder="utilisateur@domaine.fr" required
							pattern="^[\w!#$%&'*+/=?`{|}~^-]+(?:\.[\w!#$%&'*+/=?`{|}~^-]+)*@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,6}$">
					</div>

					<!-- Mot de passe -->
					<div class="mb-4">
						<label for="pwd1">Mot de passe</label>
						<input class="form-control" name="password" id="password" type="password" required>
					</div>
					<!-- Mot de passe confirmation -->
					<div class="mb-4">
						<label for="pwd2">Mot de passe <span class="text-muted">(confirmation)</span>
						</label>
						<input class="form-control" name="confirm_password" id="confirm_password"
							type="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
					</div>
							
					<hr class="my-4">

					<!-- buttons area -->
					<div class="container mb-3">
						<div class="row justify-content-center">
							<!-- submit button -->
							<div class="col-md-4 mb-3">
								<button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
							</div>
							<!-- reset button -->
							<div class="col-md-4 mb-3">
								<button class="btn btn-primary btn-lg btn-block" type="reset">Reset</button>
							</div>
						</div>
					</div>
					<!-- /buttons area -->
				</form>
				<!--------------------------------------------------------------------------------------------
                                            		/debut du formulaire d inscription
                -------------------------------------------//--------------------------------------------------->
            </div>
        </div>
        <!------------------------------------------------------------------------------
                 	/debut du container global du formulaire d inscription
		-------------------------------------//----------------------------------------->
		
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
