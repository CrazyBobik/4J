<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 11.10.2015
 * Time: 12:25
 */
class Ajax{

	protected $isAjax;

	/**
	 * Ajax constructor.
	 * @param $isAjax
	 */
	public function __construct($isAjax){
		$this->isAjax = $isAjax;
	}

	protected function putJSON($item){
		die(json_encode($item));
	}

	protected function putAjax($item){
		die($item);
	}

	public function isAjax(){
		return $this->isAjax;
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
}