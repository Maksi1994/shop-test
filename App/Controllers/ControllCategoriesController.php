<?php
namespace App\Controllers;

use App\Models\ControllCategoryModel;
use App\Models\UserModel;

class ControllCategoriesController
{
    private $categoryModel;
    private $userModel;

    public function __construct()
    {

        $this->categoryModel = new ControllCategoryModel();
        $this->userModel = new UserModel();

        if (!$this->userModel->getCurrUser()) {
            header('location: /user/login');
            exit;
        }
    }

    public function showAll()
    {
        $categories = $this->categoryModel->getAllCategories();

        return [
            'categories' => $categories
        ];
    }

    public function showOne($id)
    {
        $categories = $this->categoryModel->getAllCategories($id);
        $category = $this->categoryModel->getOneCategory($id);

        return [
            'possibleParents' => $categories['filtered'],
            'allCategories' => $categories['all'],
            'category' => $category
        ];
    }

    public function editOne()
    {
        if (!empty($_POST['name']) &&
            !empty($_POST['catId'])) {
            $isUpdated = $this->categoryModel->updateCategory($_POST);
        }

        if ($isUpdated) {
            header("location: /controllCategories/showOne/{$_POST['catId']}");
        } else {
            header("location: /controllCategories/showOne/{$_POST['catId']}/errorUpdate");
        }
    }

    public function deleteOne($id)
    {
        $this->categoryModel->deleteOneCategory($id);

        header("location: /controllCategories/showAll");
    }

    public function showFormAdd()
    {
        $allCategrories = $this->categoryModel->getAllCategories();
        $icons  = $this->categoryModel->getCategoriesIcons();

        return [
            'allCategrories' => $allCategrories,
            'icons' => $icons
        ];
    }

    public function addCategory()
    {
        if (!empty($_POST['photoName']) &&
            !empty($_POST['name'])) {
            $allIcons = $this->categoryModel->getCategoriesIcons();            
            $isValidPhoto = in_array($_POST['photoName'], $allIcons);
            
            if ($isValidPhoto) {
                 $isSuccess = $this->categoryModel->addCategory($_POST);
            }
        }

        if ($isSuccess) {
            header('location: /controllCategories/showAll');
        } else {
            header('location: /controllCategories/showFormAdd');
        }
    }
}