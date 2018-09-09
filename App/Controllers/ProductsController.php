<?php
namespace App\Controllers;

class ProductsController extends BaseController {

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);
    }

    public function getProducts($page, $category) {

        return [
            'products' => []
        ];
    }
}