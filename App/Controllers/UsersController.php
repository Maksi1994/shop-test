<?php
namespace App\Controllers;


class UsersController extends BaseController {

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);
    }


    public function login() {
        if (!empty($_POST['login']) &&
            !empty($_POST['password'])) {
            $user = $this->userModel->getUserByLogin($_POST['login']);

            if ($user) {
                if ($user->password === $_POST['password']) {

                    $this->userModel->setCurrUser($user->id);
                    header("Location: /");
                }
            } else {
                header("Location: /users/login");
            }
        }
    }

    public function logout() {
        $this->userModel->clearCurrUser();
        header("Location: /");
    }

    public function regist() {

    }
}
