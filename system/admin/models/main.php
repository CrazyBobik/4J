<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 11.10.2015
 * Time: 13:11
 */
class Admin_Models_Main{
	/**
	 * @param $link
	 * @return mixed
     */
	public function routers($link){
		$link = rtrim($link, '\/');
		$blocks = array();

		if ($link == '/admin/exit'){
			Libs_Session::start()->deleteParam('admin_id');

			header('Location: /admin');
			exit();
		}
		if ($link == '/admin'){
			$blocks[] = array('name' => 'Blocks_Center', 'side' => 'center');
			return $blocks;
		}

		return false;
	}

	public function getBlocks($blocks){
		$result = array();

		$count = count($blocks);
		for ($i = 0; $i < $count; $i++){
			$name = 'Admin_Controllers_'.$blocks[$i]['name'];

			ob_start();
			new $name();

			switch ($blocks[$i]['side']){
				case 'header':
					$result[0] .= ob_get_clean();
					break;
				case 'left':
					$result[1] .= ob_get_clean();
					break;
				case 'right':
					$result[3] .= ob_get_clean();
					break;
				case 'footer':
					$result[4] .= ob_get_clean();
					break;
				default:
					$result[2] .= ob_get_clean();
					break;
			}
			ob_end_clean();
		}

		return $result;
	}

	public function correctAddr(){
		$link = Libs_URL::get()->getPiceURL(1);

		if (class_exists('Admin_Controllers_'.$link)){
			return 'Admin_Controllers_'.$link;
		} else if (class_exists('Admin_Controllers_Types_'.$link)){
			return 'Admin_Controllers_Types_'.$link;
		} else if (class_exists('Admin_Controllers_Blocks_'.$link)){
			return 'Admin_Controllers_Blocks_'.$link;
		}

		return false;
	}
}