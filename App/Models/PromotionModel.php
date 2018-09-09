<?php

namespace App\Models;

class PromotionModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getPromotions($page)
    {
        $stmt = $this->pdo->prepare('SELECT promotions.id as id,
          promotions.percent,
          promotions.name,
          promotions.description
        FROM products_promotions 
        INNER JOIN promotions ON products_promotions.promotion_id = promotions.id
        GROUP BY promotions.id
        ORDER BY promotions.id ASC LIMIT :limit OFFSET :offset');

        $stmt->bindValue(':limit', 10, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', ($page - 1) * 10, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}