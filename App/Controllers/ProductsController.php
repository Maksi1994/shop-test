<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class ProductsController extends BaseController
{

    private $productModel;
    private $categoryModel;

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);

        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function getProducts($page, $category, $orderType = 'priceDESC')
    {
        $categories = $this->categoryModel->getAllCategories();
        $isExistCategory = array_search((int)$category, array_keys($categories));

        if (!$isExistCategory) {
            header('location: /errors/notFound');
            exit;
        }

        return [
            'products' => $this->productModel->getProducts($page, array_merge(array_keys($categories[$category]), [$category]), $orderType),
            'category' => $this->categoryModel->getCategory($category)
        ];
    }

    public function getProductsByPromotion($id)
    {

    }

    public function getProduct($id)
    {
        return [
            'product' => $this->productModel->getProduct($id)
        ];
    }
}