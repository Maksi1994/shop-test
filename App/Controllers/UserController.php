<?php
namespace App\Controllers;
use App\Models\UserModel;

class UserController
{

    public function login($e_msg = null)
    {
        $userModel = new UserModel;

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
            $way;
            if (isset($_POST['login']) && isset($_POST['password'])) {
                $user = $userModel->getUserByLogin($_POST['login']);
                if ($user) {
                    if ($user->password === $_POST['password']) {
                        $userModel->setCurrUser($user->id);
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
      $userModel = new UserModel;

      $userModel->clearCurrUser();
      header('Location: /user/login');
    }

    public function regist($e_msg = null)
    {
      $userModel = new UserModel;

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = [];
            $data['roles'] = $userModel->getAllRoles();
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
            $way;
            $isValidUserData = isset($_POST['first_name'],
                                     $_POST['last_name'],
                                     $_POST['login'],
                                     $_POST['password'],
                                     $_POST['role']);
            $isValidEmail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); ;

            if($isValidUserData && $isValidEmail) {
               $isDone = $userModel->createUser($_POST);
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
