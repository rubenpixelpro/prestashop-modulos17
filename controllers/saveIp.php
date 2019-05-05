<?php

class saveIpEntities {
    public $ip, $browser;
}

class saveIp extends ipModel {
    
    private $params;
    
    public function __construct(saveIpEntities $_obj) {
        $this->params = $_obj;
        parent::__construct();
    }
    
    public function saveIp() {
        $output = (OBJECT) array();
        $numVisits = $this->checkExist($this->params->ip, $this->getDate());
        if($numVisits > 0) {
            $this->updateIp($this->params);
        } else {
            $this->insertIp($this->params);
        }
        return $output;

    }
    
    private function getDate() {
    
    }
}
