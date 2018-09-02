<?

namespace App\Tools;

use App\Controllers\TemplateController;

class Router
{

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

        $controllerDivided = explode('/', trim($controllerSegment, '/'));
        $sitePart = $controllerDivided[0] === 'backend' ? 'backend' : 'frontend';
        $controllerDivided = array_slice($controllerDivided, 1);

        parse_str($queryParamsSegment, $queryParams);

        $checkedParam->sitePart = $sitePart;

        // obtain controller's name;
        $checkedParam->controller = $controllerDivided[0] ? ucfirst($controllerDivided[0]) : 'Index';
        $checkedParam->action = $controllerDivided[1] ?? 'indexMethod';

        // obtain controller's params;
        $checkedParam->params = array_slice($controllerDivided, 2);
        $checkedParam->queryParams = $queryParams;
        return $checkedParam;
    }

    static function run()
    {
        $routing = self::getRouteInfo();
        // obtain method's name;
        $sitePart = $routing->sitePart === 'backend' ? 'Backend' : '';

        //var_dump("{$_SERVER['DOCUMENT_ROOT']}/App/Controllers/" . (empty($sitePart) ? "" : "$sitePart/") . "{$routing->controller}Controller.php");

        if (is_file("{$_SERVER['DOCUMENT_ROOT']}/App/Controllers/" . (empty($sitePart) ? "" : "$sitePart/") . "{$routing->controller}Controller.php")) {

            if ($sitePart) {
                $controllerFullName = "App\Controllers\\$sitePart\\" . $routing->controller . 'Controller';
            } else {
                $controllerFullName = "App\Controllers\\" . $routing->controller . 'Controller';
            }

            // create controller
            $controllerInstans = new $controllerFullName($routing);

            if (method_exists($controllerInstans, $routing->action)) {
                return call_user_func_array(array($controllerInstans, $routing->action), $routing->params);
            } else if (!method_exists($controllerInstans, $routing->action) && !is_file(TemplateController::getTemplatePath($routing))) {
                header("location: /{$routing->sitePart}");
            } else {
                return [];
            }
        } else {
            header("location: /{$routing->sitePart}");
        }
    }
}
