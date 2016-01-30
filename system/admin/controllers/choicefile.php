<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 29.01.2016
 * Time: 16:23
 */
class Admin_Controllers_ChoiceFile extends Parents_AjaxUpload{

	public function __construct($isAjax = true){
		parent::__construct($isAjax);
	}

	public function genHTML(){
		$file = $this->getTPL('oneitem');
		$html = '';

		$allFiles = glob(UPLOAD.'/*');
		$cnt = count($allFiles);
		for($i = 0; $i < $cnt; $i++){
			$name = preg_replace('/.*\//ui', '', $allFiles[$i]);
			$toReplace = array(
				'{class}',
				'{title}',
				'{element}'
			);
			$replace = array(
				'choice',
				'Выбрать этот файл',
				'<img src="/upload/'.$name.'" alt="">'
			);
			$html .= str_replace($toReplace, $replace, $file);
		}

		$toReplace = array(
			'{class}',
			'{title}',
			'{element}'
		);
		$replace = array(
			'upload',
			'Загрузить новый файл',
			'<i class="fa fa-camera"></i>'
		);
		$html .= str_replace($toReplace, $replace, $file);

		if($this->isAjax()){
			$this->putAjax($html);
		}
		return $html;
	}

	public function genHiddenForm(){
		$html = $this->getTPL('form');
		return $html;
	}

	public function fileUpload(){
		if($this->uploadFile('file')){
			$json = array(
				'error' => false,
				'mess' => 'Файл загружен',
				'callback' => 'function callback(){reloadChoiceFile();}'
			);
		} else{
			$json = array(
				'error' => true,
				'mess' => 'Файл не загружен'
			);
		}

		$this->putJSON($json);
	}

	private function getTPL($name){
		return file_get_contents(ADMIN.'/views/choicefile/'.$name.'.tpl');
	}
}