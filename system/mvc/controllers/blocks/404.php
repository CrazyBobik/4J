<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 26.08.2015
 * Time: 22:02
 */
class Controllers_Blocks_404 extends Parents_Controller{

	public function __construct(){
		$tpl = $this->getTPL('blocks/404/404');
		$html = $tpl;
		$this->render($html);
	}
}