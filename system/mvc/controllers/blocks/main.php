<?php

class Controllers_Blocks_Main extends Parents_Controller{

	public function __construct(){
		$tpl = $this->getTPL('blocks/main/main');
		$html = $tpl;
		$this->render($html);
	}
}