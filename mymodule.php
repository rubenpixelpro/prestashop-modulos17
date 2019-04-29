<?php

if(!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class mymodule extends Module implements WidgetInterface{
    
    public function __construct() {
        
        $this->name = "mymodule";
        
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Rubén Córcoles';
        $this->need_instance = 0;
        
        $this->bootstrap = true;
        
        parent::__construct();
        
        $this->displayName = $this->trans('Mi primer módulo', array(), 'Modules.mymodule.Admin');
        $this->description = $this->trans('Módulo desde cero con el equipo de Pixelpro.', array(), 'Admin.Global');
        $this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
    }
    
    
    public function install() {
       Configuration::updateValue('MYMODULE_LIVE_MODE', false);
       
       return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayHome') && 
            $this->registerHook('displayLeftColumn') &&
            $this->registerHook('footer');
    }

    public function uninstall() {
        Configuration::deleteByName('MYMODULE_LIVE_MODE');
        
        return parent::uninstall();

    }
    
    public function getContent() {
        $this->context->smarty->assign($this->name, array(
            'path' => $this->_path
        ));
        
        return $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
    }
    
    public function hookHeader() {        

}
    
    public function hookFooter() {
       
    }
    
    public function hookBackOfficeHeader() {

    }
    
    public function hookDisplayHome() {
        $this->context->smarty->assign($this->name, array(
            'path' => $this->_path
        ));
        
        return $this->context->smarty->fetch($this->local_path.'views/templates/hook/displayHome.tpl');
    }
    
    public function hookDisplayLeftColumn() {
        
    }
    
    public function renderWidget($hookName, array $configuration) {
        
    }
    
    public function getWidgetVariables($hookName, array $configuration) {
        
    }
}
