<?php
ob_start();
use App\Starter\Router;
use App\Controllers\TemplateController;
use App\Models\UserModel;
require_once __DIR__ . '/vendor/autoload.php';
require_once './App/Starter/Libs.php';

// init routing
$routerParams = Router::getRouteInfo();
$data = Router::run();

// get view
TemplateController::setData($data);
TemplateController::view($routerParams->controller, $routerParams->action);
