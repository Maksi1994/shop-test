<?php

use \App\Tools\Router;
use \App\Controllers\TemplateController;
use \App\Models\CategoryModel;
use \App\Models\CartModel;
use \App\Models\ProductModel;

// init routing
$routerParams = Router::getRouteInfo();
$categoryModel = new CategoryModel;
$cartModel = new CartModel();
$productModel = new ProductModel();

$data = Router::run();

// init menu
$categories = $categoryModel->getFormattedCategories();

// init cart
$basketValue = USER['auth'] ? $cartModel->getBasketData() : null;

if (!empty($basketValue)) {
    $basketProducts = [];

    $basketProducts['products'] = array_map(function ($product) {
        return $product['id'];
    }, $basketValue);

    $basketProducts['promotions'] = array_map(function ($product) {
        return $product['promotion'];
    }, array_filter($basketValue, function ($product) {
        return !empty($product['promotion']);
    }));

    $basket = array_map(function ($basketPosition, $product) use (&$fullPrice) {
        $product['count'] = $basketPosition['count'];
        $fullPrice += $product['count'] * ($product['newPrice'] ?? $product['price']);

        return $product;
    }, $basketValue, $productModel->getProductsByIds($basketProducts));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>E-SHOP HTML Template</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="/assets/styles/bootstrap.min.css"/>

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="/assets/styles/slick.css"/>
    <link type="text/css" rel="stylesheet" href="/assets/styles/slick-theme.css"/>

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="/assets/styles/nouislider.min.css"/>

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="/assets/styles/font-awesome.min.css">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="/assets/styles/style.css"/>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<body>
<!-- HEADER -->
<header>
    <!-- top Header -->

    <div id="top-header">
    </div>

    <!-- /top Header -->

    <!-- header -->
    <div id="header">
        <div class="container">
            <div class="pull-left">
                <!-- Logo -->
                <div class="header-logo">
                    <a class="logo" href="#">
                        <img src="./img/logo.png" alt="">
                    </a>
                </div>
                <!-- /Logo -->

                <!-- Search -->
                <!--
                <div class="header-search">
                    <form>
                        <input class="input search-input" type="text" placeholder="Enter your keyword">
                        <select class="input search-categories">
                            <option value="0">All Categories</option>
                            <option value="1">Category 01</option>
                            <option value="1">Category 02</option>
                        </select>
                        <button class="search-btn"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                -->
                <!-- /Search -->
            </div>
            <div class="pull-right">
                <ul class="header-btns">
                    <!-- Account -->
                    <li class="header-account dropdown default-dropdown">
                        <? if (!USER['auth']) { ?>
                            <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
                                <strong class="text-uppercase">Authentication</strong>
                            </div>
                            <a href="/users/getLoginForm" class="text-uppercase">Login</a> / <a
                                    href="/users/getRegistForm" class="text-uppercase">Join</a>
                        <? } else { ?>
                            <a href="/users/logout" class="text-uppercase">Logout</a>
                        <? } ?>
                    </li>
                    <!-- /Account -->

                    <!-- Cart -->
                    <li class="header-cart dropdown default-dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

                            <? if (USER['auth']) { ?>
                                <div class="header-btns-icon">
                                    <i class="fa fa-shopping-cart"></i>
                                    <? if (!empty($basket)) { ?>
                                        <span class="qty"><?= count($basket) ?></span>
                                    <? } ?>
                                </div>
                            <? } ?>
                        </a>
                        <? if (!empty($basket)) { ?>
                            <div class="custom-menu">
                                <div id="shopping-cart">

                                    <div class="shopping-cart-list">
                                        <? foreach ($basket as $index => $product) { ?>
                                            <div class="product product-widget">
                                                <div class="product-thumb">
                                                    <img src="/assets/images/products/<?= $product['photo'] ?>"" alt="">
                                                </div>
                                                <div class="product-body">
                                                    <h3 class="product-price">
                                                        $ <?= $product['newPrice'] ?? $product['price'] ?> <span
                                                                class="qty">x<?=$product['count']?></span></h3>
                                                    <h2 class="product-name"><a><?= $product['name'] ?></a></h2>
                                                </div>
                                            </div>

                                        <? } ?>
                                    </div>

                                    <div class="shopping-cart-btns">
                                        <a href="/cart/getCart">
                                            <button class="main-btn">View Cart</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </li>
                    <!-- /Cart -->

                    <!-- Mobile nav toggle-->
                    <li class="nav-toggle">
                        <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
                    </li>
                    <!-- / Mobile nav toggle -->
                </ul>
            </div>
        </div>
        <!-- header -->
    </div>
    <!-- container -->
</header>
<!-- /HEADER -->

<!-- NAVIGATION -->
<div id="navigation">
    <!-- container -->
    <div class="container">
        <div id="responsive-nav">
            <!-- category nav -->
            <? require_once 'App/Views/+shared/menu-categories.php' ?>
            <!-- /category nav -->

            <!-- menu nav -->
            <div class="menu-nav">
                <span class="menu-header">Menu <i class="fa fa-bars"></i></span>
                <ul class="menu-list">
                    <li><a href="/" class="<?= Router::isActive('/') ?>">Home</a></li>
                    <li><a href="/promotions/getAll/1">Promotions</a></li>
                </ul>
            </div>
            <!-- menu nav -->
        </div>
    </div>
    <!-- /container -->
</div>
<!-- /NAVIGATION -->

<?
// get view
TemplateController::setData($data);
TemplateController::view($routerParams);
?>

<!-- FOOTER -->
<footer id="footer" class="section-grey">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- footer widget -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <!-- footer logo -->
                    <div class="footer-logo">
                        <a class="logo" href="#">
                            <img src="/assets/img/logo.png" alt="">
                        </a>
                    </div>
                    <!-- /footer logo -->

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna</p>

                </div>
            </div>
            <!-- /footer widget -->

            <div class="clearfix visible-sm visible-xs"></div>

            <!-- footer subscribe -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <h3 class="footer-header">Stay Connected</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                    <form>
                        <div class="form-group">
                            <input class="input" placeholder="Enter Email Address">
                        </div>
                        <button class="primary-btn">Join Newslatter</button>
                    </form>
                </div>
            </div>
            <!-- /footer subscribe -->
        </div>
        <!-- /row -->
        <hr>
        <!-- row -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <!-- footer copyright -->
                <div class="footer-copyright"></div>
                <!-- /footer copyright -->
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</footer>
<!-- /FOOTER -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nstslider/1.0.13/jquery.nstSlider.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.7.21/jquery.zoom.min.js"></script>
<script src="js/main.js"></script>
<script data-name="cookies-handler" data-user="<?=USER['auth'] ? USER['id'] : ''?>" src="/assets/js/cookies-handler.js"></script>
<script data-name="add-to-cart-handler" data-user="<?=USER['auth'] ? USER['id'] : ''?>" src="/assets/js/add-to-cart-handler.js"></script>
<script data-name="cart" data-user="<?=USER['auth'] ? USER['id'] : ''?>" src="/assets/js/cart.js"></script>
</body>

</html>
