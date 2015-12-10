<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 11.10.2015
 * Time: 16:43
 */
class Libs_Validator{

	private $dict = array();
	private $errors = array();
	private $fields = array();
	private $valid = true;

	/**
	 * Libs_Validator constructor.
	 * @param $fields
	 * @param string $dict
	 * @throws Exception
	 */
	public function __construct($fields, $dict = ''){
		$this->fields = $fields;
		if ($dict === ''){
			$this->setDict(CONFIG.'/validator/form.ini');
		} else {
			$this->setDict($dict);
		}
	}

	public function isValid($target, $validation){
		foreach ($validation as $name => $items){
			foreach ($items as $k => $v){
				if (method_exists($this, $k)){
					if (!$this->$k($v, $target[$name], $name)){
						$this->valid = false;
					}
				} else{
					throw new Exception('Method not found');
				}
			}
		}

		return $this->valid;
	}

	private function required($bool, $target, $key){
		if ($bool){
			if (isset($target) && !empty($target)){
				return true;
			} else{
				$this->errors[] = '<b>'.$this->fields[$key].'</b> - '
					.$this->dict['REQUIRED'];

				return false;
			}
		} else {
			return true;
		}
	}

	private function min($min, $target, $key){
		if ($target >= $min){
			return true;
		} else{
			$this->errors[] = '<b>'.$this->fields[$key].'</b> - '
				.sprintf($this->dict['MIN'], $min);

			return false;
		}
	}

	private function max($max, $target, $key){
		if ($target <= $max){
			return true;
		} else{
			$this->errors[] = '<b>'.$this->fields[$key].'</b> - '
				.sprintf($this->dict['MAX'], $max);

			return false;
		}
	}

	private function minLength($min, $target, $key){
		if (strlen($target) >= $min){
			return true;
		} else{
			$this->errors[] = '<b>'.$this->fields[$key].'</b> - '
				.sprintf($this->dict['MIN_LENGTH'], $min);

			return false;
		}
	}

	private function maxLength($max, $target, $key){
		if (strlen($target) <= $max){
			return true;
		} else{
			$this->errors[] = '<b>'.$this->fields[$key].'</b> - '
				.sprintf($this->dict['MAX_LENGTH'], $max);

			return false;
		}
	}

	public function setDict($dict){
		if (file_exists($dict)){
			$this->dict = parse_ini_file($dict);
		} else {
			throw new Exception('File not found');
		}
	}

	public function getErrors(){
		if (count($this->errors) > 0){
			return implode('<br>', $this->errors);
		} else {
			return false;
		}
	}
}