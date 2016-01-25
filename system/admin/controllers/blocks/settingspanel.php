<?php

class Admin_Controllers_Blocks_SettingsPanel extends Controllers_Controller{
    private $panelModel;

    /**
     * Admin_Controllers_Blocks_SettingsPanel constructor.
     */
    public function __construct(){
        $this->panelModel = new Admin_Models_Blocks_SettingsPanel();
        parent::__construct();
    }


    public function index(){
        $tpl = $this->getTPL('blocks/settingspanel/settingspanel');
        $toReplace = array(
            '{tabs}',
            '{tabsContext}'
        );
        $replace = array(
            $this->panelModel->genTabs(),
            $this->panelModel->genTabsContext()
        );
        $html = str_replace($toReplace, $replace, $tpl);
        $this->render($html);
    }

    public function getTPL($name){
        return file_get_contents(ADMIN.'/views/'.$name.'.tpl');
    }
}