<?php
/**
 * Created by PhpStorm.
 * User: mhmd
 * Date: 3/26/2020
 * Time: 10:19 PM
 */
@define('REALPATH', @str_replace(array('\\', '/includes'), array('/', ''), @dirname(__FILE__)));
require_once(REALPATH.'/vendor/autoload.php');
$loader = new \Twig\Loader\FilesystemLoader(REALPATH.'/template');
$twig = new \Twig\Environment($loader);
// auto-register all native PHP functions as Twig functions
// don't try this at home as it's not secure at all!
$twig->registerUndefinedFunctionCallback(function ($name) {
    if (function_exists($name)) {
        return new Twig_SimpleFunction($name, $name);
    }
    return false;
});
$twig->registerUndefinedFilterCallback(function ($name) {
    if (function_exists($name)) {
        return new Twig_SimpleFilter($name, $name);
    }
    return false;
});


/**
 * Get GET input
 */
function get($key = null, $filter = FILTER_SANITIZE_MAGIC_QUOTES)
{
    if (!$key)
        return $filter ? filter_input_array(INPUT_GET, $filter) : $_GET;
    if (isset($_GET[$key]))
        return $filter ? filter_input(INPUT_GET, $key, $filter) : $_GET[$key];
}


/**
 * Get POST input
 */
function post($key = null, $filter = FILTER_SANITIZE_MAGIC_QUOTES)
{
    if (!$key)
        return $filter ? filter_input_array(INPUT_POST, $filter) : $_POST;
    if (isset($_POST[$key]))
        return $filter ? filter_input(INPUT_POST, $key, $filter) : $_POST[$key];
}