<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 11.10.2015
 * Time: 12:34
 */
class Admin_Controllers_Main extends Parents_ControllerAdmin{

    private $blocks = array(
        array(
            'name' => 'Blocks_Head',
            'side' => 'header'
        ),
        array(
            'name' => 'Blocks_Menu',
            'side' => 'left'
        ),
        array(
            'name' => 'Blocks_SettingsPanel',
            'side' => 'right'
        )
    );

    /**
     * Admin_Controllers_Main constructor.
     */
    public function __construct(){
        $this->model = new Admin_Models_Main();

        if(Libs_Session::start()->isAdmin()){
            $langM = new Modules_Controllers_Lang();
            $langM->setConfigs();

            $result = $this->model->routers(Libs_URL::get()->getPath());

            //TODO - как оно будет работать
            /**
             * если есть такой контролер мы вызываем его метод
             * если путджсон или аджакс то дальше в главном ниче не выполнится иначе
             * в главном контролере подключаем лейаут и возвращаем все
             */
            $center = false;
            if($result){
                $cnt = count($result);
                for($i = 0; $i < $cnt; $i++){
                    $this->blocks[] = $result[$i];
                }
            } else{
                if($controller = $this->model->correctAddr()){
                    $ajax = Libs_URL::get()->getPiceURL(3) === 'ajax';
                    $link = Libs_URL::get()->getPiceURL(2);
                    if(isset($link) && !empty($link)){
                        $center = new $controller($ajax);
                        $center = $center->$link();
                    } else{
                        ob_start();
                        new $controller($ajax);
                        $center = ob_get_clean();
                        ob_end_clean();
                    }
                } else{
                    header('HTTP/1.0 404 Not Found');
                    header('Location: /404');
                }
            }

            $layout = $this->getLayoutWithStyle();
            $toReplace = array(
                '{header}',
                '{left}',
                '{center}',
                '{right}',
                '{footer}'
            );
            $replace = $this->model->getBlocks($this->blocks);
            if($center !== false){
                $replace[2] = $center;
            }
            $replace = array(
                $replace[0],
                $replace[1],
                $replace[2],
                $replace[3],
                $replace[4]
            );

            $layout = str_replace($toReplace, $replace, $layout);
            $this->render($layout);
        } else{
            $this->render($this->getTPL('login'));
        }
    }

    public function getLayoutWithStyle(){
        $layout = $this->getTPL('main');
        $style = Libs_Session::start()->getParam('style');
        if(!$style){
            $style = 'blue';
        }
        $layout = str_replace('{style}', $style, $layout);

        return $layout;
    }
}