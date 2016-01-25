<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 25.01.2016
 * Time: 21:27
 */
class Admin_Models_Blocks_SettingsPanel{
    private $views;

    /**
     * Admin_Models_Blocks_SettingsPanel constructor.
     */
    public function __construct(){
        $this->views = ADMIN.'/views/blocks/settingspanel';
    }


    public function genTabs(){
        $tabs = file_get_contents($this->views.'/tabs.tpl');

        return $tabs;
    }

    public function genTabsContext(){
        $allTabs = '';

        $allTabs .= $this->genFirstTab();
        $allTabs .= $this->genSecondTab();
        $allTabs .= $this->genThirdTab();

        return $allTabs;
    }

    public function genFirstTab(){
        $tab = file_get_contents($this->views.'/first.tpl');

        return $tab;
    }

    public function genSecondTab(){
        $tab = file_get_contents($this->views.'/second.tpl');

        return $tab;
    }

    public function genThirdTab(){
        $tab = file_get_contents($this->views.'/third.tpl');

        return $tab;
    }
}