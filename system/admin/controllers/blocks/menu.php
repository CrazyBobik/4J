<?php

class Admin_Controllers_Blocks_Menu extends Controllers_Controller{

	private $treeDAO;

	/**
	 * Admin_Controllers_Blocks_Menu constructor.
	 */
	public function __construct(){
		$this->treeDAO = new DAO_Tree();
		parent::__construct();
	}

	public function index(){
		$tpl = $this->getTPL('blocks/menu/menu');
		$menu = '';

		$res = $this->treeDAO->getChild(Config::$lang);
		$cnt = count($res);
		for($i = 0; $i < $cnt; $i++){

		}

		$html = $tpl;
		$this->render($html);
	}

	public function getTPL($name){
		return file_get_contents(ADMIN.'/views/'.$name.'.tpl');
	}
}