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
		if($this->isAjax()){
			$this->putAjax($this->genItems());
		}
		return $this->genItems();
	}

	public function genGalleryHTML(){
		$html = '<div class="gallery">';
		$html .= $this->genItems();
		$html .= '</div>';
		$html .= $this->genHiddenForm(1);

		if($this->isAjax()){
			$this->putAjax($html);
		}
		return $html;
	}

	public function genHiddenForm($val = 0){
		$html = $this->getTPL('form');
		return str_replace('{value}', $val, $html);
	}

	public function fileUpload(){
		if($this->uploadFile('file')){
			$json = array(
				'error' => false,
				'mess' => 'Файл загружен'
			);
			if(intval($_POST['gallery']) == 1){
				$json['callback'] = 'function callback(){reloadGalleryFile();}';
			} else{
				$json['callback'] = 'function callback(){reloadChoiceFile();}';
			}
		} else{
			$json = array(
				'error' => true,
				'mess' => 'Файл не загружен'
			);
		}

		$this->putJSON($json);
	}

	public function removeFile($name){
		parent::removeFile(strip_tags($_POST['name']));
	}

	private function getTPL($name){
		return file_get_contents(ADMIN.'/views/choicefile/'.$name.'.tpl');
	}

	private function genItems(){
		$file = $this->getTPL('oneitem');
		$html = '';

		$allFiles = glob(UPLOAD.'/*');
		$cnt = count($allFiles);
		for($i = 0; $i < $cnt; $i++){
			$name = preg_replace('/.*\//ui', '', $allFiles[$i]);
			$toReplace = array(
				'{class}',
				'{title}',
				'{element}',
				'{del}'
			);
			$replace = array(
				'choice',
				'Выбрать этот файл',
				'<img src="/upload/'.$name.'" alt="">',
				'<i class="fa fa-close del del-img" data-name="'.$name.'"></i>'
			);
			$html .= str_replace($toReplace, $replace, $file);
		}

		$toReplace = array(
			'{class}',
			'{title}',
			'{element}',
			'{del}'
		);
		$replace = array(
			'upload',
			'Загрузить новый файл',
			'<i class="fa fa-camera"></i>',
			'',
		);
		$html .= str_replace($toReplace, $replace, $file);

		return $html;
	}
}