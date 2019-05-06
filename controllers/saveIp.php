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
        if($numVisits[0]['total'] > 0) {
            $visits = (int) $numVisits[0]['visits'];
            $update = new ipEntities();
            $update->visits = ($visits + 1);
            $update->ip = $this->params->ip;
            $update->date = $this->getDate();
            $update->browser = $this->params->browser;
            $this->updateIp($update);
        } else {
            $update = new ipEntities();
            $update->visits = 1;
            $update->date = $this->getDate();
            $update->ip = $this->params->ip;
            $update->browser = $this->params->browser;
            $this->insertIp($update);
        }
        return $output;

    }
    
    private function getDate() {
        return date("Y-m-d 00:00:00");
    }
}
