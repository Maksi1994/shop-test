<?

use \App\Tools\Router;
use \App\Models\Backend\UserModel;

require_once './vendor/autoload.php';

// init routing
$routerParams = Router::getRouteInfo();


// check auth status
$userModel = new UserModel();

// define auth data
if ($userModel->getCurrUser()) {
    define('USER',array_merge(['auth' => true], $userModel->getCurrUser()));
} else {
    define('USER', ['auth' => false]);
}

// define current part of site
if ($routerParams->sitePart === 'frontend') {
    require_once 'index-frontend.php';
} else if ($routerParams->sitePart === 'backend') {
    require_once 'index-backend.php';
}

