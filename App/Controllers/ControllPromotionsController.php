<?php

namespace App\Controllers;

use App\Models\ControllPromotionModel;

class ControllPromotionsController
{

    private $promotionModel;

    public function __construct()
    {
        $this->promotionModel = new ControllPromotionModel();
    }

    public function showAll($page = 1)
    {
        $total = $this->promotionModel->getAllCount();
        $promotions = $this->promotionModel->getAll($page);


        return [
            'count' => ceil(((int)$total) / 10),
            'promotions' => $promotions,
            'page' => $page
        ];
    }

    public function showOne($id)
    {
        $promotion = $this->promotionModel->getOne($id);

        return [
            'promotion' => $promotion
        ];
    }

    public function addOne()
    {
        if (isset(
            $_POST['name'],
            $_POST['percent'],
            $_POST['description']
        )) {
            $isSuccess = $this->promotionModel->createOne($_POST);
        }

        if ($isSuccess) {
            header('location: /controllPromotions/showAll');
        } else {
            header('location: /controllPromotions/showFormAdd');
        }
    }

    public function editOne()
    {
        if (isset(
            $_POST['id'],
            $_POST['name'],
            $_POST['percent'],
            $_POST['description']
        )) {

            $isSucess = $this->promotionModel->editOne($_POST);
        }

        if ($isSucess) {
            header("location: /controllPromotions/showOne/{$_POST['id']}/errorUpdate");
        } else {
            header("location: /controllPromotions/showOne/{$_POST['id']}");
        }
    }

    public function deleteOne($id)
    {
        $this->promotionModel->deleteOne($id);
        header('location: /controllPromotions/showAll');
    }


}