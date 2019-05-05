<?php

abstract class ipEntitiesNames {
    const NAME_TABLE = 'save_ip';
    const ID = 'id';
    const IP = 'ip';
    const BROWSER = 'browser';
    const DATE = 'date';
    const NUM_VISITS = 'visits';
}

class ipEntities {
    public $date,
    $visits,
    $browser;   
}

class ipModel extends Module {
    public function __construct() {
        
    }
    
    protected function checkExist($_ip, $_date) {
        
    }
    
    protected function insertIp(ipEntities $_obj) {
        
    }
    
    protected function updateIp(ipEntities $_obj) {    

    }
}
