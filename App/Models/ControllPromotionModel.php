<?php
namespace App\Models;

use App\Starter\Db;

class ControllPromotionModel extends Db {

    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->connectDb();
    }

    public function getOne($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM promotions WHERE id = ?');

        return $stmt->execute([$id]);
    }

    public function getAll($page) {
        $limit = 10;
        $offset = ((int) $page - 1) * 10;
        $stmt = $this->pdo->prepare('SELECT * FROM promotions LIMIT :limit OFFSET :offset');

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createOne($data) {
        $stmt = $this->pdo->prepare('INSERT INTO promotions (name, description, percent) VALUES (:name, :description, :percent)');

        var_dump($data);

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':percent', $data['percent'], \PDO::PARAM_INT);

        $stmt->execute();

        var_dump($stmt->errorInfo());
        exit;
    }

    public function editOne($data) {
        $stmt = $this->pdo->prepare('UPDATE promotion SET name: = name, percent = :percent, description = :description');

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':percent', $data['percent']);
        $stmt->bindValue(':description', $data['description']);

        return $stmt->execute();
    }

    public function deleteOne($id) {
        $stmt = $this->pdo->prepare('DELETE FROM promotions WHERE id = ?');

        return $stmt->execute([$id]);
    }

    public function getAllCount() {
        return $this->pdo->query('SELECT COUNT(id) as count FROM promotions')->fetch(\PDO::FETCH_ASSOC);
    }

}