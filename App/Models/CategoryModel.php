<?php

namespace App\Models;

class CategoryModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllCategories()
    {
        $categories = $this->pdo->query('SELECT * FROM categories')->fetchAll(\PDO::FETCH_ASSOC);
        $formedCategories = [];

        foreach ($categories as $cat) {
            $formedCategories[$cat['parent_id']][$cat['id']] = $cat;
        };

        return $formedCategories;
    }

}