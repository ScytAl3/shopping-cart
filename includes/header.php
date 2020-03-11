<!-- main Navigation -->
<!-- si l utilisateur est un admin bg color : red, sinon  color : dark  -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top <?=($_SESSION['current']['userRole'] == 'Admin') ?  'bg-dark' :  'bg-danger'; ?>">
    <div class="container">
        <!-- navbar brand & logo -->
        <a class="navbar-brand text-uppercase" href="/index.php">
        <img src="/img/header/octopus-logo.png" width="50" height="50" class="d-inline-block align-top" alt="nav logo">
        the drunken octopus
        </a>
        <!-- /navbar brand & logo -->
        <!-- collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <!-- /collapse button -->
        <!-- collapsible content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="nav-link" href="/index.php">Accueil <span class="sr-only">(current)</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="/shop.php">Beers <span class="sr-only"></span></a></li>
                <li class="nav-item active text-uppercase <?=($_SESSION['current']['userRole'] == 'Admin') ? 'visible ' : 'invisible ' ?>"><a class="nav-link" href="/admin/admin_products.php">God mod</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active <?=($_SESSION['current']['login']) ? 'visible' : 'invisible' ?>"><a class="nav-link" href="#"><?=$_SESSION['current']['userName'] ?></a></li>
                <li class="nav-item active <?=($_SESSION['current']['login']) ? 'invisible' : 'visible' ?>"><a class="nav-link" href="/sign_up.php"><i class="fa fa-user" aria-hidden="true"></i> Sign Up</a></li>
                <li class="nav-item active"><a class="nav-link" href="<?=($_SESSION['current']['login']) ? '/logout.php' : '/login.php' ?>"><i class="fa <?=($_SESSION['current']['login']) ? 'fa-sign-out' : 'fa-sign-in' ?>" aria-hidden="true"></i> <?=($_SESSION['current']['login']) ? 'Logout' : 'Login' ?></a></li>
            </ul>
            <!-- affiche un lien vers le panier avec le nombre de produits ajoutes -->
            <a class="btn btn-outline-success my-2 my-sm-0" href="/panier.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <strong><?=$max=sizeof($_SESSION['panier']['id_product']) ?></strong> item(s) in your cart</a>
        </div>
        <!-- collapsible content -->
    </div>
</nav>
<!-- header avec une image pleine en background centree verticalement -->
<header class="my-header-bg">
    <div class="row mx-auto">
        <div class="col-5 d-none d-lg-block line px-0"><hr></div>
        <div class="col-2 logo mx-auto px-0">
            <img src="/img/header/octopus-logo.svg" width="100" height="100" class="d-inline-block align-top" alt="header logo">
        </div>
        <div class="col-5 d-none d-lg-block line px-0"><hr></div>
    </div>
    <div class="container h-100">
        <div class="row h-75 align-items-center">
            <div class="col-12">
                <h1 class="display-4 font-weight-normal quote-text">"Work is the curse of the drinking classes."</h1>
                <p class="lead text-right quote-text">― Oscar Wilde</p>
            </div>
        </div>
    </div>
</header>
<!-- /header avec une image pleine en background centree verticalement -->
<!-- /main Navigation -->