<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 02.01.2016
 * Time: 23:03
 */
class Admin_Controllers_Tree extends Ajax{


    /**
     * Admin_Controllers_Tree constructor.
     */
    public function __construct($isAjax = true){
        parent::__construct($isAjax);
    }

    public function getAddLeafForm(){
        $tpl = $this->getTPL('tree/add_leaf');

        $toReplace = array(
            '{pid}',
            '{id}',
            '{title}',
            '{name}',
            '{option}'
        );
        $option = '<option value="">Выбрать</option>';

        $typeModel = new Admin_Models_Type();
        $res = $typeModel->getAllTypes();
        $cnt = count($res);
        for($i = 0; $i < $cnt; $i++){
            $entity = new Entity_Type($res[$i]);
            $option .= '<option value="'.$entity->getName().'">'.$entity->getTitle().'</option>';
        }

        $replace = array(
            intval($_POST['pid']),
            'select-type-leaf',
            'Выберите тип элемента',
            '',
            $option
        );
        $result = str_replace($toReplace, $replace, $tpl);

        $this->putAjax($result);
    }

    public function getTPL($name){
        return file_get_contents(ADMIN.'/views/'.$name.'.tpl');
    }
}