<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 30.09.2015
 * Time: 22:09
 */
class Libs_BreadCrumbs{
	private $crumbs = array();
	private static $init = null;

	/**
	 * Libs_BreadCrumbs constructor.
	 */
	private function __construct(){
	}

	private function __clone(){
	}

	public static function init(){
		if (self::$init == null)
			self::$init = new self();

		return self::$init;
	}

	public function addCrumb($title, $link){
		if (isset($title) && !empty($title)){
			$this->crumbs[] = array('title' => $title, 'link' => $link);

			return true;
		}

		return false;
	}

	/**
	 * @return array
	 */
	public function getCrumbs($id = null){
		if ($id == null){
			return $this->crumbs;
		}

		return $this->crumbs[$id];
	}

	public function getCrumbsHTML(){
		$html = array();

		$count = count($this->crumbs);
		for ($i = 0; $i < $count; $i++){
			$tpl = file_get_contents(TPL.'/breadcrumb.tpl');

			$html[] = str_replace(
				array(
					'{link}',
					'{title}'
				),
				array(
					$this->crumbs[$i]['link'],
					$this->crumbs[$i]['title']
				), $tpl);
		}

		$html = implode('<span>>></span>', $html);
		$html = '<div class="breadcrumbs">'.$html.'</div>';
		return $html;
	}
}