<?
namespace App\Tools;

class Db {
    public $db;
    private  static $connect = false;

    public function connectDb() {
        if (!self::$connect) {
            $env = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/.env/environment.json'), true);

            $p = $env['DB'];
            $host = $p['HOST'];
            $dbName = $p['DB_NAME'];
            $user = $p['LOGIN'];
            $password = $p['PASSWORD'];

            $this->db = new \PDO("mysql:host=" . $host . ";dbname=" . $dbName, $user, $password);
        }
        return $this->db;

    }
}
