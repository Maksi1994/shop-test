<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class ProductsController extends BaseController
{

    private $productModel;
    private $categoryModel;
    private $cartModel;

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);

        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->cartModel = new CartModel();
    }

    public function getProducts($page, $category, $orderType = 'priceACS')
    {
        $categories = $this->categoryModel->getFormattedCategories();
        $allKeys = array_keys($categories);
        $allIds = [];
        $countPages = ceil(((int)$this->productModel->getCountOfProducts($category)) / 10);

        foreach ($allKeys as $key) {
            $allIds = array_merge($allIds, array_keys($categories[$key]));
        }

        $isValidCategory = array_search((int)$category, $allIds);

        if ($isValidCategory === false || $category == 0) {
            header('location: /errors/notFound');
            exit;
        }

        $childrenCategories = is_array($categories[$category]) ? $categories[$category] : [];
        $products = $this->productModel->getProducts($page, array_merge(array_keys($childrenCategories), [$category]), $orderType);

        if (USER['auth']) {
            $productsInCart = $this->cartModel->getBasketData();

            $products = array_map(function () {
                if()
            }, $products);
            var_dump();
        }

        return [
            'products' => ,
            'category' => $this->categoryModel->getCategory($category),
            'countPages' => $countPages,
            'page' => $page,
            'filter' => $orderType,
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