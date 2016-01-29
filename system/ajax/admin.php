<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 11.10.2015
 * Time: 13:01
 */
class Admin extends Ajax{

	/**
	 * Admin constructor.
	 */
	public function __construct(){
		if (Libs_Session::start()->isAdmin()){
			parent::__construct(true);
		} else {
			if (Libs_URL::get()->checkPath('login', 2)){
				parent::__construct(true);
			} else{
				die('You not Admin');
			}
		}
	}

	public function login(){
		$json = array();

		$data = array(
			'login' => strip_tags($_POST['name']),
			'pass' => strip_tags($_POST['pass'])
		);
		$valid = array(
			'login' => array('required' => true),
			'pass' => array('required' => true)
		);
		$fields = array(
			'login' => 'Логин',
			'pass' => 'Пароль'
		);

		$validator = new Libs_Validator($fields);

		if ($validator->isValid($data, $valid)){
			$res = DAO_Admin_Login::getUser($data['login'], md5($data['pass']));

			if (empty($res)){
				$json['error'] = true;
				$json['mess'] = 'Не верный логин или пароль';
			} else{
				Libs_Session::start()->setParam('admin_id', $res['id']);

				$json['callback'] = 'window.location.reload()';
			}
		} else {
			$json['error'] = true;
			$json['mess'] = $validator->getErrors();
		}

		$this->putJSON($json);
	}
}