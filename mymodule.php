<?php

if(!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class mymodule extends Module implements WidgetInterface{
    
    public $controls = array();
    
    public $button = array();
    
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
        
        $this->createControls();
        
        $this->getDependencies();
    }
    
    private function getDependencies() {
        require_once 'classes/getProductByCatId.php';
        require_once 'models/ipModel.php';
        require_once 'controllers/saveIp.php';
        //require_once 'classes/dbTest.php';
    }
        
    protected function createControls() {
        
        $this->controls['MYMODULE_SAVE_NAME'] = array(
            'controlName' => 'MYMODULE_SAVE_NAME',
            'values' => null,
            'label' => $this->l('Name'),
            'desc' => $this->l('Enter your Name')
        );        
        $this->controls['MYMODULE_SAVE_LAST_NAME'] = array(
            'controlName' => 'MYMODULE_SAVE_LAST_NAME',
            'values' => null,
            'label' => $this->l('Last Name'),
            'desc' => $this->l('Enter your Last Name')
        );
        $this->controls['MYMODULE_HTML'] = array(
            'controlName' => 'MYMODULE_HTML',
            'values' => null,
            'label' => $this->l('HTML'),
            'desc' => $this->l('Escribe tu html personalizado')
        );
        // Button Save
        $this->button['MYMODULE_SAVE_FORM'] = array(
            'controlName' => 'MYMODULE_SAVE_FORM',
            'label' => $this->l('Save')
       
        );
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
    
    protected function customPostProcess() {    
        $languages = $this->context->controller->getLanguages();
        foreach($this->controls as $control) {
            foreach($languages as $lang) {
                $composeName = $control['controlName'] . '_' . $lang["id_lang"];
                Configuration::updateValue($composeName, Tools::getValue($composeName),true);
            }
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
        
        if((bool) Tools::isSubmit($this->button['MYMODULE_SAVE_FORM']['controlName'])) {
            $this->customPostProcess();
        }
        
        $this->getCustomValues(); 
        
        $this->context->smarty->assign($this->name, array(
            'path' => $this->_path,
            'languagesArray' => $this->context->controller->getLanguages(),
            'currentLang' => $this->context->language->id,
            'customControls' => $this->controls,
            'saveButton' => $this->button,
            'postAction' => $this->context->link->getAdminLink('AdminModules', false).'&configure='
                .$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name 
                .'&token='.Tools::getAdminTokenLite('AdminModules')
        ));
        
               
        $customTpl = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
        $autoGenerateTpl = $this->renderForm();
        
        return $autoGenerateTpl . $customTpl;
    }
    
    protected function getCustomValues() {
        foreach($this->controls as $control) {
	    $this->controls[$control['controlName']]['values'] = $this->getLangValues($control['controlName']);
        }
    }
    
    public function getLangValues($_controlName) {
        $languages = Language::getLanguages(false);
        $values = array();
        foreach($languages as $lang) {
            $composeName = $_controlName . '_' . $lang["id_lang"];
            $values[$lang["id_lang"]] = Configuration::get($composeName);
        }
        return $values;
    }
    
    private function test() {
       echo '<h1>Bases de datos</h1>';
        
       $testDb = new dbTest();
       //$testDb->select();
       //$testDb->insert();
       //$testDb->update();
       //$testDb->delete();
       //$testDb->sanitize();
       //$testDb->sprintF();
      
       
       exit();
    }
    
    public function hookHeader() {        
        $this->context->controller->registerJavascript('modules-mymodule',
            'modules/'.$this->name.'/views/js/mymoduleFront.js',
            ['position' => 'bottom', 'priority' => 150]);
        $saveIpEntities = new saveIpEntities();
        $saveIpEntities->ip = $this->checkLocalhost(Tools::getRemoteAddr());
        $saveIpEntities->browser = Tools::getUserBrowser(); 
        $saveIp = new saveIp($saveIpEntities);
        $saveIp->saveIp();
        
        
    }
    
    private function checkLocalhost($_ip) {
        $ip = null;
         switch ($_ip) {
            case '::1':
                $ip = Tools::getServerName();
                break;
            default :
                $ip = $_ip;
        }
        return $ip;
    }
    
    public function hookFooter() {
       
    }
    
    public function hookBackOfficeHeader() {
        $this->context->controller->addCSS($this->_path.'views/css/mymoduleAdmin.css');
    }
    
    public function hookDisplayHome() {
        $this->getCustomValues();
        
        $categoriesArray = $this->cleanCategoriesData(Category::getCategories());
        
        $getProduct = new getProductByCatId((int)$categoriesArray[1]['id_category'], 1);
        
        $this->context->smarty->assign($this->name, array(
            'path' => $this->_path,
            'html' => $this->controls['MYMODULE_HTML'],
            'currentLanguage' => $this->context->language->id,
            'comboCategories' => $categoriesArray,
            'getProductByCategoryId' => $getProduct->productCategory
        ));
        
        return $this->context->smarty->fetch($this->local_path.'views/templates/hook/displayHome.tpl');
    }
    
    public function cleanCategoriesData($_array) {
        $cleanArray = array();
        
        foreach($_array as $key => $catVal) {
            if(is_array($catVal)) {
                foreach($catVal as $category) {
                    $cleanArray[$key] = array(
                        'id_category' => $category['infos']['id_category'],
                        'name' => $category['infos']['name'],
                        'link_rewrite' => $category['infos']['link_rewrite'],
                    );
                }
               
            }
     
        }
        unset($cleanArray[0]);
        
        return $cleanArray;
        
    }
    
    public function hookDisplayLeftColumn() {
        
    }
    
    public function renderWidget($hookName, array $configuration) {
        
    }
    
    public function getWidgetVariables($hookName, array $configuration) {
        
    }
}
