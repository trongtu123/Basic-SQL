<?php
ob_start();
session_start();

$get = !empty($_GET['mod']) ? $_GET['mod'] : 'RegisterPdo';
$path = $get . '.php';
if (isset($_COOKIE['is_login'])) {
    $_SESSION['is_login'] = $_COOKIE['is_login'];
    $_SESSION['mail'] = $_COOKIE['mail'];
}

if (file_exists($path)) {
    require "{$path}";
}
