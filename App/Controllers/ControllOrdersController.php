<?php

namespace App\Controllers;

use App\Models\ControllOrderModel;
use App\Models\UserModel;

class ControllOrdersController
{

    public function __construct()
    {

        $this->orderModel = new ControllOrderModel();
        $this->userModel = new UserModel();

        if (!$this->userModel->getCurrUser()) {
            header('location: /user/login');
            exit;
        }
    }
    
    public function addOne() {
        if (!empty('customer_name') &&
           !empty('customer_email')
           !empty('status')) {
            $orderId = $this->orderModel->saveOrder($_POST);
            
            if ($orderId !== false) {
                $_POST['orderId'];
                $this->orderModel->saveOrder($_POST);
            }
        }
        
        echo "{success: $isSuccess}";
    }

    public function showAll($page = 1)
    {
        $list = $this->orderModel->getAll($page);
        $count = $this->orderModel->getCount();

        return [
            'list' => $list,
            'page' => $page,
            'count' => $count
        ];
    }

    public function showOne($id)
    {
        $order = $this->orderModel->getOne($id);
        $order['products'] = $this->orderModel->getOrderProducts($id);

        return $order;
    }


    public function updateOrder()
    {
        $deletedProducts = [];

        foreach ($_POST as $key => $val) {
            if (strpos($key, 'product=') === 0) {
                $productId = explode('=', $key)[1];
                $productInfo = [
                    'id' => $productId,
                    'count' => $_POST['productCount=' . $productId],
                    'price_for_one' => $_POST['productPrice=' . $productId]
                ];
                $deletedProducts[] = $productInfo;
            }
        }

        if (count($deletedProducts) > 0) {
            $updatedProduct = $this->orderModel->updateOne($_POST);
            $updatetOrderCount = $this->orderModel->setOrderProducts($_POST['id'], $deletedProducts);
        } else {
            $this->deleteOne($_POST['id']);
            exit;
        }

        if ($updatedProduct && $updatetOrderCount) {
            header("location: /controllOrders/showOne/{$_POST['id']}");
        } else {
            header("location: /controllOrders/showOne/{$_POST['id']}/errorUpdate");
        }
    }

    public function deleteOne($id)
    {
        $this->orderModel->deleteOne($id);
        header("location: /controllOrders/showAll");
    }
}