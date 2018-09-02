<?php
namespace App\Controllers\Backend;

use App\Models\Backend\PromotionModel;
use App\Controllers\BaseController;

class PromotionsController extends BaseController
{

    private $promotionModel;

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);
        $this->promotionModel = new PromotionModel();
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
            header('location: /backend/promotions/showAll');
        } else {
            header('location: /backend/promotions/showFormAdd');
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
            header("location: /backend/promotions/showOne/{$_POST['id']}/errorUpdate");
        } else {
            header("location: /backend/promotions/showOne/{$_POST['id']}");
        }
    }

    public function deleteOne($id)
    {
        $this->promotionModel->deleteOne($id);
        header('location: /backend/promotions/showAll');
    }


}