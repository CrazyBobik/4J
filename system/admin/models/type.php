<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 23.11.2015
 * Time: 21:11
 */
class Admin_Models_Type{
    /**
     * @var DAO_Type
     */
    private $typeDAO;

    /**
     * Admin_Models_Type constructor.
     */
    public function __construct(){
        $this->typeDAO = new DAO_Type();
    }

    public function getType($id){
        return $this->typeDAO->getType($id);
    }

    public function getTypeByName($name){
        return $this->typeDAO->getTypeByName($name);
    }

    public function getAllTypes(){
        return $this->typeDAO->getAllTypes();
    }

    public function getAllTypesOption($key = '', $id = 0){
        $result = '';
        $res = $this->getAllTypes();
        $cnt = count($res);
        for($i = 0; $i < $cnt; $i++){
            $check = $key == 'id'
                ? $res[$i]->getId() == $id ? 'selected="selected"' : ''
                : '';
            $result .= '<option value="'.($key == 'id' ? $res[$i]->getId() : $res[$i]->getName())
                .'" '.$check.'>'.$res[$i]->getTitle().'</option>';
        }

        return $result;
    }

    public function addType($title, $name, $fields, $seo = false){
        if($this->typeDAO->createTable($name, $fields, $seo)){
            $this->typeDAO->writeType($title, $name, $fields, $seo);
        }

        $this->genEntity($name, $fields, $seo);
        $this->genInterface($name);
        $this->genDAO($name, $fields, $seo);
        $this->genMVC($name, $fields, $seo);

        /**Логика MVC
         * Есть entity,interface,dao,MVC
         * в interface,dao 4 метода(CRUD)
         * View представление в виде TPL с подстановкой основных значений
         * (если есть СЕО то оно как то выделено на етой страничке)
         * Model имеет 4-5 методов(CRUD 5-SEO если есть)
         * В модель приходят данные, они обрабатываются(валидируются) и кидаются в дао если
         * можно. Результат уходит контролерру.
         * Controller собирает данные и дает модели, решает что делать с результатом
         */
    }

    public function updateType($id, $title, $name, $fields, $seo = false){
        //TODO: обновление поля
        $type = $this->typeDAO->getType($id);
        if(!$type){
            throw new Exception('Такого типа не существует пока =)');
        }
        $add = $this->diffField(json_decode($type->getJson(), true), $fields);
        $del = $this->diffField($fields, json_decode($type->getJson(), true));
        $addSEO = 'hold';
        if($seo && !$type->getSeo()){
            $addSEO = 'add';
        } else if(!$seo && $type->getSeo()){
            $addSEO = 'del';
        }

        $this->typeDAO->updateTable($name, $add, $del, $addSEO);
        $this->typeDAO->updateType($id, $title, $name, $fields, $seo);

        $this->genEntity($name, $fields, $seo);
        $this->genInterface($name);
        $this->genDAO($name, $fields, $seo);
        $this->genMVC($name, $fields, $seo);
    }

    private function diffField($oldF, $newF){
        $result = array();
        $arrOld = array();

        $cnt = count($oldF);
        for($i = 0; $i < $cnt; $i++){
            $arrOld[] = $oldF[$i]['name'];
        }
        $cnt = count($newF);
        for($i = 0; $i < $cnt; $i++){
            if(!in_array($newF[$i]['name'], $arrOld)){
                $result[] = $newF[$i];
            }
        }

        return $result;
    }

