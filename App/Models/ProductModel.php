<?php
namespace App\Models;


class ProductModel extends BaseModel {
    public function __construct()
    {
        parent::__construct();
    }

    public function getProducts($page, $category) {
        if ($category === 'all') {
            $stmt = $this->pdo->prepare('SELECT 
            products.id,
            products.price,
            products.name,
            products.description,
            products.photo
            FROM products 
            LEFT JOIN categories ON categories.id = products.category_id ORDER BY products.id ASC LIMIT :limit OFFSET :offset');

            $stmt->bindValue(':limit', 10, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', ($page - 1) * 10, \PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {

        }
    }

}