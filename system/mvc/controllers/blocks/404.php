<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 26.08.2015
 * Time: 22:02
 */

class Controllers_Blocks_404 extends Controllers_Controller{

	public function index(){
		$tpl = $this->getTPL('blocks/404');
		$html = $tpl;
		$this->render($html);
	}
}