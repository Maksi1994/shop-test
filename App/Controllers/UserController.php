<?php
namespace App\Controllers;
use App\Models\UserModel;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
                        $this->userModel->setCurrUser($user->id);
                        $way = '/';
                    }
                } else {
                  $way = '/user/login/found_error';
                }
            } else {
                $way = '/user/login/valid_error';
            }
            header("Location: $way");
        }
    }

    public function logout() {
      $this->userModel->clearCurrUser();
      header('Location: /user/login');
    }

    public function regist($e_msg = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = [];
            $data['roles'] = $this->userModel->getAllRoles();
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
                  $way = '/database_error';
               }
            } else {
               $way = '/valid_error';
            }

            $way = $way ? '/user/regist'.$way : '/user/login';
            header("Location: $way");
        }
    }


}
