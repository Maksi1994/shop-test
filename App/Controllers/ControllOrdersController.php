<?php

namespace App\Controllers;

use App\Models\OrderModel;

class ControllOrdersController
{

    public function __construct()
    {
    }

    public function showAll($page = 1)
    {
        $orderModel = new OrderModel();
        $list = $orderModel->getAll($page);
        $count = $orderModel->getCount();

        return [
            'list' => $list,
            'page' => $page,
            'count' => $count
        ];
    }

    public function showOne($id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->getOne($id);
        $order['products'] = $orderModel->getOrderProducts($id);

        return $order;
    }


    public function updateOrder()
    {
        $orderModel = new OrderModel();
        $deletedProducts = [];
        $sucess = false;

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

        $sucess = $orderModel->updateOne($_POST);
        $sucess = $orderModel->setOrderProducts($_POST['id'], $deletedProducts);

        if ($sucess) {
            header("location: /controllOrders/showOne/{$_POST['id']}");
        } else {
            header("location: /controllOrders/showOne/{$_POST['id']}/errorUpdate");
        }
    }

    public function deleteOne($id)
    {
        $orderModel = new OrderModel();
        $orderModel->deleteOne($id);

        header("location: /controllOrders/showAll/1");
    }
}