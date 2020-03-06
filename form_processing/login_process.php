<!-- php treatment -->
<?php
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php';
    // on demarre notre session 
    session_start ();

    // si le formulaire a ete envoye on verifie si les variables existes
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // on appelle la fonction qui verifie si un utilisateur avec ce pseudo existe
        $whereEmail = 'userEmail';
        $emailValid = userExist($whereEmail, $_POST['email']);
        //
        //var_dump($emailValid); die;
        //
        // ---------------------------------------------------------------------------------
        //                                       si  - email valid
        // ---------------------------------------------------------------------------------
        if ($emailValid) { 
            // on appelle la fonction qui verifie le mot de passe saisi avec celui chiffre dans la base de donnees 
            $testPwd = validPassword($_POST['password'], $emailValid);
            //
            //var_dump($testPwd); die;
            //
            // ---------------------------------------------------------------------------------
            //                                  si  - password valid
            // ---------------------------------------------------------------------------------
            if ($testPwd) {
                // on enregistre comme variables de session userName - le nom et le prenom concatene        
                $firstName = $emailValid['userFirstName'];
                $lastName = $emailValid['userLastName'];
                $_SESSION['current']['userName'] = $firstName.' '.$lastName;
                // on enregistre comme variables de session - le role 
                $_SESSION['current']['userRole'] = $emailValid['userRole']; 
                // on stocke l identifiant temporaire pour verifier si l utilisateur a cree un panier avant de s authentifier ou de creer un compte
                // ****************************************************************************
                //                              TODO check si panier avec id userTemp
                // ****************************************************************************
                $userTemp = $_SESSION['current']['userId'];
                // ****************************************************************************
                //                              TODO check si panier avec id userTemp
                // ****************************************************************************
                // on enregistre comme variables de session - le numero d identifiant
                $_SESSION['current']['userId'] = $emailValid['userId'];                
                // on creer une variable de session login en cours
                $_SESSION['current']['login'] = true; 
                // ---------------------------------------------------------------------------------
                //                               redirection suivant le role
                // ---------------------------------------------------------------------------------
                // si role admin
                if ($emailValid['userRole'] == 'Admin') {
                    // on  redirige vers la page d administration des produits
                    header('location: /../admin/admin_products.php');
                    exit();
                } else {
                    // on  redirige vers la page en cours avant le login
                    header('location: /../index.php');
                    exit();
                }
            // ---------------------------------------------------------------------------------
            //                                  sinon  - password invalid
            // ---------------------------------------------------------------------------------
            } else {
                // on renvoie un message d erreur (mot de passe non valide)
                $_SESSION['error']['page'] = 'login';
                $_SESSION['error']['message'] = "Erreur de connexion, veuillez vérifier vos identifiants de connexion";
                // on redirige vers la page de login
                header('location:/../login.php');
                exit();
            }   
        // ---------------------------------------------------------------------------------
        //                                       sinon  - email invalid
        // ---------------------------------------------------------------------------------  
        } else {            
            // on renvoie un message d erreur (email n existe pas dans la table)
            $_SESSION['error']['page'] = 'login';
            $_SESSION['error']['message'] = "Erreur de connexion, veuillez vérifier vos identifiants de connexion";
            // on redirige vers la page de login
            header('location:/../login.php');
            exit();
        }
    }
?>