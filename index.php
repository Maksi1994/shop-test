<?php

use \App\Tools\Router;
use \App\Controllers\TemplateController;


require_once './vendor/autoload.php';
// init routing
$routerParams = Router::getRouteInfo();
$data = Router::run();
?>
<html>
<head>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/styles/controll-products.css">
    <link rel="stylesheet" href="/assets/styles/controll-orders.css">
    <link rel="stylesheet" href="/assets/styles/controll-categories.css">
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>
<body>
<header>
    <nav class="header-controll-panel navbar navbar-expand-lg bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <img class="logo mr-3" src="/assets/images/mechanic.png" alt="">

        <div class="collapse navbar-collapse header-controll-panel" id="navbarTogglerDemo03">
            <ul class="navbar-nav nav-pills w-100 mr-auto mt-2 mt-lg-0">
                <li class="nav-item dropdown mr-2">
                    <a class="nav-link pointer dropdown-toggle <?= Router::isActive('/controllProducts') ?>"
                       data-toggle="dropdown"
                       role="button" aria-haspopup="true"
                       aria-expanded="false">Products</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item <?= Router::isActive('/controllProducts/showAll') ?>"
                           href="/controllProducts/showAll">All Products</a>
                        <a class="dropdown-item <?= Router::isActive('/controllProducts/showFormAdd') ?>"
                           href="/controllProducts/showFormAdd">Add Products</a>
                    </div>
                </li>

                <li class="nav-item dropdown mr-2">
                    <a class="nav-link pointer dropdown-toggle <?= Router::isActive('/controllCategories') ?>"
                       data-toggle="dropdown"
                       role="button" aria-haspopup="true"
                       aria-expanded="false">Categories</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item <?= Router::isActive('/controllCategories/showAll') ?>"
                           href="/controllCategories/showAll">Show All</a>
                        <a class="dropdown-item <?= Router::isActive('/controllCategories/showFormAdd') ?>"
                           href="/controllCategories/showFormAdd">Add Category</a>
                    </div>
                </li>

                <li class="nav-item dropdown mr-2">
                    <a class="nav-link pointer dropdown-toggle <?= Router::isActive('/controllOrders') ?>"
                       data-toggle="dropdown"
                       role="button">Customers & Orders</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item <?= Router::isActive('/controllOrders/showAll') ?>"
                           href="/controllOrders/showAll">All Orders</a>
                    </div>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link pointer dropdown-toggle <?= Router::isActive('/controllPromotions') ?>"
                       data-toggle="dropdown"
                       role="button">Promotions</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item <?= Router::isActive('/controllPromotions/showAll') ?>"
                           href="/controllPromotions/showAll">All Promotions</a>
                    </div>

                    <div class="dropdown-menu">
                        <a class="dropdown-item <?= Router::isActive('/controllPromotions/showFormAdd') ?>"
                           href="/controllPromotions/showFormAdd">Add Promotion</a>
                    </div>
                </li>

                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <? if (!USER['auth']) { ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="/user/login">Login</a>
                        </li>
                    <? } ?>
                    <? if (USER['auth']) { ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="/user/logout">Logout</a>
                        </li>
                    <? } ?>
                </ul>
            </ul>
        </div>
    </nav>
</header>
<main>
    <?
    // get view
    TemplateController::setData($data);
    TemplateController::view($routerParams->controller, $routerParams->action);
    ?>
</main>
<footer>

</footer>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>



