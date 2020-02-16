<?php
session_start();
defined('BASE_DIR') || define('BASE_DIR', __DIR__);
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

require dirname(BASE_DIR).DS.'vendor'.DS.'autoload.php';
require BASE_DIR . DS . 'db' . DS . 'DB.php';
require BASE_DIR . DS . 'class' . DS . 'User.php';
require BASE_DIR . DS . 'class' . DS . 'Validation.php';
require BASE_DIR . DS . 'class' . DS . 'Flash.php';

\Dotenv\Dotenv::createImmutable(BASE_DIR . '/..')->load();

//define('BD_HOST', 'db');
//define('BD_USER', getenv('MYSQL_USER'));
//define('BD_PASS', getenv('MYSQL_PASSWORD'));
//define('BD_NAME', getenv('MYSQL_DATABASE'));
//define('DB_CHAR', 'utf8');


//Flash::setWarning("email is not valid");


//var_dump(Flash::getMessageText());

//if (isset($_POST['func'])) {
//    echo 'func exist';
//}
//$errors = [];

//print_r($_POST);

$db = DB::getInstance();

$user = new User();
//$valid = new Validation();

//if ($_POST['func'] == 'register') {
//    $valid->validateData(
//        $_POST,
//        [
//            'email' => 'required, email',
//            'password' => 'required, min:5'
//        ]
//    );
//    $email = $_POST['email'];
//    $pass = $_POST['password'];
//    try {
//        if (empty($valid->errors)) {
//            $user->register($email, $pass);
//        }
//    } catch (Exception $e) {
//        array_push($errors, $e->getMessage());
//    }
//
//    Flash::setWarning($valid->errors[0] ?? $errors[0]);
//    header("Location: /index.php");
//}
//if ($_POST['func'] == 'login') {
//    $valid->validateData(
//        $_POST,
//        [
//            'email' => 'required, email',
//            'password' => 'required'
//        ]
//    );
//    $email = $_POST['email'];
//    $pass = $_POST['password'];
//    try {
//        if (empty($valid->errors)) {
//            $user->login($email, $pass);
//        }
//    } catch (Exception $e) {
//        array_push($errors, $e->getMessage());
//    }
//    Flash::setWarning($valid->errors[0] ?? $errors[0]);
//    header("Location: /index.php");
//}
//if ($_POST['func'] == 'logout') {
//    $user->logout();
//}

//if ($_POST['func'] != 'register' && $_POST['func'] != 'login') {
//    if (Flash::getMessageType() == 3) {
//        echo "<h1 style='color: red;'>".Flash::getMessageText()."</h1>";
//    }
//}

if (Flash::getMessageType() == 3) {
    echo "<h1 style='color: red;'>".Flash::getMessageText()."</h1>";
}


?>
<? if (!$user->isLogged()) { ?>
<h1>Register</h1>
<form action="/handler.php" method="POST">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="hidden" name="func" value="register">
    <input type="submit">
</form>
<hr>
<h1>Вход</h1>
<form action="/handler.php" method="POST">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="hidden" name="func" value="login">
    <input type="submit">
</form>
<? } ?>
<? if ($user->isLogged()) { ?>
    <h1>logged</h1>
    <form action="/handler.php" method="POST">
        <input type="hidden" name="func" value="logout">
        <input type="submit" value="logout">
    </form>
<? } ?>

