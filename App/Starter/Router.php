<?

namespace App\Starter;

use App\Models\UserModel;

class Router
{

    static private function initAllConstants()
    {
        $userModel = new UserModel();
        define('USER', $userModel->getCurrUser() ? array_merge(['auth' => true], $userModel->getCurrUser()) : ['auth' => false]);
    }

    static function isActive($url)
    {
        return strpos(strtolower($_SERVER['REQUEST_URI']), strtolower($url)) === 0 ? 'active' : '';
    }

    static function getRouteInfo()
    {
        $checkedParam = new \stdClass();
        $queryParams = [];
        // parse request url

        list($controllerSegment, $queryParamsSegment) = explode('?', trim($_SERVER['REQUEST_URI']));
        $controllerData = explode('/', trim($controllerSegment, '/'));
        parse_str($queryParamsSegment, $queryParams);

        // obtain controller's name;
        $checkedParam->controller = $controllerData[0] ? ucfirst($controllerData[0]) : 'Index';
        $checkedParam->action = $controllerData[1] ?? 'index';

        // obtain controller's params;
        $checkedParam->params = array_slice($controllerData, 2);
        $checkedParam->queryParams = $queryParams;
        return $checkedParam;
    }

    static function run()
    {
        self::initAllConstants();
        $routing = self::getRouteInfo();
        // obtain method's name;
        $controllerName = 'App\Controllers\\' . $routing->controller . 'Controller';

        // create controller
        $controllerInstans = new $controllerName;

        return call_user_func_array(array($controllerInstans, $routing->action), $routing->params);
    }
}
