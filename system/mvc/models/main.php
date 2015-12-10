<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 13.09.2015
 * Time: 23:25
 */
class Models_Main{
	public function routers($link){
		return false;
	}


	/**
	 * @param array $blocks
	 * @return array
	 */
	public function getBlocksHTML($blocks = null){
		if ($blocks == null){
			$blocks = $this->getBlocks('404');
		}
		$result = array('left' => '', 'center' => '', 'right' => '');

		$count = count($blocks);
		ob_start();
		for ($i = 0; $i < $count; $i++){
			$name = 'Controllers_Blocks_'.$blocks[$i]['name'];

			new $name;

			switch ($blocks[$i]['block_side']){
				case 'left':
					$result['left'] .= ob_get_clean();
					break;
				case 'right':
					$result['right'] .= ob_get_clean();
					break;
				default:
					$result['center'] .= ob_get_clean();
					break;
			}
		}
		ob_end_clean();

		return $result;
	}

	public function getBlocks($id){
		$tree = new DAO_Types_Block();
		$id = $id == '/' ? 'main' : $id;
		return $tree->getBlocksForPage($id);
	}
}