<?

namespace App\Controllers\Backend;

use App\Models\Backend\CategoryModel;
use App\Models\Backend\OptionsModel;
use App\Models\Backend\ProductModel;
use App\Controllers\BaseController;

class ProductsController extends BaseController
{
    private $productModel;
    private $categoryModel;
    private $optionModel;

    function __construct($routerInfo)
    {
        parent::__construct($routerInfo);
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->optionModel = new OptionsModel();
    }

    public function showAll($page = 1)
    {
        $list = $this->productModel->getAllProducts('all', $page);
        $res = $this->productModel->getCountProducts('all');

        return [
            'list' => $list,
            'page' => $page,
            'count' => ceil(((int)$res['count']) / 10),
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
            header('location: /backend/products/showOne/' . $_POST['id']);
        } else {
            header('location: /backend/products/showOne/' . $_POST['id'] . '/errorUpdate');
        }
    }

    public function addOne()
    {
        $isUploaded = $_FILES['photo']['error'] === \UPLOAD_ERR_OK;
        $productData = [];

        if ($isUploaded &&
            !empty($_POST['name']) &&
            !empty($_POST['description']) &&
            !empty($_POST['price']) &&
            !empty($_POST['count'])
        ) {

            $photoName = time() . $_FILES['photo']['name'];
            $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/products';
            $isSavedPhoto = move_uploaded_file($_FILES['photo']['tmp_name'], "$uploadsDir/$photoName");

            $_POST['photo'] = $photoName;

            if ($isSavedPhoto) {
                $productData['options'] = [];
                foreach ($_POST as $key => $val) {
                    if (strpos($key, 'option_id=') !== false) {
                        $productData['options'][] = [
                            'option_id' => explode('=', $key)[1],
                            'option_val' => $val
                        ];
                    } else {
                        $productData[$key] = $_POST[$key];
                    }
                }

                $isSavedData = $this->productModel->addOne($productData);
            }
        }

        if ($isSavedPhoto && $isSavedData) {
            header("location: /backend/products/showAll");
        } else {
            header("location: /backend/products/showFormAdd");
        }
    }

    public function toggleStatus($id)
    {
        $this->productModel->toggleStatus($id);

        header("location: /backend/products/showAll");
    }


    public function searchOptions()
    {
        $res = $this->optionModel->searchOptions($_POST['searchText']);
        echo json_encode($res);
        exit;
    }
}
