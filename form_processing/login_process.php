<!-- php treatment -->
<?php
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php';
    // on demarre notre session 
    session_start ();

    // si le formulaire a ete envoye on verifie si les variables existes
    if (isset($_POST['email']) && isset($_POST['password']))  {
        // on appelle la fonction qui verifie si un utilisateur avec ce pseudo existe
        $wherePseudo = 'userEmail';
        $emailValid = userExist($wherePseudo, $_POST['email']);
        //
        //var_dump($emailValid); die;
        //
        // si la fonction a retournee un utilisateur
        if ($emailValid) { 
            // on appelle la fonction qui verifie le mot de passe saisi avec celui chiffre dans la base de donnees 
            $testPwd = validPassword($_POST['password'], $emailValid);
            //
            //var_dump($testPwd); die;
            //
            // si le mot de passe saisi est correct
            if ($testPwd) {
                // on enregistre comme variables de session - le nom et le prenom           
                $_SESSION['current_FirstName'] = $emailValid['userFirstName'];
                $_SESSION['current_LastName'] = $emailValid['userLastName'];
                // on enregistre comme variables de session - le role 
                $_SESSION['current_Role'] = $emailValid['userRole']; 
                // on enregistre comme variables de session - le numero d identifiant
                $_SESSION['current_Id'] = $emailValid['userId'];                
                // on creer une variable de session login en cours
                $_SESSION['current_Session'] = true;                
                // on détruit les variables d erreur de login de notre session
                unset ($_SESSION['error']);  
                // suivant le role on redirige vers des pages differentes
                if ($emailValid['userRole'] == 'Admin') {
                    // on  redirige vers la page d administration des produits
                    header('location: /../admin/admin_products.php');
                    exit();
                }
                // on  redirige vers la page d accueil
                header('location: /../index.php');  
                exit(); 
            } else {
                // on renvoie un message d erreur (mot de passe non valide)
                $_SESSION['error']['page'] = 'login';
                $_SESSION['error']['show'] = true;
                $_SESSION['error']['message'] = "Erreur de connexion, veuillez vérifier vos identifiants de connexion";
                // on redirige vers la page index.php
                header('location:/../index.php');
                exit();
            }        
        // sinon pas trouve de correspondance email dans la base        
        } else {            
            // on renvoie un message d erreur (pseudo n existe pas dans la table)
            $_SESSION['error']['page'] = 'login';
            $_SESSION['error']['show'] = true;
            $_SESSION['error']['message'] = "Erreur de connexion, veuillez vérifier vos identifiants de connexion";
            // on redirige vers la page index.php
            header('location:/../index.php');
            exit();
        }
    }
?>