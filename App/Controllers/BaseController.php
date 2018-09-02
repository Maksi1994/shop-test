<?php

namespace App\Controllers;

use App\Models\UserModel;

class  BaseController
{
    protected $routerInfo;
    protected $userModel;
    protected $user;

    public function __construct($routerInfo)
    {
        $this->routerInfo = $routerInfo;
        $this->userModel = new UserModel();
        $this->checkAccess();
    }


    private function checkAccess()
    {
        $user = $this->userModel->getCurrUser();

        if ($this->routerInfo->controller === 'User') {
            return;
        }

        if ($this->routerInfo->sitePart === 'backend') {
            if (!$user) {
                header('location: /backend/user/login');
                exit;
            } else if ($user['role'] === 'admin') {
                $this->user = $user;
            }
        } else {
            if (!$user) {
                header('location: /user/login');
            }
        }
    }
}
