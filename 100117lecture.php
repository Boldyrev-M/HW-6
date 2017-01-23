<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 10.01.2017
 * Time: 17:17
 */
define( 'ADMIN_LOGIN', 'admin');
define( 'ADMIN_PASSWORD', 'admin');

$isAuth = isset($_SERVER['PHP_AUTH_USER']) || isset(($_SERVER["PHP_AUTH_PW"])));

$isValidUser = $_SERVER["PHP_AUTH_USER"] ==ADMIN_LOGIN;
$isValidUser = $isValidUser && $_SERVER["PHP_AUTH_PW"] == ADMIN_PASSWORD;

if (!$isAuth || !$isValidUser) {
    header('WWW-Authenticate: Basic realm="MyRealm"');
        die;
}

редирект
haeader ('Location: index.php');
function getErrors() {
    
}