<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 30.01.2016
 * Time: 15:27
 */
class Parents_AjaxUpload extends Parents_Ajax{

    public function __construct($isAjax){
        parent::__construct($isAjax);
    }

    public function uploadFile($name){
        $fileWorker = new Libs_FileWorker();
        $nameFile = $fileWorker->uploadFile($name);
        if ($nameFile === false){
            $json = array('error' => true, 'mess' => 'Ошибка загрузки файла');
            $this->putJSON($json);
        }
        if(isset($_POST[$name.'_old']) && !empty($_POST[$name.'_old'])){
            if (empty($nameFile)){
                $nameFile = strip_tags($_POST[$name.'_old']);
            } else{
                $fileWorker->removeFile(strip_tags($_POST[$name.'_old']));
            }
        }

        return $nameFile;
    }

    public function removeFile($name){
        $fileWorker = new Libs_FileWorker();
        $fileWorker->removeFile($name);
    }
}