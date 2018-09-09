<?

namespace App\Models\Backend;

use App\Models\BaseModel;

class OrderModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insertProductsToOrder($data)
    {
        $sqlOrderProducts = 'INSERT INTO products_orders (product_id, order_id, count, price_for_one) VALUES';
        $product_ids = [];
        $products = [];

        foreach (array_keys($data) as $key) {
            if (strpos($key, 'product_id') !== false) {
                $product_ids[] = $data[$key];
            }
        }

        foreach ($product_ids as $index => $id) {
                $sqlOrderProducts .= "(:product_id$index, :order_id, :count$index, (SELECT price FROM products WHERE id = :product_id$index))";

                if ((count($product_ids) - 1) > $index) {
                    $sqlOrderProducts .= ",";
                }

                $products[] = [
                    'product_id' => $id,
                    'count' => $data["count=$id"]
                ];
        }

        $productsOrderStmt = $this->pdo->prepare($sqlOrderProducts);
        $productsOrderStmt->bindValue(":order_id", $data['orderId'], \PDO::PARAM_INT);

        foreach ($products as $index => $product) {
            $productsOrderStmt->bindValue(":product_id$index", $product['product_id'], \PDO::PARAM_INT);
            $productsOrderStmt->bindValue(":count$index", $product['count'], \PDO::PARAM_INT);
        }

        return $productsOrderStmt->execute();
    }


    public function saveOrder($data)
    {
        $stmtOrder = $this->pdo->prepare('INSERT INTO orders 
        (customer_name, customer_email, status) VALUES
        (:customer_name, :customer_email, :status)');

        $stmtOrder->bindValue(':customer_name', $data['customer_name']);
        $stmtOrder->bindValue(':customer_email', $data['customer_email']);
        $stmtOrder->bindValue(':status', $data['status']);

        $isSuccess = $stmtOrder->execute();

        return $isSuccess ? $this->pdo->lastInsertId() : false;
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
        customer_email = :customer_email,
        status = :status
        WHERE orders.id = :order_id');

        $stmt->bindValue('customer_email', $orderData['customer_email']);
        $stmt->bindValue('status', $orderData['status']);
        $stmt->bindValue('order_id', $orderData['id']);

        return $stmt->execute();
    }

    public function setOrderProducts($orderId, $arrayProducts)
    {
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

    public function getCount()
    {
        $res = $this->pdo->query('SELECT COUNT(id) as count FROM orders')->fetch(\PDO::FETCH_NUM);

        return $res[0];
    }

    public function getOrderProducts($orderId)
    {
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
