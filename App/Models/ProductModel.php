<?

namespace App\Models;

use App\Starter\Db;

class ProductModel extends Db
{

    public function __construct()
    {
        $this->pdo = $this->connectDb();
    }

    public function getAllProducts($catName, $page)
    {
        $per_page = 10;

        $stmt = $this->pdo->prepare("SELECT
      products.id,
      products.name as name,
      categories.name as category_name,
      products.price as price,
      products.photo,
      products.description
      FROM products
      INNER JOIN categories
      ON categories.id = products.category_id"
            . ($catName !== 'all' ? " WHERE categories.name = :catName" : "") .
            " ORDER BY products.ts LIMIT :limit OFFSET :offset");

        if ($catName !== 'all') {
            $stmt->bindValue(':catName', $catName);
        }

        $stmt->bindValue(':limit', (int)$per_page, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)($page - 1) * $per_page, \PDO::PARAM_INT);

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
        $stmt->bindValue(':category_id', $data['category_id']);


        return $stmt->execute();
    }

    public function updateProduct($productData)
    {
        $stmt = $this->pdo->prepare('UPDATE products SET name = :name, price = :price, category_id = :categoryId 
            WHERE id = :productId');

        $stmt->bindValue(':name', $productData['name']);
        $stmt->bindValue(':price', $productData['price']);
        $stmt->bindValue(':categoryId', $productData['categoryId']);
        $stmt->bindValue(':productId', $productData['productId']);

        return $stmt->execute();
    }

    public function toggleProductPromotion($productId, $promotionId)
    {
        $stmt = $this->pdo->prepare('SElECT * FROM products_promotions INNER JOIN products 
          ON products_promotions.product_id = products.id AND products.id = ? AND products_promotions.promotion_id = ?');

        $stmt->execute([$productId, $promotionId]);

        $isActive = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$isActive) {
            $setStmt = $this->pdo->prepare('INSERT INTO products_promotions (product_id, promotion_id) VALUES (?, ?)');
            return $setStmt->execute([$productId, $promotionId]);
        } else {
            $setStmt = $this->pdo->prepare('DELETE FROM products_promotions WHERE product_id = ? AND promotion_id = ?');
            return $setStmt->execute([$productId, $promotionId]);
        }
    }

    public function getOneProduct($productId)
    {
        $stmt = $this->pdo->prepare('SELECT products.id, products.price, categories.name, categories.id as category_id FROM products LEFT JOIN categories
        ON products.category_id = categories.id WHERE products.id = ?');

        $stmt->execute([$productId]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllPromotions()
    {
        return $this->pdo->query('SELECT * FROM promotions')->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllCategories()
    {
        return $this->pdo->query('SELECT * FROM categories')->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE categories.id = ?');
        $stmt->execute([$id]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCountProducts($categoryName)
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(id) FROM products INNER JOIN categories
    ON products.category_id = categories.id AND categories.name = ?');
        $stmt->execute([$categoryId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
