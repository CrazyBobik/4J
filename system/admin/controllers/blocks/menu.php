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
        $res = array(
            array('level' => 1, 'title' => 'level 1'),
            array('level' => 2, 'title' => 'level 2'),
            array('level' => 2, 'title' => 'level 2'),
            array('level' => 3, 'title' => 'level 3'),
            array('level' => 3, 'title' => 'level 3'),
            array('level' => 2, 'title' => 'level 2'),
            array('level' => 3, 'title' => 'level 3'),
            array('level' => 3, 'title' => 'level 3'),
            array('level' => 4, 'title' => 'level 4'),
            array('level' => 5, 'title' => 'level 5'),
            array('level' => 5, 'title' => 'level 5'),
            array('level' => 1, 'title' => 'level 1'),
            array('level' => 2, 'title' => 'level 2'),
            array('level' => 3, 'title' => 'level 3')
        );
		$cnt = count($res);
        $level = $res[0]['level'];
        $fstLevel = $res[0]['level'];
		for($i = 0; $i < $cnt; $i++){
            if($res[$i]['level'] == $fstLevel && $res[$i]['level'] == $level){
                if($i > 0){
                    $menu .= '</div></div>';
                }
                $menu .= '<div class="menu">'
                        .'<div class="menu-item">'.$res[$i]['title'];
            } else if($res[$i]['level'] >= $fstLevel){
                if ($res[$i]['level'] > $level){
                    $menu .= '<div class="toggle-menu">+</div></div>'
                            .'<div class="menu" style="display:none;">'
                            .'<div class="menu-item">'.$res[$i]['title'];
                } else if ($res[$i]['level'] < $level){
                    $j = $level - $res[$i]['level'] + 1;
                    while ($j > 0){
                        $j--;
                        $menu .= '</div>';
                    }
                    $menu .= '<div class="menu-item">'.$res[$i]['title'];
                } else{
                    $menu .= '</div><div class="menu-item">'.$res[$i]['title'];
                }
            } else{
                throw new ErrorException('Level can\'t be less first level');
            }
            $level = $res[$i]['level'];
		}
        $menu .= '</div>';

		$html = str_replace('{menu}', $menu, $tpl);
		$this->render($html);
	}

	public function getTPL($name){
		return file_get_contents(ADMIN.'/views/'.$name.'.tpl');
	}
}