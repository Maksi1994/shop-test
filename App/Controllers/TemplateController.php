<?

namespace App\Controllers;

class TemplateController
{
    static public $data;
    static public $routerParams;

    static function setData($data)
    {
        self::$data = $data;
    }

    static function getTemplatePath($routerParams)
    {
        $sitePart = $routerParams->sitePart === 'backend' ? 'Backend' : '';
        $pathToTemplate = $_SERVER['DOCUMENT_ROOT'] . "/App/Views/$sitePart/" . ucfirst($routerParams->controller) . '/' . ucfirst($routerParams->action) . '.php';

        return $pathToTemplate;
    }

    static function view($routerParams)
    {
        self::$routerParams = $routerParams;
        require_once self::getTemplatePath($routerParams);
    }
}
