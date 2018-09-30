<?php
namespace App\Controllers;

use App\Models\CartModel;
use App\Models\CategoryModel;
use App\Models\PromotionModel;
use App\Models\ProductModel;

class IndexController extends BaseController {

    private  $productModel;
    private $promotionModel;
    private $categoryModel;
    private $cartModel;

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);

        $this->promotionModel = new PromotionModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->cartModel = new CartModel();
    }

    public  function  indexMethod() {
        $products = $this->productModel->getLastProductsPreview();

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
          'promotions' => array_slice($this->promotionModel->getPromotions(1), 0, 6)
        ];
    }

}