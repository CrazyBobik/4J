<?php

class Admin_Controllers_Blocks_Head extends Controllers_Controller{

	public function index(){
		$tpl = $this->getTPL('blocks/head/head');
		$html = $tpl;
		$this->render($html);
	}

	public function getTPL($name){
		return file_get_contents(ADMIN.'/views/'.$name.'.tpl');
	}
}