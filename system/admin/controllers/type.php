<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 10.12.2015
 * Time: 21:03
 */
class Admin_Controllers_Type extends Ajax{

    /**
     * @var Admin_Models_Type
     */
    private $typeModel;

    public function __construct($isAjax = true){
        parent::__construct($isAjax);
        $this->typeModel = new Admin_Models_Type();
    }

    public function getType($id = null){
        $id = $this->isAjax() ? intval($_POST['id']) : $id;

        $entity = $this->typeModel->getType($id);
        if(!$entity){
            $entity = new Entity_Type();
        }
        $toReplace = array(
            '{action}',
            '{option}',
            '{delete}',
            '{id_value}',
            '{title_value}',
            '{name_value}',
            '{seo_value}',
            '{fields}',
            '{fields-count}'
        );
        $fields = json_decode($entity->getJson(), true);
        $fieldsHTML = $this->typeModel->genFields($fields);
        $option = $this->typeModel->getAllTypesOption('id', $id);

        $replace = array(
            empty($id) ? 'add' : 'update',
            $option,
            empty($id) ? '' : '<i class="fa fa-times del delete-type"></i>',
            $entity->getId(),
            $entity->getTitle(),
            $entity->getName(),
            $entity->getSeo() == 1 ? 'checked="checked"' : '',
            $fieldsHTML,
            count($fields)
        );
        $file = file_get_contents(ADMIN.'/views/type.tpl');
        $result = str_replace($toReplace, $replace, $file);

        if($this->isAjax()){
            $this->putAjax($result);
        }

        return $result;
    }

    public function addType($data = null){
        $name = $this->isAjax() ? strip_tags($_POST['name']) : $data['name'];
        $title = $this->isAjax() ? strip_tags($_POST['title']) : $data['title'];
        $seo = $this->isAjax() ? intval($_POST['seo']) == 1 : intval($data['seo']) == 1;
        $json = array();
        $cnt = $this->isAjax() ? count($_POST['cnt']) : count($data['cnt']);
        for($i = 0; $i < $cnt; $i++){
            $tmp = array();
            $tmp['name'] = $this->isAjax() ? strip_tags($_POST['name-'.$i]) : $data['name-'.$i];
            $tmp['title'] = $this->isAjax() ? strip_tags($_POST['title-'.$i]) : $data['title-'.$i];
            $tmp['type'] = $this->isAjax() ? strip_tags($_POST['type-'.$i]) : $data['type-'.$i];
            $tmp['variants'] = array();
            $tmpCnt = $this->isAjax() ? count($_POST['variants-'.$i]) : count($data['variants-'.$i]);
            for($j = 0; $j < $tmpCnt; $j++){
                $tmp['variants'][] = $this->isAjax() ? strip_tags($_POST['variants-'.$i][$j]) : $data['variants-'.$i][$j];
            }
            $tmp['selects'] = $this->isAjax() ? strip_tags($_POST['selects-'.$i]) : $data['selects-'.$i];
            $tmp['int'] = $this->isAjax() ? intval($_POST['int-'.$i]) == 1 : intval($data['int-'.$i]) == 1;

            $json[] = $tmp;
        }

        $this->typeModel->addType($title, $name, $json, $seo);

        $result['error'] = false;
        $result['clear'] = false;
        $result['mess'] = 'Тип добавлен';

        if($this->isAjax()){
            $this->putJSON($result);
        }

        return $result;
    }

    public function deleteType($id = null){
        $id = $this->isAjax() ? intval($_POST['id']) : $id;

        $result = $this->typeModel->deleteType($id);

        if($this->isAjax()){
            $this->putAjax($result);
        }

        return $result;
    }

    public function updateType($data = null){
        $id = $this->isAjax() ? strip_tags($_POST['id']) : $data['id'];
        $name = $this->isAjax() ? strip_tags($_POST['name']) : $data['name'];
        $title = $this->isAjax() ? strip_tags($_POST['title']) : $data['title'];
        $seo = $this->isAjax() ? intval($_POST['seo']) == 1 : intval($data['seo']) == 1;
        $json = array();
        $cnt = $this->isAjax() ? count($_POST['cnt']) : count($data['cnt']);
        for($i = 0; $i < $cnt; $i++){
            $tmp = array();
            $tmp['name'] = $this->isAjax() ? strip_tags($_POST['name-'.$i]) : $data['name-'.$i];
            $tmp['title'] = $this->isAjax() ? strip_tags($_POST['title-'.$i]) : $data['title-'.$i];
            $tmp['type'] = $this->isAjax() ? strip_tags($_POST['type-'.$i]) : $data['type-'.$i];
            $tmp['variants'] = array();
            $tmpCnt = $this->isAjax() ? count($_POST['variants-'.$i]) : count($data['variants-'.$i]);
            for($j = 0; $j < $tmpCnt; $j++){
                $tmp['variants'][] = $this->isAjax() ? strip_tags($_POST['variants-'.$i][$j]) : $data['variants-'.$i][$j];
            }
            $tmp['selects'] = $this->isAjax() ? strip_tags($_POST['selects-'.$i]) : $data['selects-'.$i];
            $tmp['int'] = $this->isAjax() ? intval($_POST['int-'.$i]) == 1 : intval($data['int-'.$i]) == 1;

            $json[] = $tmp;
        }

        $this->typeModel->updateType($id, $title, $name, $json, $seo);

        $result['error'] = false;
        $result['clear'] = false;
        $result['mess'] = 'Тип обновлен';

        if($this->isAjax()){
            $this->putJSON($result);
        }

        return $result;
    }
}