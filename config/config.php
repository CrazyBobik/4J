<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 26.08.2015
 * Time: 22:58
 */
defined('ENGINE') || define('ENGINE', realpath(ROOT.'/engine'));
defined('ENTITY') || define('ENTITY', realpath(ENGINE.'/entity'));
defined('DAO') || define('DAO', realpath(ENGINE.'/dao'));
defined('MODULES') || define('MODULES', realpath(ENGINE.'/modules'));
defined('MVC') || define('MVC', realpath(ROOT.'/system/mvc'));
defined('TPL') || define('TPL', realpath(ROOT.'/system/tpl'));
defined('TPL_GEN_TYPE') || define('TPL_GEN_TYPE', realpath(TPL.'/generation/type'));
defined('TPL_GEN_HMVC') || define('TPL_GEN_HMVC', realpath(TPL.'/generation/hmvc'));
defined('AJAX') || define('AJAX', realpath(ROOT.'/system/ajax'));
defined('ADMIN') || define('ADMIN', realpath(ROOT.'/system/admin'));
defined('SYSTEM') || define('SYSTEM', realpath(ROOT.'/system'));
defined('CONFIG') || define('CONFIG', realpath(ROOT.'/config'));

class Config{
	public static $DB = array(
		'host' => '127.0.0.1',
		'dbname' => 'mysite',
		'user' => 'mysite_db',
		'pass' => 'bFx3Bc07Laci'
	);

	public static $lang = 'ru';
}