    public function genEntity($name, $fields, $seo){
        $to_replace = array(
            '{class_name}',
            '{fields}',
            '{fields_init}',
            '{name}',
            '{get_and_set}'
        );
        $flds = '';
        $flds_init = '';
        $get_and_set = '';
        $cnt = count($fields);
        for($i = 0; $i < $cnt; $i++){
            $flds .= 'private $'.$fields[$i]['name'].' = '.($fields[$i]['int'] ? '0;' : '\'\';')."\r\n\t";
            $flds_init .= '$this->'.$fields[$i]['name'].' = $res[\''.$name.'_'.$fields[$i]['name'].'\'];'."\r\n\t\t";

            $file = file_get_contents(TPL_GEN_TYPE.'/get_and_set.tpl');
            $get_and_set .= str_replace(
                    array('{field_up}', '{field}'),
                    array(ucfirst($fields[$i]['name']), $fields[$i]['name']),
                    $file
                )."\r\n";
        }
        if($seo){
            $flds .= 'private $seoTitle = \'\';'."\r\n\t";
            $flds .= 'private $seoKeywords = \'\';'."\r\n\t";
            $flds .= 'private $seoDescription = \'\';'."\r\n\t";

            $flds_init .= '$this->seoTitle = $res[\''.$name.'_seo_title\'];'."\r\n\t\t";
            $flds_init .= '$this->seoKeywords = $res[\''.$name.'_seo_keywords\'];'."\r\n\t\t";
            $flds_init .= '$this->seoDescription = $res[\''.$name.'_seo_description\'];'."\r\n\t\t";

            $file = file_get_contents(TPL_GEN_TYPE.'/get_and_set.tpl');
            $get_and_set .= str_replace(
                    array('{field_up}', '{field}'),
                    array(ucfirst('seoTitle'), 'seoTitle'),
                    $file
                )."\r\n";
            $file = file_get_contents(TPL_GEN_TYPE.'/get_and_set.tpl');
            $get_and_set .= str_replace(
                    array('{field_up}', '{field}'),
                    array(ucfirst('seoKeywords'), 'seoKeywords'),
                    $file
                )."\r\n";
            $file = file_get_contents(TPL_GEN_TYPE.'/get_and_set.tpl');
            $get_and_set .= str_replace(
                    array('{field_up}', '{field}'),
                    array(ucfirst('seoDescription'), 'seoDescription'),
                    $file
                )."\r\n";
        }
        $replace = array(
            ucfirst($name),
            $flds,
            $flds_init,
            $name,
            $get_and_set
        );
        $file = file_get_contents(TPL_GEN_TYPE.'/entity_type.tpl');
        $result = str_replace(
            $to_replace,
            $replace,
            $file
        );
        file_put_contents(ENTITY.'/'.$name.'.php', $result);
    }

    public function genInterface($name){
        $to_replace = array(
            '{class_name}',
            '{name}'
        );
        $replace = array(
            ucfirst($name),
            $name
        );
        $file = file_get_contents(TPL_GEN_TYPE.'/interface.tpl');
        $result = str_replace(
            $to_replace,
            $replace,
            $file
        );
        file_put_contents(DAO.'/interface/'.$name.'.php', $result);
    }

