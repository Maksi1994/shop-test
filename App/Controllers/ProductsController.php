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

        $childrenCategories = !empty($categories[$category]) && is_array($categories[$category]) ? $categories[$category] : [];
        $products = $this->productModel->getProducts($page, array_merge(array_keys($childrenCategories), [$category]), $orderType);

        if (USER['auth']) {
            $productsInCart = $this->cartModel->getBasketData();

            $products = array_map(function ($product) use ($productsInCart) {
                foreach($productsInCart as $addedProduct) {
                    $hasPromotion = isset($product['promotionId']);

                    if ($product['id'] === $addedProduct['id'] && (!$hasPromotion || $addedProduct['promotion'] === $product['promotionId'])) {
                       $product['inCart'] = true; 
                    }
                }
                
                return $product;
            }, $products);
            
        }

        return [
            'products' => $products,
            'category' => $this->categoryModel->getCategory($category),
            'countPages' => $countPages,
            'page' => $page,
            'filter' => $orderType,
        ];
    }

    public function getProductsByPromotion($id, $orderType = 'priceACS')
    {
        $products = $this->productModel->getProductsByPromotionId($id, $orderType);

        return [
            'products' => $products,
            'promotion' => $id,
            'orderType' => $orderType
        ];
    }

    public function getProduct($id, $promotionId = null)
    {      
        $product = $this->productModel->getProduct($id, $promotionId);
        
        if (USER['auth']) {
             $productsInCart = $this->cartModel->getBasketData();
            
             foreach($productsInCart as $addedProduct) {
                 $hasPromotion = isset($product['promotionId']);

                 if ($product['id'] === $addedProduct['id'] && (!$hasPromotion || $addedProduct['promotion'] === $product['promotionId'])) {
                     $product['inCart'] = true;
                 }
            } 
        }
        
        return [
            'product' => $product
        ];
    }
}