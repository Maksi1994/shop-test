<?
namespace App\Models;

use App\Tools\Db;

class ControllProductModel extends Db
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->connectDb();
    }

    public function getAllProducts($catName, $page)
    {
        $limit = 10;
        $offset = $limit * ($page - 1);

        $sql = "SELECT
          products.status,
          products.id,
          products.name as name,
          categories.name as category_name,
          products.price as price,
          products.photo,
          products.description
          FROM products
          LEFT JOIN categories
          ON categories.id = products.category_id";

        if ($catName !== 'all') {
            $sql = $sql . " WHERE categories.name = :catName";
        }
        $sql = $sql . " ORDER BY products.ts LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        if ($catName !== 'all') {
            $stmt->bindValue(':catName', $catName);
        }

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPromotions($productId)
    {
        $stmt = $this->pdo->prepare("SELECT promotions.name, promotions.id FROM products
    INNER JOIN products_promotions
    ON products_promotions.product_id = products.id AND products.id = ?
    INNER JOIN promotions
    ON products_promotions.promotion_id = promotions.id");

        $stmt->execute([$productId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addOne($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO products
      (name, photo, description, price, count, category_id)
      VALUES (:name, :photo, :description, :price, :count, :category_id)');

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':photo', $data['photo']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':count', $data['count']);
        $stmt->bindValue(':category_id', $data['category_id'], \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updateProduct($productData)
    {
        $stmt = $this->pdo->prepare('UPDATE products SET
          name = :name, price = :price, category_id = :categoryId, status = :status WHERE id = :productId');
  
        $stmt->bindValue(':name', $productData['name']);
        $stmt->bindValue(':price', $productData['price']);
        $stmt->bindValue(':categoryId', $productData['categoryId']);
        $stmt->bindValue(':productId', $productData['id']);
        $stmt->bindValue(':status', isset($productData['enabled']) ? 'e' : 'd');

        return $stmt->execute();
    }

    public function setProductPromotions($productId, $promotionArray)
    {
        $sql = "DELETE FROM products_promotions WHERE product_id = :product_id;
                INSERT INTO products_promotions (product_id, promotion_id) VALUES";

        foreach ($promotionArray as $key => $promotionId) {
            $sql = $sql . " (:product_id$key, :promotion_id$key)";

            if ($key < (count($promotionArray) - 1)) {
                $sql .= ", ";
            }
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':product_id', $productId, \PDO::PARAM_INT);

        foreach ($promotionArray as $key => $promotionId) {
            $stmt->bindValue(":product_id$key", $productId, \PDO::PARAM_INT);
            $stmt->bindValue(":promotion_id$key", $promotionId, \PDO::PARAM_INT);
        }

        return $stmt->execute();
    }

    public function getOneProduct($productId)
    {
        $stmt = $this->pdo->prepare('SELECT
        products.status,
        products.id,
        products.name as name, products.price,
        categories.name as categoryName,
        categories.id as category_id,
        products.photo,
        products.status
        FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE products.id = ?');

        $stmt->execute([$productId]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllPromotions()
    {
        return $this->pdo->query('SELECT * FROM promotions')->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getCountProducts($categoryName)
    {
        $sql = "SELECT COUNT(id) as count FROM products";

        if ($categoryName !== 'all') {
            $sql = $sql . ' INNER JOIN categories ON products.category_id = categories.id AND categories.name = :cat_name';
        }

        $stmt = $this->pdo->prepare($sql);

        if ($categoryName !== 'all') {
            $stmt->bindValue(':cat_name', $categoryName);
        }

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function toggleStatus($id) {
        $stmt = $this->pdo->prepare("UPDATE products SET status = IF(status='e', 'd', 'e') WHERE id = ?");

        return $stmt->execute([$id]);
    }
}
