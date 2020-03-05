<!--Main Navigation-->
<!-- si l utilisateur n est pas logger color : blue, sinon  color : green  -->   
<nav class="navbar navbar-expand-lg navbar-dark navbar-fixed-top <?=($_SESSION['current_Role'] == 'Admin') ?  'bg-danger' :  'bg-secondary'; ?>">
    <a class="navbar-brand" href="/index.php">
        <img class="logo" src="/img/default/newsFeed.png" alt="News Feed Logo">
    </a>
    <div class="container">
        <div class="d-flex flex-column">
            <h1 class="align-self-center text-uppercase"><strong>Belgische Qualität</strong></h1>
            <div>
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="/index.php">Nos Produits <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active <?=($_SESSION['current_Role'] == 'Admin') ? 'visible ' : 'invisible ' ?>">
                        <a class="nav-link text-uppercase" href="/admin/admin_products.php">God Mod</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container align-self-end">
        <div class="col-md-auto ml-auto align-self-end">
            <!-- affiche un lien vers le panier avec le nombre de produits ajoute -->
            <a class="btn btn-primary my-2 my-sm-0 ml-1" href="/panier.php"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>&nbsp;Votre panier contient <strong><?=$max=sizeof($_SESSION['panier']['id_product']) ?></strong> article(s)</a>
        </div>
        <div class="d-flex ml-2">
            <div class="<?=($_SESSION['current_Session']) ? 'visible ' : 'invisible '; ?> align-self-end">
                <a class="my-2 my-sm-0 ml-1" href="/logout.php"><img src="/img/default/switch-off.png" alt="Logout" class="logout-button"></a>
            </div>
        </div>
    </div>
</nav>
<!-- header pleine avec une image en background centree verticalement -->
<header class="my-header-bg">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h1 class="display-4 font-weight-normal">“Work is the curse of the drinking classes.”</h1>
                <p class="lead  text-right">― Oscar Wilde</p>
            </div>
        </div>
    </div>
</header>
<!-- /header pleine avec une image en background centree verticalement -->
<!--Main Navigation-->