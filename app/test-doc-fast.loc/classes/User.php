<?php

namespace App\Classes;
use App\Db\DB;

class User
{
    public function register ($email, $password)
    {
        if ($this->emailExist($email)) {
            return ['email'=>'This email already exist'];
        }

        $user_hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `users` (`email`, `password`) VALUES(:email, :password)";

        $args = [
            'email' => $email,
            'password' => $user_hashed_password,
        ];

        \App\Db\DB::sql($query, $args);

        return '';
    }

    public function login($email, $password)
    {
        $data = \App\Db\DB::getRow("SELECT * FROM `users` WHERE `email` = ?", [$email]);
        if (!empty($data) && password_verify($password, $data['password'])) {
            $_SESSION['user_id'] = $data['id'];
        } else {
            return ['error'=>'Email or password incorrect'];
        }
        return '';
    }

    public function isLogged()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return '';
        }
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION['user_id']);
        return true;
    }


    public function emailExist ($email)
    {
        return \App\Db\DB::getRow("SELECT `id` FROM `users` WHERE `email` = ? LIMIT 1", [$email]) ? true : false;
    }
}