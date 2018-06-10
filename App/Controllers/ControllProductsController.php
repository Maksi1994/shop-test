<?
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\UserModel;

class ControllProductsController
{

    function __construct()
    {
        $userModel = new UserModel;

        if (!$userModel->getCurrUser()) {
            header('location: /user/login');
            exit;
        }
    }

    public function showAll($cat = 'all', $page = 1)
    {
        $productModel = new ProductModel;
        $list = $productModel->getAllProducts($cat, $page);
        $count = $productModel->getCountProducts($cat);

        return [
            'list' => $list,
            'page' => $page,
            'cat' => $cat,
            'count' => $count,
        ];
    }

    public function showOne($id, $viewError = '')
    {
        $productModel = new ProductModel;
        $product = $productModel->getOneProduct($id);
        $allCategories = $productModel->getAllCategories();
        $promotionsIds = array_column($productModel->getPromotions($id), 'id');
        $errorMessage = '';

        if (!isset($product)) {
            header('location: /controllProducts/showAll');
        }

        $product['promotions'] = $productModel->getPromotions($id);

        $allPtomotions = array_map(function ($promotionItem) use ($promotionsIds) {
            $promotionItem['active'] = array_search($promotionItem['id'], $promotionsIds) !== false;

            return $promotionItem;
        }, $productModel->getAllPromotions());

        switch ($viewError) {
            case 'updateError':
                $errorMessage = 'Update has not done, happened some error';
        }


        return [
            'product' => $product,
            'allCategories' => $allCategories,
            'allPromotions' => $allPtomotions,
            'errorMessage' => $errorMessage
        ];
    }

    public function showFormAdd($err = null)
    {
        $productModel = new ProductModel;
        $errMessage = '';
        $allCategories = $productModel->getAllCategories();

        if ($err === 'failed') {
            $errMessage = 'Uploaded Error.';
        }

        return [
            'errMessage' => $errMessage,
            'categories' => $allCategories
        ];

    }

    public function toggleProductPromotion($productId, $promotionId) {
        $productModel = new ProductModel;
        $productModel->toggleProductPromotion($productId, $promotionId);

        header('location: /controllProducts/showOne/'.$productId);
    }

    public function updateProduct()
    {
        $productModel = new ProductModel;
        $isSucess = $productModel->updateProduct($_POST);

        if ($isSucess) {
            header('location: /controllProducts/showOne/'.$_POST['productId']);
        } else {
            header('location: /controllProducts/showOne/'.$_POST['productId'].'/errorUpdate');
        }
    }

    public function addOne()
    {
        $productModel = new ProductModel;
        $isUploaded = $_FILES['photo']['error'] === \UPLOAD_ERR_OK;

        if ($isUploaded && isset($_POST['name'],
                $_POST['description'],
                $_POST['category_id'],
                $_POST['price'],
                $_POST['count'],
                $_FILES['photo']
            )) {
            $photoName = time() . $_FILES['photo']['name'];
            $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/products';
            move_uploaded_file($_FILES['photo']['tmp_name'], "$uploadsDir/$photoName");

            $_POST['photo'] = $photoName;
            $isSucces = $productModel->addOne($_POST);

            if ($isSucces) {
                $category = $productModel->getCategoryById($_POST['category_id']);

                header("location: /controllProducts/showAll/{$category['name']}");
            } else {
                header("location: /controllProducts/showFormAdd/");
            }
        }
    }

    public function deleteOne($id, $category)
    {
        $productModel = new ProductModel;
        $productModel->deleteOne($id);
        header("location: /controllProducts/showAll");
    }
}
