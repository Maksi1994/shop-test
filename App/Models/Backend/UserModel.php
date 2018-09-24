<?
namespace App\Models\Backend;
use App\Models\CryptModel;
use App\Tools\Db;

class UserModel extends Db
{
  private $pdo;

  public function __construct() {
      $this->pdo = $this->connectDb();
  }

    public function getAllRoles() {
        return $this->pdo->query('SELECT * FROM roles')->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserByLogin($login)
    {
        $stmt = $this->pdo->prepare('SELECT id, login, password FROM users WHERE login=?');
        if ($stmt->execute([$login])) {
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }
        return false;
    }

    public function getCurrUser()
    {
        if (isset($_COOKIE['auth_id'])) {
            $id = CryptModel::crypt($_COOKIE['auth_id'], 'd');
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id=?');
            if ($stmt->execute([$id])) {
              return $stmt->fetch(\PDO::FETCH_ASSOC);
            } else {
              return false;
            }
        } else {
            return false;
        }
    }

    public function setCurrUser($idUser, $sitePart = '')
    {
        setcookie('auth_id', CryptModel::crypt($idUser, 'e'), time() + 31556926, '/'.$sitePart);
    }

    public function clearCurrUser($sitePart = '')
    {
        setcookie('auth_id', null, -1, '/'.$sitePart);
    }

    public function createUser($data)
    {
          $stmt = $this->pdo->prepare('INSERT INTO users (first_name, last_name, login, role_id, password)
          VALUES (:first_name, :last_name, :login, :role_id, :password)');
          $stmt->bindValue(':first_name', $data['first_name']);
          $stmt->bindValue(':last_name',  $data['last_name']);
          $stmt->bindValue(':login',  $data['login']);
          $stmt->bindValue(':role_id',   $data['role']);
          $stmt->bindValue(':password',  $data['password']);

          return $stmt->execute();
    }

}
