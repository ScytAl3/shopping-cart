<!-- php treatment -->
<?php
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php';
    // on demarre une session la session
    session_start(); 

    // si le formulaire a ete envoyer les variables existes
    if (isset( $_POST['lastName'], $_POST['firstName'], $_POST['email'], $_POST['password']))  {      
        // on creer un array de session avec les champs envoyes pour ne pas avoir a les ressaisir si il y a une erreur dans le formulaire
        $_SESSION['signupForm']['inputLastName'] = $_POST['lastName'];
        $_SESSION['signupForm']['inputFirstName'] = $_POST['firstName'];
        $_SESSION['signupForm']['inputMail'] = $_POST['email']; 
        // -------------------------------------------------------------------------------------------------
        //                      on verifie l existence d un utilisateur - condition email
        // -------------------------------------------------------------------------------------------------
        $whereEmail = 'userEmail';
        $emailTest = userExist($whereEmail, $_POST['email']); 
        //
        //var_dump($emailTest); die;
        //
        // ---------------------------------------------------------------------------------
        //                                       si  - email exist
        // ---------------------------------------------------------------------------------
        if ($emailTest) { 
            // on renvoie une message d erreur (email unique)
            $_SESSION['error']['page'] = 'sign_up';
            $_SESSION['error']['message'] = "Cette adresse mail est déjà associée à un compte !";                                  
            // on redirige vers la page du formulaire d inscription
            header('location:/../sign_up.php');
            exit;
        }
        // -----------------------------------------------------------------------------------------------
        //          on creer le Salt et le mot de passe chiffre associes a ce nouveau membre
        // -----------------------------------------------------------------------------------------------
        // creation du Salt
        $userSalt = generateSalt(10);
        // creation du mot de passe associe au Salt
        $userEncryptPwd = CreateEncryptedPassword($userSalt, $_POST['password']);
        // on recupere les informations saisies et le mot de passe chiffre dans un tableau       
        $userData = [             
            $_POST['lastName'],
            $_POST['firstName'], 
            $_POST['email'], 
            $userEncryptPwd,
            $userSalt,
        ];
        // ---------------------------------------------------------------------------
        //                                  on creer l utilisateur
        // ---------------------------------------------------------------------------
        $newUser = createUser($userData);
        // ---------------------------------------------------------------------------------
        //                   si  - enregistrement s est bien deroule = new id
        // ---------------------------------------------------------------------------------
        if ($newUser > 0) {
            // on stocke l identifiant temporaire pour verifier si l utilisateur a cree un panier avant de s authentifier ou de creer un compte
            // ****************************************************************************
            //                              TODO check si panier avec id userTemp
            // ****************************************************************************
            $userTemp = $_SESSION['current']['userId'];
            // ****************************************************************************
            //                              TODO check si panier avec id userTemp
            // ****************************************************************************
             // on enregistre comme variables de session userName - le nom et le prenom concatene        
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $_SESSION['current']['userName'] = $firstName.' '.$lastName;
            // on enregistre comme variables de session - le role 
            $_SESSION['current']['userRole'] = 'Member'; 
            // on enregistre comme variables de session - le numero d identifiant
            $_SESSION['current']['userId'] = $newUser;                
            // on creer une variable de session login en cours
            $_SESSION['current']['login'] = true; 
            // on supprime ltableau
            /// ---------------------------------------------------------------------------------
            //          redirection - suppression tableau des informations de saisies
            // ---------------------------------------------------------------------------------
            session_unset($_SESSION['signupForm']);
            // on  redirige vers index
            header('location: /../index.php');
            exit();
        // ---------------------------------------------------------------------------------
        //                      sinon  - newUser = FALSE
        // --------------------------------------------------------------------------------- 
        } else {
            // on renvoie un message d erreur
            $_SESSION['error']['page'] = 'sign_up';
            $_SESSION['error']['message'] = "Problème lors de la création de votre compte !";
            // on redirige vers la page signup
            header('location:/../sign_up.php');
            exit();
        }  
    // ---------------------------------------------------------------------------------
    //                      sinon  - probleme avec $_POST
    // ---------------------------------------------------------------------------------           
    } else {
        // on renvoie un message d erreur
        $_SESSION['error']['page'] = 'sign_up';
        $_SESSION['error']['message'] = "Il y a eu un problème lors de l'envoi de votre formulaire !";
        // on redirige vers la page signup
        header('location:/../sign_up.php');
        exit();
    }
?>