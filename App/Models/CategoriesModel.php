<?php
namespace App\Models;
use App\Starter\Db;

class CategoriesModel extends Db {

    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->connectDb();
    }

    public function addCategory($data) {
        $stmt = $this->pdo->prepare('INSERT INTO categories (name, parent_id) 
        VALUES (:name, :parent_id)');

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':parent_id', $data['parent_id']);

        return $stmt->execute();
    }

    public function getAllCategories() {
        return $this->pdo->query('SELECT * FROM categories')->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOneCategory($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateCategory($data) {
        $stmt = $this->pdo->prepare('UPDATE categories SET name = :name, parent_id = :parent_id WHERE id = :catId');

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':parent_id', 0);

        if (isset($data['hasParent'])) {
            $stmt->bindValue(':parent_id', $data['parentId']);
        }

        $stmt->bindValue(':catId', $data['catId']);

        return $stmt->execute();
    }

    public function deleteOneCategory($id) {
        $stmt = $this->pdo->prepare('DELETE FROM categories WHERE id = :catId OR parent_id = :catId');
        $stmt->bindValue(':catId', $id);
        return $stmt->execute();
    }

}