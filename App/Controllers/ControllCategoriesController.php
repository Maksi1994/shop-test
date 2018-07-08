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

        return [
            'allCategrories' => $allCategrories
        ];
    }

    public function addCategory()
    {
        $isUploaded = $_FILES['photo']['error'] === \UPLOAD_ERR_OK;

        if ($isUploaded &&
            !empty($_POST['name'])) {

            $photoName = time() . $_FILES['photo']['name'];
            $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/categories';

            $isUploadedPhoto = move_uploaded_file($_FILES['photo']['tmp_name'], "$uploadsDir/$photoName");

            if ($isUploadedPhoto) {
                $_POST['photo'] = $photoName;
                $isSavedData = $this->categoryModel->addCategory($_POST);
            }
        }

        if ($isUploadedPhoto && $isSavedData) {
            header('location: /controllCategories/showAll');
        } else {
            header('location: /controllCategories/showFormAdd');
        }
    }
}