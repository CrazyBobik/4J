<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 20.01.2016
 * Time: 17:47
 */
class Admin_Models_Blocks_Menu{
	private $treeDAO;

	/**
	 * Admin_Models_Blocks_Menu constructor.
	 */
	public function __construct(){
		$this->treeDAO = new DAO_Tree();
	}

	public function genMenuHTML(){
		$res = $this->treeDAO->getChild(Config::$lang);

		$menu = '';
		$cnt = count($res);
		$level = $res[0]['level'];
		$fstLevel = $res[0]['level'];
		for($i = 0; $i < $cnt; $i++){
			$leaf = new Entity_Tree();
			$leaf->init($res[$i]);
			if($leaf->getLevel() == $fstLevel && $leaf->getLevel() == $level){
				if($i > 0){
					$menu .= '</div></div>';
				}
				$menu .= '<div class="menu">'
					.$this->genOnePoint($leaf);
			} else if($leaf->getLevel() >= $fstLevel){
				if ($leaf->getLevel() > $level){
					$menu .= '<div class="toggle-menu">+</div></div>'
						.'<div class="menu" style="display:none;">'
						.$this->genOnePoint($leaf);
				} else if ($leaf->getLevel() < $level){
					$j = $level - $leaf->getLevel() + 1;
					while ($j > 0){
						$j--;
						$menu .= '</div>';
					}
					$menu .= $this->genOnePoint($leaf);
				} else{
					$menu .= '</div>'.$this->genOnePoint($leaf);
				}
			} else{
				throw new ErrorException('Level can\'t be less first level');
			}
			$level = $res[$i]['level'];
		}
		$j = $level;
		while ($j > 0){
			$j--;
			$menu .= '</div>';
		}

		$res = new Entity_Tree();
		$res->init($this->treeDAO->getOne(Config::$lang));
		$menu .= '<div class="menu-item" data-id="'.$res->getId().'"
                                data-type="'.$res->getType().'">'
			.'<div class="add-tree-leaf">Add</div></div>';

		return $menu;
	}

	/**
	 * @param Entity_Tree $leaf
	 * @return string
	 */
	private function genOnePoint(&$leaf){
		return '<div class="menu-item" data-id="'.$leaf->getId().'"
                                data-type="'.$leaf->getType().'">'
		.'<div class="add-tree-leaf">Add</div>'
		.'<div class="del-tree-leaf" style="background:#0f0">del</div>'
		.'<div class="update-tree-leaf">'.$leaf->getTitle().'</div>';
	}
}