    public function genDAO($name, $fields, $seo){
        $to_replace = array(
            '{class_name}',
            '{name}',
            '{add_param}',
            '{add_sql_param}',
            '{add_sql_values}',
            '{add_bind_param}',
            '{update_sql_param}',
            '{seo_bind_param}',
            '{seo_add_param}'
        );
        $add_param = '';
        $add_sql_param = '';
        $add_sql_values = '';
        $add_bind_param = '';
        $update_sql_param = '';

        $cnt = count($fields);
        for($i = 0; $i < $cnt; $i++){
            $add_param .= '$'.$fields[$i]['name']
                .' = $'.$name.'->get'.ucfirst($fields[$i]['name']).'();'."\r\n\t\t";
            $add_sql_param .= '`'.$name.'_'.$fields[$i]['name'].'`,';
            $add_sql_values .= ':'.$fields[$i]['name'].',';
            $add_bind_param .= '$stmt->bindParam(\':'.$fields[$i]['name'].'\', $'
                .$fields[$i]['name'].');'."\r\n\t\t";
            $update_sql_param .= '`'.$name.'_'.$fields[$i]['name'].'`=:'.$fields[$i]['name'].','."\r\n\t\t\t\t\t\t\t\t\t";
        }
        $seoBindParam = '';
        $seoAddParam = '';
        if($seo){
            $update_sql_param .= '`'.$name.'_seo_title`=:seo_title,'."\r\n\t\t\t\t\t\t\t\t\t";
            $update_sql_param .= '`'.$name.'_seo_keywords`=:seo_keywords,'."\r\n\t\t\t\t\t\t\t\t\t";
            $update_sql_param .= '`'.$name.'_seo_description`=:seo_description,'."\r\n\t\t\t\t\t\t\t\t\t";

            $seoBindParam .= '$stmt->bindParam(\':seo_title\', $seo_title);'."\r\n\t\t";
            $seoBindParam .= '$stmt->bindParam(\':seo_keywords\', $seo_keywords);'."\r\n\t\t";
            $seoBindParam .= '$stmt->bindParam(\':seo_description\', $seo_description);'."\r\n\t\t";

            $seoAddParam .= "\r\n\t\t".'$seo_title = $'.$name.'->getSeoTitle();';
            $seoAddParam .= "\r\n\t\t".'$seo_keywords = $'.$name.'->getSeoKeywords();';
            $seoAddParam .= "\r\n\t\t".'$seo_description = $'.$name.'->getSeoDescription();';
        }
        $add_param = trim($add_param, "\r\n\t\t");
        $add_sql_param = trim($add_sql_param, ',');
        $add_sql_values = trim($add_sql_values, ',');
        $update_sql_param = trim($update_sql_param, ",\r\n\t\t\t\t\t\t\t\t\t");

        $replace = array(
            ucfirst($name),
            $name,
            $add_param,
            $add_sql_param,
            $add_sql_values,
            $add_bind_param,
            $update_sql_param,
            $seoBindParam,
            $seoAddParam
        );
        $file = file_get_contents(TPL_GEN_TYPE.'/dao.tpl');
        $result = str_replace(
            $to_replace,
            $replace,
            $file
        );
        file_put_contents(DAO.'/types/'.$name.'.php', $result);
    }

    public function genMVC($name, $fields, $seo){
        $this->genView($name, $fields, $seo);
        $this->genModel($name);
        $this->genController($name, $fields, $seo);
    }

