<?php
namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\PromotionModel;
use App\Models\ProductModel;

class IndexController extends BaseController {

    private  $productModel;
    private $promotionModel;
    private $categoryModel;

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);

        $this->promotionModel = new PromotionModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public  function  indexMethod() {

        return [
          'products' => $this->productModel->getLastProductsPreview(),
          'promotions' => array_slice($this->promotionModel->getPromotions(1), 0, 6)
        ];
    }

}