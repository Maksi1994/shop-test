<?php

namespace App\Models;


class ProductModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProducts($page, $categoriesIds, $orderFilter)
    {
        $idsPlaceholder = '';
        $filter = '';

        switch ($orderFilter) {
            case 'priceASC':
                $filter = 'ORDER BY products.price ASC';
                break;
            case 'priceDESC':
                $filter = 'ORDER BY products.price DESC';
                break;
            case 'newestASC':
                $filter = 'ORDER BY products.id ASC';
                break;
            case 'newestDESC':
                $filter = 'ORDER BY products.id DESC';
                break;
            case 'popularASC':
                $filter = 'ORDER BY orderCount ASC';
                break;
            case 'popularDESc':
                $filter = 'ORDER BY orderCount DESC';
        }

        foreach ($categoriesIds as $index => $id) {
            $idsPlaceholder .= (count($categoriesIds) - 1) > $index ? ":id$index," : ":id$index";
        }

        $stmt = $this->pdo->prepare("SELECT 
            products.id,
            products.price,
            products.name,
            products.description,
            products.photo,
            categories.name as catName,
            categories.id as catId,
            categories.photo as categoryPhoto,
             promotions.id as promotionId,
            promotions.percent as promotionPercent,
            promotions.name as promotionName,  
            (SELECT COUNT(products_orders.product_id) FROM products_orders
            LEFT JOIN orders ON orders.id = products_orders.order_id
            WHERE products_orders.product_id = products.id
            ) as orderCount,
            ROUND((CASE WHEN promotions.id IS NOT NULL
                THEN products.price - ((products.price / 100) * promotions.percent)
                ELSE NULL
              END), 2) as newPrice
            FROM products 
            INNER JOIN categories ON categories.id = products.category_id 
            LEFT JOIN products_promotions ON products_promotions.product_id = products.id
            LEFT JOIN promotions ON promotions.id = products_promotions.promotion_id
            WHERE categories.id IN ($idsPlaceholder)
            $filter LIMIT :limit OFFSET :offset
        ");

        foreach ($categoriesIds as $index => $id) {
            $stmt->bindValue(":id$index", $id, \PDO::PARAM_INT);
        }

        $stmt->bindValue(':limit', 10, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (($page - 1) * 10), \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLastProductsPreview()
    {
        $stmt = $this->pdo->prepare('SELECT 
            products.id,
            products.price,
            products.name,
            products.description,
            products.photo,
            promotions.id as promotionId,
            promotions.percent as promotionPercent,
            promotions.name as promotionName,
             ROUND(
             (CASE WHEN promotions.id IS NOT NULL
                THEN products.price - ((products.price / 100) * promotions.percent)
                ELSE NULL
              END), 2) as newPrice
            FROM products 
            INNER JOIN categories ON categories.id = products.category_id
            LEFT JOIN products_promotions ON products_promotions.product_id = products.id AND products_promotions.id = (SELECT products_promotions.id FROM products_promotions WHERE products_promotions.product_id = products.id ORDER BY products_promotions.id LIMIT 1)
            LEFT JOIN promotions ON promotions.id = products_promotions.promotion_id
            ORDER BY products.id ASC LIMIT :limit');


        $stmt->bindValue(':limit', 6, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProduct($id, $promotionId)
    {
        $stmt = $this->pdo->prepare('SELECT 
            products.id,
            products.price,
            products.name,
            products.description,
            products.photo,
            promotions.id as promotionId,
            promotions.percent as promotionPercent,
            promotions.name as promotionName,
            categories.name as categoryName,
            categories.id as categoryId,
              ROUND(
             (CASE WHEN promotions.id IS NOT NULL
                THEN products.price - ((products.price / 100) * promotions.percent)
                ELSE NULL
              END), 2) as newPrice
            FROM products 
            INNER JOIN categories ON categories.id = products.category_id 
            LEFT JOIN products_promotions ON products.id = products_promotions.product_id
            LEFT JOIN promotions ON promotions.id = products_promotions.promotion_id
            WHERE products.id = :productId 
            AND CASE WHEN :promotionId IS NOT NULL THEN promotions.id = :promotionId ElSE 1 END');

        $stmt->bindValue(':productId', $id, \PDO::PARAM_INT);
        $stmt->bindValue(':promotionId', $promotionId, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getCountOfProducts($catId)
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(products.id) FROM products 
        INNER JOIN categories ON categories.id = products.category_id 
        WHERE categories.id = :catId');

        $stmt->bindValue(':catId', $catId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_NUM)[0];
    }

}