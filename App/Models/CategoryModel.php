<?php

namespace App\Models;

class CategoryModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getFormattedCategories()
    {
        $categories = $this->pdo->query('SELECT * FROM categories')->fetchAll(\PDO::FETCH_ASSOC);
        $formedCategories = [];

        foreach ($categories as $cat) {
            $formedCategories[$cat['parent_id']][$cat['id']] = $cat;
        };

        return $formedCategories;
    }

    public function getCategory($id)
    {
        $stmt = $this->pdo->prepare('SELECT 
          id,
         name,
         photo
         FROM categories WHERE categories.id  = :catId');

        $stmt->bindValue(':catId', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


}