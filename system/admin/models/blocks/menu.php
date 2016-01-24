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

        $tmp = $this->genMenu($res, 0, count($res));
        $menu = $tmp[0];

        return $menu;
    }

    public function genMenu(&$res, $i, $cnt){
        $menu = '';
        $subMenu = '';

        $leaf = new Entity_Tree();
        $leaf->init($res[$i]);
        $next = new Entity_Tree();
        $j = $i + 1;
        if($j <= $cnt){
            $next->init($res[$j]);
        } else{
            return array('', $i);
        }
        if($next->getPid() == $leaf->getId()){
            $tmp = $this->genMenu($res, $j, $cnt);
            $subMenu = '<div class="sub-menu">'.$tmp[0].'</div>';
            $j = $tmp[1];
        }
        $fa = $leaf->getLevel() == 2 ? $this->getMainFaClass($leaf->getName())
                                     : $this->getFaClass($leaf->getType());
        $menu .= $this->genOnePoint($leaf, $fa, 'update-tree-leaf', $subMenu);
        $next->init($res[$j]);
        if($next->getPid() == $leaf->getPid()){
            $tmp = $this->genMenu($res, $j, $cnt);
            $menu .= $tmp[0];
            $j = $tmp[1];
        }

        return array($menu, $j);
    }

    public function genAddField(){
        $res = new Entity_Tree();
        $res->init($this->treeDAO->getOne(Config::$lang));
        $res->setTitle('Новый элемент');

        return $this->genOnePoint($res, 'fa-plus', 'add-tree-leaf');
    }

    /**
     * @param Entity_Tree $leaf
     * @param string $fa
     * @param string $clazz
     * @return string
     */
    private function genOnePoint(&$leaf, $fa = '', $clazz = '', $subMenu = ''){
        $toggle = '<div class="toggle-sub-menu float-right"><i class="fa fa-chevron-down"></i></div>';
        $toReplace = array(
            '{class}',
            '{id}',
            '{type}',
            '{faIcon}',
            '{title}',
            '{toggle}',
            '{subMenu}'
        );
        $replace = array(
            $clazz,
            $leaf->getId(),
            $leaf->getType(),
            $fa,
            $leaf->getTitle(),
            $subMenu === '' ? '' : $toggle,
            $subMenu
        );
        $file = file_get_contents(ADMIN.'/views/blocks/menu/one-item.tpl');

        return str_replace($toReplace, $replace, $file);
    }

    private function getFaClass($name){
        $fa = array(
            'item' => 'fa-list',
            'block' => 'fa-th-large',
            'page' => 'fa-file-text-o'
        );

        return $fa[$name];
    }

    private function getMainFaClass($name){
        $fa = array(
            'pages' => 'fa-list-alt'
        );

        return $fa[$name];
    }
}