<?php
session_start();
defined('BASE_DIR') || define('BASE_DIR', __DIR__);
defined('DS') || define('DS', DIRECTORY_SEPARATOR);


require BASE_DIR . DS . 'db' . DS . 'DB.php';
require BASE_DIR . DS . 'class' . DS . 'User.php';
require BASE_DIR . DS . 'class' . DS . 'Validation.php';
require BASE_DIR . DS . 'class' . DS . 'Flash.php';

$errors = [];

$db = DB::getInstance();

$user = new User();
$valid = new Validation();

if ($_POST['func'] == 'register') {
    $valid->validateData(
        $_POST,
        [
            'email' => 'required, email',
            'password' => 'required, min:5'
        ]
    );
    $email = $_POST['email'];
    $pass = $_POST['password'];
    try {
        if (empty($valid->errors)) {
            $user->register($email, $pass);
        }
    } catch (Exception $e) {
        array_push($errors, $e->getMessage());
    }

    Flash::setWarning($valid->errors[0] ?? $errors[0]);
}
if ($_POST['func'] == 'login') {
    $valid->validateData(
        $_POST,
        [
            'email' => 'required, email',
            'password' => 'required'
        ]
    );
    $email = $_POST['email'];
    $pass = $_POST['password'];
    try {
        if (empty($valid->errors)) {
            $user->login($email, $pass);
        }
    } catch (Exception $e) {
        array_push($errors, $e->getMessage());
    }
    Flash::setWarning($valid->errors[0] ?? $errors[0]);
}
if ($_POST['func'] == 'logout') {
    $user->logout();
}

header("Location: /index.php");