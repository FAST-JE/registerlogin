<?php


class User
{
    public function register ($email, $password)
    {
        if ($this->emailExist($email)) throw new \Exception("This email already exists");
        $user_hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `users` (`email`, `password`) VALUES(:email, :password)";

        $args = [
            'email' => $email,
            'password' => $user_hashed_password,
        ];

        DB::sql($query, $args);

        return true;
    }

    public function login($email, $password)
    {
        $data = DB::getRow("SELECT * FROM `users` WHERE `email` = ?", [$email]);
        if (!empty($data) && password_verify($password, $data['password'])) {
            $_SESSION['user_id'] = $data['id'];
        } else {
            throw new \Exception("Email or password incorrect");
        }
        return true;
    }

    public function isLogged()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
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
        return DB::getRow("SELECT `id` FROM `users` WHERE `email` = ? LIMIT 1", [$email]) ? true : false;
    }
}