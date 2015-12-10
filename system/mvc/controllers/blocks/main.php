<?php

class Controllers_Blocks_Main extends Controllers_Controller{

	public function index(){
		$tpl = $this->getTPL('blocks/main');
		$html = $tpl;
		$this->render($html);
	}
}