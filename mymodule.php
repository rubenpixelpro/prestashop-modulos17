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
    
    
    protected function getConfigForm() {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Live mode'),
                        'name' => 'MYMODULE_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in live mode'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Enter a valid email address'),
                        'name' => 'MYMODULE_ACCOUNT_EMAIL',
                        'label' => $this->l('Email'),
                    ),
                    array(
                        'type' => 'password',
                        'name' => 'MYMODULE_ACCOUNT_PASSWORD',
                        'label' => $this->l('Password'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }
    
    protected function getConfigFormValues () {
        return array(
            'MYMODULE_LIVE_MODE' => Configuration::get('MYMODULE_LIVE_MODE', true),
            'MYMODULE_ACCOUNT_EMAIL' => Configuration::get('MYMODULE_ACCOUNT_EMAIL', 'contact@pixelpro.com'),
            'MYMODULE_ACCOUNT_PASSWORD' => Configuration::get('MYMODULE_ACCOUNT_PASSWORD', null),
        );
    }
    
    protected function renderForm() {
        $helper = new HelperForm();
        
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitMymodule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
                . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
        
        return $helper->generateForm(array($this->getConfigForm()));
        
    }
    
    protected function postProcess() {
        $formValues = $this->getConfigFormValues();
        
        foreach(array_keys($formValues) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
    
        }
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
        
        if((bool) Tools::isSubmit('submitMymodule')) {
            $this->postProcess();
    
        }
        $this->context->smarty->assign($this->name, array(
            'path' => $this->_path
        ));
        
        $customTpl = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
        $autoGenerateTpl = $this->renderForm();
        
        return $autoGenerateTpl . $customTpl;
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
