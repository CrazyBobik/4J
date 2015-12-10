<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 04.10.2015
 * Time: 2:55
 */
class Test extends Ajax{

	public function funcTest(){
//		$result['messID'] = '#mess';
//		$result['error'] = true;
		$result['mess'] = 'вернулся текст';
//		$result['callback'] = 'hideForm();';
//		$result['redirect'] = '/sss';
//		$result['tout'] = 0;

		$this->putJSON($result);
	}
}