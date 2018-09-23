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
        $categories = $this->categoryModel->getFormattedCategories();
        $allKeys = array_keys($categories);
        $allIds = [];
        $countPages = ceil(((int) $this->productModel->getCountOfProducts($category)) / 10);

        foreach ($allKeys as $key) {
            $allIds = array_merge($allIds, array_keys($categories[$key]));
        }

        $isExistCategory = array_search((int) $category, $allIds);

        if ($isExistCategory === false || $category == 0) {
            header('location: /errors/notFound');
            exit;
        }

        $childrenCategories = is_array($categories[$category]) ? $categories[$category] : [];

        return [
            'products' => $this->productModel->getProducts($page, array_merge(array_keys($childrenCategories), [$category]), $orderType),
            'category' => $this->categoryModel->getCategory($category),
            'countPages' => $countPages,
            'page' => $page
        ];
    }

    public function getProductsByPromotion($id)
    {

    }

    public function getProduct($id, $promotionId = null)
    {
        return [
            'product' => $this->productModel->getProduct($id, $promotionId)
        ];
    }
}