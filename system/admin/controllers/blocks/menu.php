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
        $level = $res[0]['level'];
        $fstLevel = $res[0]['level'];
		for($i = 0; $i < $cnt; $i++){
            if($res[$i]['level'] == $fstLevel && $res[$i]['level'] == $level){
                if($i > 0){
                    $menu .= '</div></div>';
                }
                $menu .= '<div class="menu">'
                        .'<div class="menu-item">'
                        .'<div class="add-tree-leaf" data-id="'.$res[$i]['id'].'">Add</div>'
                        .$res[$i]['title'];
            } else if($res[$i]['level'] >= $fstLevel){
                if ($res[$i]['level'] > $level){
                    $menu .= '<div class="toggle-menu">+</div></div>'
                            .'<div class="menu" style="display:none;">'
                            .'<div class="menu-item">'
                            .'<div class="add-tree-leaf" data-id="'.$res[$i]['id'].'">Add</div>'
                            .$res[$i]['title'];
                } else if ($res[$i]['level'] < $level){
                    $j = $level - $res[$i]['level'] + 1;
                    while ($j > 0){
                        $j--;
                        $menu .= '</div>';
                    }
                    $menu .= '<div class="menu-item">'
                            .'<div class="add-tree-leaf" data-id="'.$res[$i]['id'].'">Add</div>'
                            .$res[$i]['title'];
                } else{
                    $menu .= '</div><div class="menu-item">'
                            .'<div class="add-tree-leaf" data-id="'.$res[$i]['id'].'">Add</div>'
                            .$res[$i]['title'];
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

        $res = $this->treeDAO->getOne(Config::$lang);
        $menu .= '<div class="menu-item">'
                .'<div class="add-tree-leaf" data-id="'.$res['id'].'">Add</div></div>';

		$html = str_replace('{menu}', $menu, $tpl);
		$this->render($html);
	}

	public function getTPL($name){
		return file_get_contents(ADMIN.'/views/'.$name.'.tpl');
	}
}