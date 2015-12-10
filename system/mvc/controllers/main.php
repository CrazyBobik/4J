<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 25.08.2015
 * Time: 22:46
 */
class Controllers_Main extends Controllers_Controller{
	private $blocks = array();
	/**
	 * Controllers_Main constructor.
	 */
	public function __construct(){
		$this->model = new Models_Main();

		parent::__construct();
	}

	public function index(){
		$link = Libs_URL::get()->getPath();

		if ($link === '/404'){
			header('HTTP/1.0 404 Not Found');

			$this->blocks = $this->model->getBlocksHTML();
		} else{
			$routing = $this->model->routers($link);
			if ($routing){
				$page = $routing;
			} else{
				$page = $link;
			}

			$page = $this->model->getBlocks($page);
			if (empty($page)){
				header('Location: /404');
			}

			$this->blocks = $this->model->getBlocksHTML($page);
		}

		$tpl = $this->getTPL('mainview');
		$html = str_replace(array('{left}', '{center}', '{right}'), array($this->blocks['left'], $this->blocks['center'], $this->blocks['right']), $tpl);
		$this->render($html);
	}
}