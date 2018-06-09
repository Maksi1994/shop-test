<?
namespace App\Models;
use App\Starter\Db;

class ArticleModel extends Db
{

    public function __construct()
    {
      $this->pdo = $this->connectDb();
    }

    public function addArticle($data)
    {
      $stmt = $this->pdo->prepare('INSERT INTO news (title, headId, preview, body, author_id, photo)
      VALUES (:title, :headId, :preview, :body, :author_id, :photo)');

      $stmt->bindValue(':title', $data['title']);
      $stmt->bindValue(':headId', $data['head']);
      $stmt->bindValue(':preview', $data['preview']);
      $stmt->bindValue(':body', $data['body']);
      $stmt->bindValue(':author_id', $data['author_id']);
      $stmt->bindValue(':photo', $data['photo']);

      return $stmt->execute();
  }

   public function getPagesCount($headId) {
     if (!empty($headId)) {
      $stmt = $this->pdo->prepare('SELECT COUNT(id) as count FROM news WHERE headId = ?');
      $stmt->execute([$headId]);
    } else {
      $stmt = $this->pdo->prepare('SELECT COUNT(id) as count FROM news');
      $stmt->execute();
    }

     $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
     return ceil($res[0]['count'] / 10);
   }

    public function getAllArticles($page = 1, $headId)
    {
      $per_page = 10;
      $stmt = $this->pdo->prepare('SELECT
        UNIX_TIMESTAMP(a.date) as date, a.title, a.preview, a.body, a.author_id, a.photo,
        CONCAT(users.first_name, " ", users.last_name) as authorName
        FROM news as a
        INNER JOIN users ON a.author_id = users.id'.($headId ? ' WHERE news.headId = :headId' : '').
      " ORDER BY a.date DESC LIMIT :limit OFFSET :offset");

      $stmt->bindValue(':limit', (int) $per_page, \PDO::PARAM_INT);
      $stmt->bindValue(':offset', (int) ($page - 1) * $per_page, \PDO::PARAM_INT);

      if(!empty($headId)) {
        $stmt->bindValue(':headId', $headId);
      }
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
