<?php
namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class IndexController extends BaseController {

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);
    }

    public function indexMethod() {
        header('location: /backend/products/showAll');
    }
}