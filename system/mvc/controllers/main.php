<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 25.08.2015
 * Time: 22:46
 */
class Controllers_Main extends Parents_Controller{
	private $blocks = array();
	/**
	 * Controllers_Main constructor.
	 */
	public function __construct(){
		$this->model = new Models_Main();

		$link = Libs_URL::get()->getPath();

		if ($link === '/404'){
			$this->notFoundPage();
		} else{
			$routing = $this->model->routers($link);
			if ($routing){
				$page = $routing;
			} else{
				$page = $link;
			}

			$page = $this->model->getBlocks($page);
			if (empty($page)){
				$this->notFoundPage();
			} else{
				$this->blocks = $this->model->getBlocksHTML($page);
			}
		}

		$tpl = $this->getTPL('mainview');
		$html = str_replace(array('{left}', '{center}', '{right}'), array($this->blocks['left'], $this->blocks['center'], $this->blocks['right']), $tpl);
		$this->render($html);
	}

	public function notFoundPage(){
		header('HTTP/1.0 404 Not Found');

		$this->blocks = $this->model->getBlocksHTML();
	}
}