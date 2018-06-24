<?php
namespace App\Controllers;

use App\Models\CategoriesModel;

class ControllCategoriesController {

    public function __construct()
    {
    }

    public function showAll() {
        $categoriesModel = new CategoriesModel();
        $categories = $categoriesModel->getAllCategories();
        $formedCategories = [];

        foreach($categories as $cat) {
            $formedCategories[$cat['parent_id']][$cat['id']] =  $cat;
        };

        return [
            'categories' => $formedCategories
        ];
    }

    public function showOne($id) {
        $categoriesModel = new CategoriesModel();
        $categories = $categoriesModel->getAllCategories();
        $category = $categoriesModel->getOneCategory($id);

        $formedCategories = [];

        foreach($categories as $cat) {
            $formedCategories[$cat['parent_id']][$cat['id']] =  $cat;
        };

        return [
            'allCategories' => $formedCategories,
            'category' => $category
        ];
    }

    public function editOne() {
        $categoriesModel = new CategoriesModel();
        $categoriesModel->updateCategory($_POST);

        header("location: /controllCategories/showOne/{$_POST['catId']}");
    }

    public function deleteOne($id) {
        $categoriesModel = new CategoriesModel();

        $categoriesModel->deleteOneCategory($id);

        header("location: /controllCategories/showAll");
    }
}