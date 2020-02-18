<?php
$errors = [];
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
    if (empty($valid->errors)) {
        $errors = $user->register($email, $pass);
    }
    $errors = array_merge($valid->errors, $errors);
    foreach ($errors as $field=>$error) {
        if (!empty($error))
            App\Classes\Flash::set($field, $error);
    }
    header("Location: /register");
}
if ($_POST['func'] == 'login') {
    $valid->validateData(
        $_POST,
        [
            'email' => 'required, email',
            'password' => 'required, min:5'
        ]
    );
    $email = $_POST['email'];
    $pass = $_POST['password'];
    if (empty($valid->errors)) {
        $errors = $user->login($email, $pass);
    }
    $errors = array_merge($valid->errors, $errors);
    foreach ($errors as $field=>$error) {
        if (!empty($error))
            App\Classes\Flash::set($field, $error);
    }
//    var_dump($errors);
    header("Location: /login");
}
if ($_POST['func'] == 'logout') {
    $user->logout();
    header("Location: /index");
}