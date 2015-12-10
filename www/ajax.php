<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 04.10.2015
 * Time: 2:17
 */
defined('ROOT') || define('ROOT', realpath(dirname(__FILE__).'/..'));
require_once ROOT.'/engine/bootstrap.php';
require_once ROOT.'/config/config.php';

Bootstrap::init()->autoLoader();

$path = Libs_URL::get()->getParseURL();
$file = ROOT.'/system/ajax/'.$path[1].'.php';

if (file_exists($file)){
	require_once $file;

	$controller = new $path[1]();
	$controller->$path[2]();
} else {
	header('Location: /404');
}