<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 19.01.2016
 * Time: 17:47
 */
class Modules_Models_Lang{
	private $langDAO;
	private $KEY_LANG = 'lang';

	/**
	 * Admin_Models_Lang constructor.
	 */
	public function __construct(){
		$this->langDAO = new DAO_Lang();
	}


	/**
	 * @return Entity_Tree[]
	 */
	public function getLangs(){
		return $this->langDAO->getLangs();
	}

	public function genLangHTML(){
		$html = '';
		$tpl = file_get_contents(MODULES.'/views/lang/one-lang.tpl');
		$res = $this->getLangs();
		$cnt = count($res);
		for($i = 0; $i < $cnt; $i++){
			$toReplace = array(
				'{lang}'
			);
			$replace = array(
				$res[$i]->getLink(),
				$res[$i]->getLink()
			);
			$html .= str_replace($toReplace, $replace, $tpl);
		}

		return $html;
	}

	public function setAdminLang(&$lang){
		if($this->isCorrectLang($lang)){
			return Libs_Session::start()->setParam($this->KEY_LANG, $lang);
		} else{
			return false;
		}
	}

	public function getAdminLang(){
		return Libs_Session::start()->getParam($this->KEY_LANG);
	}

	public function setConfigs(){
		if($lang = Libs_Session::start()->getParam($this->KEY_LANG)){
			Config::$lang = $lang;
			return true;
		} else{
			return false;
		}
	}

	public function isCorrectLang(&$lang){
		$langs = $this->getLangs();
		$cnt = count($langs);
		for($i = 0; $i < $cnt; $i++){
			if($langs[$i]->getLink() === $lang){
				return true;
			}
		}

		return false;
	}
}