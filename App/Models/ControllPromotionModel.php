<?php
namespace App\Models;

use App\Tools\Db;

class ControllPromotionModel extends Db {

    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->connectDb();
    }

    public function getOne($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM promotions WHERE id = ?');

        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
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

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':percent', $data['percent'], \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function editOne($data) {
        $stmt = $this->pdo->prepare('UPDATE promotions SET name = :name, percent = :percent, description = :description WHERE id = :id');

        $stmt->bindValue(':id', $data['id']);
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