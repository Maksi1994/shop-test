<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\ProductModel;

class CartController extends BaseController
{

    private $cartModel;
    private $productModel;
    private $orderModel;

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);

        if (!USER['auth']) {
            header('location: /users/getLoginForm');
            exit;
        }

        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
    }

    public function getCart()
    {
        $basketValue = $this->cartModel->getBasketData();
        $basketProducts = [];
        $fullPrice = 0;

        $basketProducts['products'] = array_map(function ($product) {
            return $product['id'];
        }, $basketValue);

        $basketProducts['promotions'] = array_map(function ($product) {
            return $product['promotion'];
        }, array_filter($basketValue, function ($product) {
            return !empty($product['promotion']);
        }));

        $products = array_map(function ($basketPosition, $product) use (&$fullPrice) {
            $product['count'] = $basketPosition['count'];
            $fullPrice += $product['count'] * ($product['newPrice'] ?? $product['price']);

            return $product;
        }, $basketValue, $this->productModel->getProductsByIds($basketProducts));

        return [
            'products' => $products,
            'fullPrice' => $fullPrice
        ];
    }

    public function makeOrder()
    {
        if (!empty($_POST['first_name']) &&
            !empty($_POST['last_name']) &&
            !empty($_POST['email']) &&
            !empty($_POST['tel'])) {

        }

        exit;
    }

}