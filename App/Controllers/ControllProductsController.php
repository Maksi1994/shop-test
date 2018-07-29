<?

namespace App\Controllers;

use App\Models\ControllCategoryModel;
use App\Models\ControllProductModel;
use App\Models\UserModel;

class ControllProductsController
{
    private $productModel;
    private $categoryModel;
    private $userModel;

    function __construct()
    {
        $this->productModel = new ControllProductModel();
        $this->categoryModel = new ControllCategoryModel();
        $this->userModel = new UserModel();

        if (!$this->userModel->getCurrUser()) {
            header('location: /user/login');
            exit;
        }

    }

    public function showAll($page = 1)
    {
        $list = $this->productModel->getAllProducts('all', $page);
        $res = $this->productModel->getCountProducts('all');
        
        return [
            'list' => $list,
            'page' => $page,
            'count' => ceil(((int) $res['count']) / 10),
        ];
    }

    public function showOne($id)
    {
        $product = $this->productModel->getOneProduct($id);
        $allCategories = $this->categoryModel->getAllCategories();
        $promotionsIds = array_column($this->productModel->getPromotions($id), 'id');

        $product['promotions'] = $this->productModel->getPromotions($id);

        $allPtomotions = array_map(function ($promotionItem) use ($promotionsIds) {
            $promotionItem['active'] = array_search($promotionItem['id'], $promotionsIds) !== false;

            return $promotionItem;
        }, $this->productModel->getAllPromotions());


        return [
            'product' => $product,
            'allCategories' => $allCategories,
            'allPromotions' => $allPtomotions
        ];
    }

    public function showFormAdd()
    {
        $allCategories = $this->categoryModel->getAllCategories();

        return [
            'categories' => $allCategories
        ];

    }

    public function updateProduct()
    {
        $activePromotions = [];

        foreach ($_POST as $key => $val) {
            if (strpos($key, 'prom') === 0) {
                $activePromotions[] = $val;
            }
        }

        if (!empty($_POST['id']) &&
            !empty($_POST['name']) &&
            !empty($_POST['description']) &&
            !empty($_POST['price'])
        ) {
            $updatedProduct = $this->productModel->updateProduct($_POST);
            $updatedProductPromotions = $this->productModel->setProductPromotions($_POST['id'], $activePromotions);
        }

        if ($updatedProduct && $updatedProductPromotions) {
            header('location: /controllProducts/showOne/' . $_POST['id']);
        } else {
            header('location: /controllProducts/showOne/' . $_POST['id'] . '/errorUpdate');
        }
    }

    public function addOne()
    {
        $isUploaded = $_FILES['photo']['error'] === \UPLOAD_ERR_OK;

        if ($isUploaded &&
            !empty($_POST['name']) &&
            !empty($_POST['description']) &&
            !empty($_POST['price'])
        ) {

            $photoName = time() . $_FILES['photo']['name'];
            $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/products';
            $isSavedPhoto = move_uploaded_file($_FILES['photo']['tmp_name'], "$uploadsDir/$photoName");

            $_POST['photo'] = $photoName;

            if ($isSavedPhoto) {
                $isSavedData = $this->productModel->addOne($_POST);
            }
        }

        if ($isSavedPhoto && $isSavedData) {
            header("location: /controllProducts/showAll");
        } else {
            header("location: /controllProducts/showFormAdd");
        }
    }

    public function toggleStatus($id)
    {
        $this->productModel->toggleStatus($id);

        header("location: /controllProducts/showAll");
    }
}