    public function genView($name, $fields, $seo){
        $toReplace = array(
            '{name}',
            '{class_name}',
            '{fields}',
            '{seo}',
            '{tree}'
        );
        $fieldsHTML = '';
        $seoHTML = '';
        $cnt = count($fields);
        for($i = 0; $i < $cnt; $i++){
            switch($fields[$i]['type']){
                case 'textarea':
                    $file = file_get_contents(TPL.'/generation/form/textarea.tpl');

                    break;
                case 'checkbox':
                    $file = file_get_contents(TPL.'/generation/form/checkbox.tpl');

                    $tmp = '';
                    $cntJ = count($fields[$i]['variants']);
                    for($j = 0; $j < $cntJ; $j++){
                        $tmp .= "\r\n\t\t\t\t".'<div class="row-variants">'."\r\n\t\t\t\t\t"
                            .'<input type="checkbox" name="'.$name.'_'.$fields[$i]['name'].'[]" value="'.$fields[$i]['variants'][$j].'" {'.$fields[$i]['name'].'_'.$j.'_value}
					 	   id="'.$name.'_'.$fields[$i]['name'].'_'.$j.'" class="in-radio">
					<label for="'.$name.'_'.$fields[$i]['name'].'_'.$j.'">
						'.$fields[$i]['variants'][$j].'
					</label>
				</div>';
                    }
                    $file = str_replace('{checkbox}', $tmp, $file);
                    break;
                case 'radio':
                    $file = file_get_contents(TPL.'/generation/form/radio.tpl');

                    $tmp = '';
                    $cntJ = count($fields[$i]['variants']);
                    for($j = 0; $j < $cntJ; $j++){
                        $tmp .= "\r\n\t\t\t\t".'<div class="row-variants">'."\r\n\t\t\t\t\t"
                            .'<input type="radio" name="'.$name.'_'.$fields[$i]['name'].'" value="'.$fields[$i]['variants'][$j]
                            .'" {'.$fields[$i]['name'].'_'.$j.'_value}
						   id="'.$name.'_'.$fields[$i]['name'].'_'.$j.'" class="in-radio">
					<label for="'.$name.'_'.$fields[$i]['name'].'_'.$j.'">
						'.$fields[$i]['variants'][$j].'
					</label>
				</div>';
                    }
                    $file = str_replace('{radio}', $tmp, $file);
                    break;
                case 'select':
                    $file = file_get_contents(TPL.'/generation/form/select.tpl');

                    $tmp = '';
                    $cntJ = count($fields[$i]['variants']);
                    for($j = 0; $j < $cntJ; $j++){
                        $tmp .= "\r\n"."\t\t\t\t\t".'<option value="'.$fields[$i]['variants'][$j].'" {'.$fields[$i]['name'].'_'.$j.'_value}>'
                            .$fields[$i]['variants'][$j].'</option>';
                    }
                    $file = str_replace('{option}', $tmp, $file);
                    break;
                case 'file':
                    $file = file_get_contents(TPL.'/generation/form/file.tpl');
                    break;
                case 'hidden':
                    $file = file_get_contents(TPL.'/generation/form/hidden.tpl');
                    break;
                default:
                    $file = file_get_contents(TPL.'/generation/form/default.tpl');
                    $file = str_replace('{type}', $fields[$i]['type'], $file);
            }

            $toReplaceRow = array(
                '{id}',
                '{title}',
                '{name}',
                '{value}'
            );
            $replaceRow = array(
                $name.'_'.$fields[$i]['name'],
                $fields[$i]['title'],
                $name.'_'.$fields[$i]['name'],
                '{'.$fields[$i]['name'].'_value}'
            );
            $result = str_replace(
                $toReplaceRow,
                $replaceRow,
                $file
            );
            $fieldsHTML .= $result;
        }

        if($seo){
            $seoHTML = '<div class="seo_part">'."\r\n\t\t\t";
            $seoHTML .= '<div class="row">
				<label for="seo_title" class="row-item">SEO Титулка</label>
				<div class="row-item">
				    <input class="in in-text" type="text" value="{seo_title_value}" name="seo_title"
					        id="seo_title">
				</div>
			</div>'."\r\n\t\t\t";
            $seoHTML .= '<div class="row">
				<label for="seo_keywords" class="row-item">SEO Ключи</label>
				<div class="row-item">
				    <textarea class="in in-area" name="seo_keywords" id="seo_keywords">{seo_keywords_value}</textarea>
				</div>
			</div>'."\r\n\t\t\t";
            $seoHTML .= '<div class="row">
				<label for="seo_description" class="row-item">SEO Описание</label>
				<div class="row-item">
				    <textarea class="in in-area" name="seo_description" id="seo_description">{seo_description_value}</textarea>
				</div>
			</div>'."\r\n\t\t";
            $seoHTML .= '</div>';
        }

        $tree = $this->genTreeRows();

        $replace = array(
            $name,
            ucfirst($name),
            $fieldsHTML,
            $seoHTML,
            $tree
        );
        $file = file_get_contents(TPL_GEN_TYPE.'/view.tpl');
        $result = str_replace(
            $toReplace,
            $replace,
            $file
        );
        file_put_contents(ADMIN.'/views/types/'.$name.'.tpl', $result);
    }

    public function genModel($name){
        $toReplace = array(
            '{class_name}',
            '{name}'
        );
        $replace = array(
            ucfirst($name),
            $name
        );
        $file = file_get_contents(TPL_GEN_TYPE.'/model.tpl');
        $result = str_replace($toReplace, $replace, $file);
        file_put_contents(ADMIN.'/models/types/'.$name.'.php', $result);
    }

