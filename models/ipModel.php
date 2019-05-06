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
        $sql = 'SELECT COUNT(' . ipEntitiesNames::ID . ') as total, ' . ipEntitiesNames::NUM_VISITS . ' '
                . 'FROM '._DB_PREFIX_. ipEntitiesNames::NAME_TABLE . ' '
                . 'WHERE ' . ipEntitiesNames::IP . ' = "%s" '
                . 'AND ' . ipEntitiesNames::DATE . ' = "%s";';
        $sql = sprintf($sql, $_ip, $_date);
        
        return Db::getInstance()->ExecuteS($sql);
    }
    
    protected function insertIp(ipEntities $_obj) {
        $sql = 'INSERT INTO '._DB_PREFIX_. ipEntitiesNames::NAME_TABLE . ' '
            . '(' . ipEntitiesNames::ID . ', ' . ipEntitiesNames::IP . ', ' . ipEntitiesNames::DATE 
            . ', ' . ipEntitiesNames::NUM_VISITS . ', ' . ipEntitiesNames::BROWSER . ') '
            . 'VALUES (Null, "%s", "%s", %d, "%s");';
        $sql = sprintf($sql, $_obj->ip, $_obj->date, $_obj->visits, $_obj->browser);
        Db::getInstance()->Execute($sql);
        
    }
    
    protected function updateIp(ipEntities $_obj) {  
        $sql = 'UPDATE '._DB_PREFIX_. ipEntitiesNames::NAME_TABLE . ' '
            . 'SET ' . ipEntitiesNames::NUM_VISITS . ' = %d, ' . ipEntitiesNames::BROWSER . ' = "%s" ' 
            . 'WHERE ' . ipEntitiesNames::IP . ' = "%s" '
            . 'AND ' . ipEntitiesNames::DATE . ' = "%s";';
        $sql = sprintf($sql, $_obj->visits, $_obj->browser, $_obj->ip, $_obj->date);
        Db::getInstance()->Execute($sql);


    }
}
