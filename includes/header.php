<!--Main Navigation-->
<!-- affichage du pseudo du membre connecte et un bouton pour la deconnexion vers la page index.php -->
<header>
    <!-- si l utilisateur n est pas logger color : blue, sinon  color : green  -->   
    <nav class="navbar navbar-expand-md navbar-dark static-top <?=($_SESSION['current_Role'] == 'Admin') ?  'bg-danger' :  'bg-success'; ?>">
        <a class="navbar-brand" href="/index.php">
            <img class="logo" src="/img/default/newsFeed.png" alt="News Feed Logo">
        </a>
        <div class="container">
            <div class="d-flex flex-column">
                <h1 class="align-self-center"><strong>MY BEAUTIFUL SHOP</strong></h1>
                <div>
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="/index.php">Nos Produits <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active <?=($_SESSION['current_Role'] == 'Admin') ? 'visible ' : 'invisible ' ?>">
                            <a class="nav-link" href="/admin_page/admin_news.php">Administration</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container align-self-end">
            <div class="col-md-auto ml-auto align-self-end">
                <!-- affiche un lien vers le panier avec le nombre de produits ajoute -->
                <a class="my-2 my-sm-0 ml-1" href="/panier.php"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>&nbsp;Votre panier contient <?=$max=sizeof($_SESSION['panier']['id_product']) ?> article(s)</a>
            </div>
            <div class="d-flex ml-2">
                <div class="<?=($_SESSION['current_Session']) ? 'visible ' : 'invisible '; ?> align-self-end">
                    <a class="my-2 my-sm-0 ml-1" href="/logout.php"><img src="/img/default/switch-off.png" alt="Logout" class="logout-button"></a>
                </div>
            </div>
        </div>
    </nav>
</header>
<!-- /affichage du pseudo du membre connecte et un bouton pour la deconnexion vers la page index.php -->
<!--Main Navigation-->