    public function genController($name, $fields, $seo){
        $toReplace = array(
            '{class_name}',
            '{name}',
            '{to_replace}',
            '{entity_get}',
            '{seo_get}',
            '{entity_set}',
            '{seo_set}'
        );
        $to_repl = '';
        $entityGet = '';
        $entitySet = '';
        $cnt = count($fields);
        for($i = 0; $i < $cnt; $i++){
            $to_repl .= '\'{'.$fields[$i]['name'].'_value}\','."\r\n\t\t\t";
            $entityGet .= '$entity->get'.ucfirst($fields[$i]['name']).'(),'."\r\n\t\t\t";
            $entitySet .= '$entity->set'.ucfirst($fields[$i]['name'])
                .'($this->isAjax() ? strip_tags($_POST[\''.$name.'_'.$fields[$i]['name'].'\']) : $data[\''
                .$name.'_'.$fields[$i]['name'].'\']);'."\r\n\t\t";
        }
        $seoGet = '';
        $seoSet = '';
        if($seo){
            $to_repl .= '\'{seo_title_value}\','."\r\n\t\t\t";
            $to_repl .= '\'{seo_keywords_value}\','."\r\n\t\t\t";
            $to_repl .= '\'{seo_description_value}\'';

            $seoGet .= '$entity->getSeoTitle(),'."\r\n\t\t\t";
            $seoGet .= '$entity->getSeoKeywords(),'."\r\n\t\t\t";
            $seoGet .= '$entity->getSeoDescription()';

            $seoSet .= '$entity->setSeoTitle($this->isAjax() ? strip_tags($_POST[\'seo_title\']) : $data[\'seo_title\']);'."\r\n\t\t";
            $seoSet .= '$entity->setSeoKeywords($this->isAjax() ? strip_tags($_POST[\'seo_keywords\']) : $data[\'seo_keywords\']);'."\r\n\t\t";
            $seoSet .= '$entity->setSeoDescription($this->isAjax() ? strip_tags($_POST[\'seo_description\']) : $data[\'seo_description\']);'."\r\n";
        } else{
            $to_repl = trim($to_repl, ",\r\n\t\t\t");
            $entityGet = trim($entityGet, ",\r\n\t\t\t");
            $entitySet = trim($entitySet, ",\r\n\t\t");
        }

        $replace = array(
            ucfirst($name),
            $name,
            $to_repl,
            $entityGet,
            $seoGet,
            $entitySet,
            $seoSet
        );
        $file = file_get_contents(TPL_GEN_TYPE.'/controller.tpl');
        $result = str_replace($toReplace, $replace, $file);
        file_put_contents(ADMIN.'/controllers/types/'.$name.'.php', $result);
    }

