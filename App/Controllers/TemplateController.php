<?
namespace App\Controllers;

class TemplateController
{
    static public $data;

    private function __construct()
    {

    }

    static function setData($data)
    {
        self::$data = $data;
    }

    static function view($controller, $method)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/App/Views/Common/Header/Header.php';

        $pathToTamplate = $_SERVER['DOCUMENT_ROOT'] . '/App/Views/' . ucfirst($controller) . '/' . ucfirst($method) . '.php';
        if (is_file($pathToTamplate)) {
          require_once $pathToTamplate;
        }
    }
}
