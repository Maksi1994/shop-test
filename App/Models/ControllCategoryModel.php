<?php

namespace App\Models;

use App\Tools\Db;

class ControllCategoryModel extends Db
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->connectDb();
    }

    public function addCategory($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO categories (name, parent_id, photo) VALUES(:name, :parent_id, :photo)');

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':parent_id', ($data['parent_id'] ?? $data['default_parent_id']));
        $stmt->bindValue(':photo', $data['photoName']);

        return $stmt->execute();
    }

    public function getAllCategories($withoutCatId = null)
    {
        $categories = $this->pdo->query('SELECT * FROM categories')->fetchAll(\PDO::FETCH_ASSOC);
        $formedCategories = [];
        $filteredCategories = [];

        foreach ($categories as $cat) {
            $formedCategories[$cat['parent_id']][$cat['id']] = $cat;

            if (!empty($withoutCatId) && $cat['parent_id'] != $withoutCatId && $cat['id'] != $withoutCatId) {
                $filteredCategories[$cat['parent_id']][$cat['id']] = $cat;
            }
        };

        return empty($withoutCatId) ? $formedCategories : ['all' => $formedCategories, 'filtered' => $filteredCategories];
    }

    public function getOneCategory($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateCategory($data)
    {
        $stmt = $this->pdo->prepare('UPDATE categories SET name = :name, parent_id = :parent_id WHERE id = :catId');

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':parent_id', 0);
        $stmt->bindValue(':catId', $data['catId']);

        if (!empty($data['parentId'])) {
            $stmt->bindValue(':parent_id', $data['parentId']);
        }

        return $stmt->execute();
    }

    public function deleteOneCategory($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM categories WHERE id = :catId OR parent_id = :catId');
        $stmt->bindValue(':catId', $id);

        return $stmt->execute();
    }

    public function getCategoriesIcons()
    {
        $path = "{$_SERVER['DOCUMENT_ROOT']}/assets/icons/categories";

        $imgs = array_filter(scandir($path), function ($fileName) {
            return $fileName !== '.' && $fileName !== '..';
        });

        return $imgs;
    }

}
