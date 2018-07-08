<?php
namespace App\Controllers;

use App\Models\ControllPromotionModel;
use App\Models\UserModel;

class ControllPromotionsController
{

    private $promotionModel;
    private $userModel;

    public function __construct()
    {
        $this->promotionModel = new ControllPromotionModel();
        $this->userModel = new UserModel();

        if (!$this->userModel->getCurrUser()) {
            header('location: /user/login');
            exit;
        }
    }

    public function showAll($page = 1)
    {
        $res = $this->promotionModel->getAllCount();
        $promotions = $this->promotionModel->getAll($page);

        return [
            'count' => ceil(((int) $res['count']) / 10),
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
        if (!empty($_POST['name']) &&
            !empty($_POST['percent']) &&
            !empty($_POST['description'])
        ) {
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
        if (!empty($_POST['id']) &&
            !empty($_POST['name']) &&
            !empty($_POST['percent']) &&
            !empty($_POST['description'])) {

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