<?
namespace App\Models;
use App\Tools\Db;

class ControllOrderModel extends Db
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->connectDb();
    }

    public function getAll($page)
    {
        $limit = 10;
        $offset = $limit * ($page - 1);
        $stmt = $this->pdo->prepare('SELECT   
				order_id,
				customer_email,
				customer_name,
				UNIX_TIMESTAMP(ts_create) as ts_create,
				curr_status,
				SUM(summ) as full_price,
				SUM(count) as full_count_products
				FROM
				(SELECT 
            orders.id as order_id,  
            orders.customer_email as customer_email, 
            orders.customer_name as customer_name,
            orders.ts_create as ts_create,
            orders.status as curr_status,
            (products_orders.count * products_orders.price_for_one) as summ,
            products_orders.count as count
            FROM products_orders 
            INNER JOIN orders ON orders.id = products_orders.order_id)
            as t1
            GROUP BY(t1.order_id)
            ORDER BY ts_create DESC LIMIT :limit OFFSET :offset');

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOne($id)
    {
        $stmt = $this->pdo->prepare('SELECT   
				order_id,
				customer_email,
				customer_name,
				UNIX_TIMESTAMP(ts_create) as ts_create,
				curr_status,
				SUM(summ) as full_price,
				SUM(count) as full_count_products
				FROM
				(SELECT 
            orders.id as order_id,  
            orders.customer_email as customer_email, 
            orders.customer_name as customer_name,
            orders.ts_create as ts_create,
            orders.status as curr_status,
            (products_orders.count * products_orders.price_for_one) as summ,
            products_orders.count as count
            FROM products_orders 
            INNER JOIN orders ON orders.id = products_orders.order_id
            WHERE orders.id = :order_id)
            as t1
            GROUP BY(t1.order_id)');

        $stmt->bindValue(':order_id', $id, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteOne($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM orders WHERE id = :id');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updateOne($orderData)
    {
        $stmt = $this->pdo->prepare('UPDATE orders SET 
        customer_name = :customer_name, 
        customer_email = :customer_email,
        status = :status
        WHERE orders.id = :order_id');

        $stmt->bindValue('customer_name', $orderData['customer_name']);
        $stmt->bindValue('customer_email', $orderData['customer_email']);
        $stmt->bindValue('status', $orderData['status']);
        $stmt->bindValue('order_id', $orderData['id']);

        return $stmt->execute();
    }

    public function setOrderProducts($orderId, $arrayProducts) {
        $sqlUpdate = "DELETE FROM products_orders WHERE order_id = :order_id; INSERT INTO products_orders (product_id, order_id, count, price_for_one) VALUES";

        foreach ($arrayProducts as $key => $productItem) {
            $sqlUpdate = $sqlUpdate . " (:product_id$key, :order_id$key, :count$key, :price_for_one$key)";

            if (($key < count($arrayProducts) - 1)) {
                $sqlUpdate = $sqlUpdate . ", ";
            }
        }

        $stmtUpdate = $this->pdo->prepare($sqlUpdate);
        $stmtUpdate->bindValue(':order_id', $orderId, \PDO::PARAM_INT);

        foreach ($arrayProducts as $key => $productItem) {
            $stmtUpdate->bindValue(":product_id$key", $productItem['id'], \PDO::PARAM_INT);
            $stmtUpdate->bindValue(":order_id$key", $orderId, \PDO::PARAM_INT);
            $stmtUpdate->bindValue(":count$key", $productItem['count'], \PDO::PARAM_INT);
            $stmtUpdate->bindValue(":price_for_one$key", $productItem['price_for_one'], \PDO::PARAM_INT);
        }

        return $stmtUpdate->execute();
    }

    public function getCount() {
        return $this->pdo->query('SELECT COUNT(id) as count FROM orders')->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOrderProducts($orderId) {
        $stmt = $this->pdo->prepare('SELECT 
            products.id,
            products.photo,  
            products_orders.count, 
            products.name,
            products_orders.price_for_one,
            products_orders.price_for_one * products_orders.count as full_price
            FROM products_orders 
            INNER JOIN products ON products.id = products_orders.product_id
            WHERE products_orders.order_id = :order_id');

        $stmt->bindValue(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
