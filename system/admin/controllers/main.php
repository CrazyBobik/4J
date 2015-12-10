<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 11.10.2015
 * Time: 12:34
 */
class Admin_Controllers_Main extends Controllers_Controller{

	/**
	 * Admin_Controllers_Main constructor.
	 */
	public function __construct(){
		$this->model = new Admin_Models_Main();

		parent::__construct();
	}

	public function index(){
		if (Libs_Session::start()->isAdmin()){
			$result = $this->model->routers(Libs_URL::get()->getPath());

			//TODO - как оно будет работать
			/**
			 * если есть такой контролер мы вызываем его метод
			 * если путджсон или аджакс то дальше в главном ниче не выполнится иначе
			 * в главном контролере подключаем лейаут и возвращаем все
			 */
			if ($result){
				$layout = $this->getTPL('main');
				$toReplace = array(
					'{header}',
					'{left}',
					'{center}',
					'{right}',
					'{footer}'
				);
				$replace = $this->model->getBlocks($result);

				$layout = str_replace($toReplace, $replace, $layout);
				echo $layout;
			} else {
				if ($controller = $this->model->correctAddr()){
					$link = Libs_URL::get()->getPiceURL(2);
					$controller->$link();
				} else {
					header('HTTP/1.0 404 Not Found');
					header('Location: /404');
				}
			}
		} else {
			echo $this->getTPL('login');
		}
	}

	public function getTPL($name){
		return file_get_contents(ADMIN.'/views/'.$name.'.tpl');
	}
}