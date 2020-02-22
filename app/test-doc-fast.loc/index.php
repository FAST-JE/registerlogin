<?php
session_start();

defined('BASE_DIR') || define('BASE_DIR', __DIR__);
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

require dirname(BASE_DIR).DS.'vendor'.DS.'autoload.php';
//require BASE_DIR . DS . 'db'    . DS . 'DB.php';
//require BASE_DIR . DS . 'classes' . DS . 'User.php';
//require BASE_DIR . DS . 'classes' . DS . 'Validation.php';
//require BASE_DIR . DS . 'classes' . DS . 'Flash.php';

//\Dotenv\Dotenv::createImmutable(BASE_DIR . '/..')->load();

//define('BD_HOST', 'db');
//define('BD_USER', getenv('MYSQL_USER'));
//define('BD_PASS', getenv('MYSQL_PASSWORD'));
//define('BD_NAME', getenv('MYSQL_DATABASE'));
//define('DB_CHAR', 'utf8');



$db = App\Db\DB::getInstance();
$user = new App\Classes\User();
$valid = new App\Classes\Validation();

$routes = [
    '/'         => 'index',
    '/index'    => 'index',
    '/register' => 'register',
    '/login'    => 'login',
    '/handler'  => 'handler',
    '/logout'   => 'logout'
];


$route = $_SERVER['REQUEST_URI'];

//ob_start();

//if (array_key_exists($route, $routes)) {
//    include $routes[$route];
//} else {
//    echo '404 not found';
//}
//
//$content = ob_get_clean();

//require 'layouts'.DS.'main.php';


$templates = new League\Plates\Engine('views');

if (array_key_exists($route, $routes)) {
    echo $templates->render($routes[$route]);
} else {
    echo $templates->render('404', ['title' => 'Page not found']);
}
