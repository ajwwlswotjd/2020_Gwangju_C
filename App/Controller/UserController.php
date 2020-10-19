<?php

namespace Gondr\Controller;

use Gondr\Lib;

class UserController extends MasterController {

    public function logout()
    {
        unset($_SESSION['user']);
        Lib::back(null);
    }

    public function login()
    {

        Lib::validate( $_POST , ["id","password"] );

        $id = $_POST['id'];
        $pwd = $_POST['password'];

        if($id === "admin" && $pwd === "admin")
        {
            Lib::move('/' , '로그인 완료');
            $_SESSION['user'] = true;
        }
        else
        {
            Lib::back('로그인 실패 ㅋㅋ');
        }


        // var_dump($_POST);
    }

}