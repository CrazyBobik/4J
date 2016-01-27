<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 27.01.2016
 * Time: 11:48
 */
class Libs_FileWorker{
	/**
	 * Максимальный размер 2мб(по умолчанию)
	 * @var int
	 */
	private $maxSize = 2097152;
	private $name;

	public function setMaxSize($size){
		$this->maxSize = $size;
		return $this;
	}

	public function uploadFile($name){
		if(!is_uploaded_file($_FILES[$name]['tmp_name'])){
			$this->name = '';
			return $this->name;
		}
		if($_FILES[$name]['size'] > $this->maxSize ||
			$_FILES[$name]['error'] != UPLOAD_ERR_OK){
			return false;
		}
		$type = preg_replace('/.*\./ui', '', $_FILES[$name]['name']);
		$this->name = uniqid().time().'.'.$type;
		if(move_uploaded_file($_FILES[$name]['tmp_name'], UPLOAD.'/'.$this->name)){
			return $this->getName();
		} else{
			return false;
		}
	}

	public function removeFile($name){
		if($name !== '' && file_exists(UPLOAD.'/'.$name)){
			unlink(UPLOAD.'/'.$name);
		}
	}

	/**
	 * @return mixed
	 */
	public function getName(){
		return $this->name;
	}
}