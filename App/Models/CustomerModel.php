<?
namespace App\Models;
use App\Starter\Db;

class ArticleModel extends Db
{

    public function __construct()
    {
      $this->pdo = $this->connectDb();
    }

    public function getAll($page = 1, $cat = 'all') {


    }

    public function getOne($id) {

    }

}
