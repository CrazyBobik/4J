<?php
//$start = microtime(true);
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 23.08.2015
 * Time: 20:38
 */
defined('ROOT') || define('ROOT', realpath(dirname(__FILE__).'/..'));
require_once ROOT.'/engine/bootstrap.php';
require_once ROOT.'/config/config.php';

Bootstrap::init()->start();

//echo "\r\n".round(microtime(true) - $start, 3);
/*
 * INSERT INTO site_tree SET left_key = $right_key, right_key = $right_key + 1, level = $level + 1, title='404', name='404', type='page', pid=2
 * UPDATE site_tree SET right_key = right_key + 2, left_key = IF(left_key > $right_key, left_key + 2, left_key) WHERE right_key >= $right_key
 *
  INSERT INTO site_tree SET left_key = 10, right_key = 10 + 1, level = 3 + 1,
				title='404', name='404', type='block', pid=6
  UPDATE site_tree SET right_key = right_key + 2,
  					   left_key = IF(left_key > 10, left_key + 2, left_key)
  WHERE right_key >= 10
 * */

//TODO: админку

//TODO: дизайн сайта
//TODO: работа с картинками-->1
//TODO:-->2 работа с видео


//TODO: (должна быть отдельно)
//TODO:-->1 языки -->2
//TODO: регистрацию
//TODO: кабинет
//TODO: корзину для магазина
//TODO: коментарии
//TODO: новости

//TODO: содзать шаблоны для визиток, многостраничных сайтов, магазина
//TODO: (в каждом можно менять цвет через css тоесть все цвета вынести в отдельный css
//TODO: сделать штук 10 с разными цветами)

//TODO: патчинг
//TODO: проверить breadcrumb в гугле