    private function genTreeRows(){
        $tree = '';
        $file = file_get_contents(TPL.'/generation/form/default.tpl');
        $toReplaceRow = array(
            '{id}',
            '{title}',
            '{name}',
            '{type}',
            '{value}'
        );
        $replaceRow = array(
            'tree_title',
            'Титулка в дереве',
            'title',
            'text',
            '{tree_title}'
        );
        $result = str_replace(
            $toReplaceRow,
            $replaceRow,
            $file
        );
        $tree .= $result."\r\n";
        $file = file_get_contents(TPL.'/generation/form/default.tpl');
        $toReplaceRow = array(
            '{id}',
            '{title}',
            '{name}',
            '{type}',
            '{value}'
        );
        $replaceRow = array(
            'tree_name',
            'Название(name) в дереве',
            'name',
            'text',
            '{tree_name}'
        );
        $result = str_replace(
            $toReplaceRow,
            $replaceRow,
            $file
        );
        $tree .= $result."\r\n";
        $file = file_get_contents(TPL.'/generation/form/hidden.tpl');
        $toReplaceRow = array(
            '{id}',
            '{name}',
            '{value}'
        );
        $replaceRow = array(
            'tree_pid',
            'pid',
            '{tree_pid}'
        );
        $result = str_replace(
            $toReplaceRow,
            $replaceRow,
            $file
        );
        $tree .= $result;

        return $tree;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteType($id){
        $type = $this->typeDAO->getType($id);
        $id = $type->getId();
        if(empty($id)){
            return false;
        }

        $r1 = $this->deleteFromDB($type);
        $r2 = $this->deleteFromFileSystem($type);

        return $r1 && $r2;
    }

    /**
     * @param Entity_Type $type
     * @return bool
     */
    private function deleteFromDB(&$type){
        $r1 = $this->typeDAO->dropTable($type->getName());
        $r2 = $this->typeDAO->deleteType($type->getId());

        return $r1 && $r2;
    }

    /**
     * @param Entity_Type $type
     * @return bool
     */
    private function deleteFromFileSystem(&$type){
        $r1 = unlink(ENTITY.'/'.$type->getName().'.php');
        $r2 = unlink(DAO.'/interface/'.$type->getName().'.php');
        $r3 = unlink(DAO.'/types/'.$type->getName().'.php');
        $r4 = unlink(ADMIN.'/views/types/'.$type->getName().'.tpl');
        $r5 = unlink(ADMIN.'/models/types/'.$type->getName().'.php');
        $r6 = unlink(ADMIN.'/controllers/types/'.$type->getName().'.php');

        return $r1 && $r2 && $r3 && $r4 && $r5 && $r6;
    }

    public function genFields($fields){
        $fieldsHTML = '';
        $cnt = count($fields);
        for($i = 0; $i < $cnt; $i++){
            $fieldsHTML .= '<div class="form-field" data-id="'.$i.'">'.
                '<div class="del-form-field"><i class="fa fa-times"></i></div>'.
                '<div class="toggle-form-field"><i class="fa fa-plus"></i></div>'.
                '<div class="title">'.$fields[$i]['title'].'</div>'.
                '<div class="form-rows" style="display: none">'.
                '<input type="hidden" name="cnt[]" value="1">'.
                '<input type="hidden" name="type-'.$i.'" value="'.$fields[$i]['type'].'">'.
                '<div class="row">'.
                '<label for="title-'.$i.'" class="row-item">Титул</label>'.
                '<div class="row-item">'.
                '<input class="in in-text" type="text" name="title-'.$i.'" id="title-'.$i.'" value="'.$fields[$i]['title'].'">'.
                '</div>'.
                '</div>'.
                '<div class="row">'.
                '<label for="name-'.$i.'" class="row-item">Название(name)</label>'.
                '<div class="row-item">'.
                '<input class="in in-text" type="text" name="name-'.$i.'" id="name-'.$i.'" value="'.$fields[$i]['name'].'">'.
                '</div>'.
                '</div>';
            if ($fields[$i]['type'] === 'checkbox' ||
                $fields[$i]['type'] === 'radio' || $fields[$i]['type'] === 'select'){
                $fieldsHTML .= '<div class="row">'.
                    '<label for="int-'.$i.'" class="row-item">Варианты</label>'.
                    '<div class="row-item">';

                $cntJ = count($fields[$i]['variants']);
                for($j = 0; $j < $cntJ; $j++){
                    $fieldsHTML .= '<div class="row-variants">'.
                    '<input class="in-radio" type="radio" name="selects-'.$i.'" value="'.$j.'" '
                        .($j == $fields[$i]['selects'] ? 'checked="checked"' : '').'>'.
                    '<input class="in in-text" type="text" name="variants-'.$i.'[]" value="'
                        .$fields[$i]['variants'][$j].'">'.
                    '</div>';
                }

                $fieldsHTML .= '<div class="add-variants btn btn-green btn-small" data-id="'.$i.'">'.
                    'Еще <i class="fa fa-plus"></i>'.
                    '</div>'.
                    '</div>'.
                    '</div>';
            }
            $fieldsHTML .= '<div class="row">'.
                '<label class="row-item">Integer</label>'.
                '<div class="row-item">'.
                '<div class="row-variants">'.
                '<input class="in-radio" type="radio" name="int-'.$i.'" id="int-'.$i.'" value="1" '
                .($fields[$i]['int'] ? 'checked="checked"' : '').'>'.
                '<label for="int-'.$i.'">Да</label>'.
                '</div>'.
                '<div class="row-variants">'.
                '<input class="in-radio" type="radio" name="int-'.$i.'" id="int-'.$i.'-no" value="0" '
                .($fields[$i]['int'] ? '' : 'checked="checked"').'>'.
                '<label for="int-'.$i.'-no">Нет</label>'.
                '</div>'.
                '</div>'.
                '</div>'.
                '</div>'.
                '</div>'.
                '<div class="clear"></div>';
        }

        return $fieldsHTML;
    }
}