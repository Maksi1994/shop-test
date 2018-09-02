<?php
namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\Backend\CategoryModel;

class CategoriesController extends BaseController
{
    private $categoryModel;

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);
        $this->categoryModel = new CategoryModel();
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
            header("location: /backend/categories/showOne/{$_POST['catId']}");
        } else {
            header("location: /backend/categories/showOne/{$_POST['catId']}/errorUpdate");
        }
    }

    public function deleteOne($id)
    {
        $this->categoryModel->deleteOneCategory($id);

        header("location: /backend/categories/showAll");
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
            header('location: /backend/categories/showAll');
        } else {
            header('location: /backend/categories/showFormAdd');
        }
    }
}