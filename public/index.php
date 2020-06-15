<?php
/**
 * Created by PhpStorm.
 * User: Dell_PC
 * Date: 6/15/2020
 * Time: 21:01
 */
require __DIR__.'/../vendor/autoload.php';

$router = new AltoRouter();

// map homepage
$router->map('GET|POST', '/', function() {
    require __DIR__ . '/views/home.php';
});

$match = $router->match();
$params = $match['params'];
if (is_array($match)) {
    $match['target']($params);
} else {
    print "404";
}
