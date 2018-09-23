<?php
namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class UserController extends BaseController
{

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);
    }

    public function login($e_msg = null)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
          $data = [];
          switch ($e_msg) {
            case 'valid_error':
              $data['e_message'] = 'Valid error, check all input data.';
              break;
            case 'found_error':
              $data['e_message'] = "Profile haven't found.";
              break;
          }
          return $data;

        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['login']) && isset($_POST['password'])) {
                $user = $this->userModel->getUserByLogin($_POST['login']);

                if ($user) {
                    if ($user->password === $_POST['password']) {
                        $this->userModel->setCurrUser($user->id, 'backend');
                        $way = '/backend/';
                    }
                } else {
                  $way = '/backend/user/login/found_error';
                }
            } else {
                $way = '/backend/user/login/valid_error';
            }
            header("Location: $way");
        }
    }

    public function logout() {
      $this->userModel->clearCurrUser('backend');
      header('Location: /backend/user/login');
    }

    public function regist($e_msg = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = [];

            switch ($e_msg) {
              case 'valid_error':
                $data['e_message'] = 'Valid error, check all input data.';
                break;
              case 'database_error':
                $data['e_message'] = 'Something went wrong, repeat next time.';
                break;
            }
            return $data;

        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $way = '';
            $isValidUserData = isset($_POST['first_name'],
                                     $_POST['last_name'],
                                     $_POST['login'],
                                     $_POST['password'],
                                     $_POST['role']);
            $isValidEmail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); ;

            if($isValidUserData && $isValidEmail) {
               $isDone = $this->userModel->createUser($_POST);
               if (!$isDone) {
                  $way = '/backend/user/login/database_error';
               }
            } else {
               $way = '/backend/user/login/valid_error';
            }

            $way = $way ? '/backend/user/regist'.$way : '/backend/user/login';
            header("Location: $way");
        }
    }


}
