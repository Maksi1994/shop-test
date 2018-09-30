<?php

namespace App\Models;

class OrderModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function makeOrder($data)
    {
        $this->pdo->beginTransaction();

        $stmtOrder = $this->pdo->prepare('INSERT INTO order 
        (first_name, last_name, customer_email, telephone) VALUES
        (:first_name, :last_name, :customer_email, :telephone)');

        $stmtOrder->bindValue(':first_name', $data['first_name']);
        $stmtOrder->bindValue(':last_name', $data['last_name']);
        $stmtOrder->bindValue(':customer_email', $data['email']);
        $stmtOrder->bindValue(':telephone', $data['telephone']);

        if ($stmtOrder->execute()) {
            $orderId = $this->pdo->lastInsertId();

            $productPlaceholder = '';

            foreach ($data['products'] as $index => $product) {
                $productPlaceholder .= ":product_id$index" . ":order_id, count:$index, 
                (SELECT ROUND((CASE WHEN promotions.id IS NOT NULL
                THEN products.price - ((products.price / 100) * promotions.percent) ELSE products.price END), 2) as price_for_one 
                FROM products
                LEFT JOIN product_promotions ON product_promotions.product_id = products.id
                LEFT JOIN promotions ON promotions.id = product_promotions.id
                WHERE (:promoion_id IS NULL OR promotions.id = :promoion_id) AND (products.id = :product_id$index)"
                . (count($data['products']) - 1) > $index ? ',' : '';
            }

            $stmtProductOrder = $this->pdo->prepare('INSERT INTO products_orders 
        (product_id, order_id, count, price_for_one) VALUES (' . $productPlaceholder . ')');

            foreach ($data['products'] as $index => $product) {
                $stmtProductOrder->bindValue(":product_id$index", $product['id'], \PDO::PARAM_INT);
                $stmtProductOrder->bindValue(":count$index",  $product['count'], \PDO::PARAM_INT);
                $stmtProductOrder->bindValue(":order_id",  $orderId, \PDO::PARAM_INT);
                $stmtProductOrder->bindValue(":promotion_id",  $product['promotionId'], \PDO::PARAM_INT);
            }

            if ($stmtProductOrder->execute()) {
                return true;

            } else {
                $this->pdo->rollBack();

                return false;
            }

        } else {
            $this->pdo->rollBack();

            return false;
        }
    }
}